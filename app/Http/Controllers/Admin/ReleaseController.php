<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Release;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator; 
use App\Rules\FutureDate;
use FFMpeg\FFMpeg;
use App\Http\Requests\ValidateTrackRequest;
use DB;
use Illuminate\Support\Facades\Storage;
class ReleaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $releases = Release::where('user_id', $user_id)->with('tracks')->orderBy('created_at', 'desc')->paginate(5);
        return view('admin.releases.index',['releases'=>$releases]);
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //   return view('admin.releases.step1');
    // }

    public function step1(){
        return view('admin.releases.step1');
    }

    public function saveStep1(Request $request) {

        $user_id = Auth::user()->id;
        $validateData = $request->validate([
            'format' => 'required|in:single,ep,album',
            'release_name' => 'required|string|max:255',
            'release_version' => 'required|string|max:255',
            'release_code' =>'required|string|numeric', 
            'upc' => 'required|string|numeric' 
            
        ]);

        $validateData['user_id'] = $user_id;
        $release = Release::create($validateData);

        return redirect()->route('releases.step2', ['release_id'=>$release->id, 'level'=>'basic']);
    }
    
    //step2 is associated with basic, artwork, uploadTrack and editTrack forms 
    public function step2(Request $request){

        $release = Release::with('tracks')->find($request->release_id);
        $level = $request->level;

        if ($request->has('summary')) {

            return view('admin.releases.step2', ['release' => $release, 'level'=> $level, 'summary'=>$request->summary])->with('success', 'Basic information updated successfully.');
        }

        return view('admin.releases.step2', ['release' => $release, 'level'=> $level]);
    }

    public function saveBasic(Request $request) {

        $user_id = Auth::user()->id;
        $release =  Release ::find($request->release_id);

        // if($user_id != $music->user_id) {
        //     abort(403, 'Unauthorized action!');
        // }

        $validatedData = $request->validate([
          
            'upc' => 'required|string|numeric',
            'release_code' => 'required|string|numeric',
            'meta_language' => 'required|string|max:255',
            'release_name' => 'required|string|max:255',
            'release_version' => 'required|string',
            'primary_artist_basic' => 'required|string|max:255',
            'featuring_artist_basic' => 'required|string|max:255',
            'producer_artist_basic'=> 'required|string|max:255',
            'remixer_artist_basic'=>'required|string|max:255',
            'genre'=> 'required|string|max:255',
            'sub_genre' => 'required|string|max:255',
            'format' => 'required|in:single,ep,album',
            'cname_basic' => 'required|string|max:255|regex:/^\d{4}.*$/',
            'pname_basic' => 'required|string|max:255|regex:/^\d{4}.*$/',
            'original_release_date' => ['required', new FutureDate],
            'sales_date' => ['required', new FutureDate],

        ],
        [
            'cname_basic.regex' => 'The cname must start with a 4-digit year followed by a string.',
            'pname_basic.regex' => 'The pname must start with a 4-digit year followed by a string.',
        ]
    );

        $release->upc = $validatedData['upc'];
        $release->release_code = $validatedData['release_code'];
        $release->meta_language = $validatedData['meta_language'];
        $release->release_name = $validatedData['release_name'];
        $release->release_version = $validatedData['release_version'];
        $release->primary_artist = $validatedData['primary_artist_basic'];
        $release->featuring_artist = $validatedData['featuring_artist_basic'];
        $release->producer = $validatedData['producer_artist_basic'];
        $release->remixer = $validatedData['remixer_artist_basic'];
        $release->genre = $validatedData['genre'];
        $release->sub_genre = $validatedData['sub_genre'];
        $release->format = $validatedData['format'];
        $release->cname = $validatedData['cname_basic'];
        $release->pname = $validatedData['pname_basic'];
        $release->original_release_date = $validatedData['original_release_date'];
        $release->sales_date = $validatedData['sales_date'];
        
        $release->save();

        if($request->summary){
        
            return redirect()->route('releases.step2', ['release_id'=>$release->id, 'level'=>$request->summary])->with('success', 'Basic information updated successfully.');
        }
        return redirect()->route('releases.step2', ['release_id'=>$release->id, 'level'=>'artwork' ]);

    }
    
    // public function saveArtwork(Request $request) {
    //     $user_id = Auth::user()->id;
    //     $release_id = $request->release_id;
    //     $release =Release::find($release_id);
    //     dd($request);

    //     if ($release && !empty($release->thumbnail_path) && !$request->hasFile('thumbnail')) {
    //         // nothing to do
    //     }else{

    //         $validatedData = $request->validate([
    //             'thumbnail' => 'required|file|mimes:jpeg,tiff|dimensions:min_width=300,min_height=300,max_width=6000,max_height=6000',
    //         ],[
    //             'thumbnail.mimes' => 'The thumbnail must be a file of type: TIF, JPG.',
    //             'thumbnail.dimensions' => 'The thumbnail must be between 1600 x 1600 pixels and 6000 x 6000 pixels.',
    //          ]);

    //          // Check if there is an existing thumbnail and delete it
    //         if (!empty($release->thumbnail_path)) {
    //             Storage::disk('public')->delete($release->thumbnail_path);
    //         }
            
    //          $path = $request->file('thumbnail')->storeAs(
    //             'music/'.$user_id.'/'.$release_id.'/thumbnail',
    //             $request->file('thumbnail')->getClientOriginalName(), 'public'
    //         );
    //         $release->thumbnail_path = $path;

           
    //     }
    //     $release->save();
    //     return redirect()->route('releases.step2', ['release_id'=>$release->id, 'level'=>'uploadtrack']);

    // }
    public function saveArtwork(Request $request) {
        $user_id = Auth::user()->id;
        $release_id = $request->release_id;
        $release = Release::find($release_id);
        if ( !empty($release->thumbnail_path) && empty($request->thumbnail) || empty($request->filename)) {
            //nothing to do
          
        }else{

            if (empty($request->thumbnail) || empty($request->filename)) {
                 return back()->withErrors(['file' => 'No file was uploaded']);
            }

            $base64String = $request->input('thumbnail');
            list($metadata, $base64Data) = explode(';base64,', $base64String);
       
            preg_match('/data:image\/([^;]+)/', $metadata, $matches);
            $fileType = $matches[1] ?? 'png'; 

            if (!in_array($fileType, ['jpeg', 'jpg', 'tif', 'tiff'])) {
                return back()->withErrors(['file' => 'The thumbnail must be a file of type: JPEG, JPG, TIF, or TIFF.']);
            }
        
            $base64Data = str_replace(' ', '+', $base64Data);
            $imageData = base64_decode($base64Data);
        
            if ($imageData === false) {
                return back()->withErrors(['file' => 'Base64 decode failed']);
            }
        
            // Create an image resource from the string need default gd library enbale ext. php.ini
            $image = imagecreatefromstring($imageData);
            if ($image === false) {
                return back()->withErrors(['file' => 'Invalid image data']);
            }
        
            // Get image dimensions
            $width = imagesx($image);
            $height = imagesy($image);
        
            if ($width < 300 || $height < 300 || $width > 6000 || $height > 6000) {
                return back()->withErrors(['file' => 'The thumbnail must be between 300 x 300 pixels and 6000 x 6000 pixels.']);
            }

            if ($width != $height ) {
                return back()->withErrors(['file' => 'The thumbnail must be a square.']);
            }
    
            if (!empty($release->thumbnail_path)) {
                Storage::disk('public')->delete($release->thumbnail_path);
            }
        
            $filePath = 'music/' . $user_id . '/' . $release_id . '/' .  $request->filename;
            Storage::disk('public')->put($filePath, $imageData);
        
            $release->thumbnail_path = $filePath;
            $release->save();
        }

        
        if($request->summary){
        
            return redirect()->route('releases.step2', ['release_id'=>$release->id, 'level'=>$request->summary])->with('success', 'Artwork  updated successfully.');
        }
      
        return redirect()->route('releases.step2', ['release_id' => $release->id, 'level' => 'uploadtrack']);
    }
    
    
    

    public function saveUploadTrack(Request $request) {

    
        $user_id = Auth::user()->id;
        $release_id = $request->release_id;
        $release = Release::find($release_id);
        $format = $release->format;
    
        switch ($format) {
            case 'ep':
                $count = 5;
                $countFileError = "You can upload a maximum of $count files in EP Format.";
                break;
            case 'album':
                $count = 30;
                $countFileError = "You can upload a maximum of $count files in Album Format.";
                break;
            default:
                $count = 1;
                $countFileError = "You can upload a Single file.";
                break;
        }
    
        $validatedData = $request->validate([
            'track_paths.*' => 'required|file|mimes:audio/mpeg,mpga,mp3,wav,aac', // specify additional audio formats as needed
        ]);
    
        $trackPaths = $request->file('track_paths') ?? [];
    
        if (count($trackPaths) > $count) {
            return back()->withErrors(['track_paths' => $countFileError])->withInput();
        }
    
        // Initialize FFMpeg
        $ffmpeg = FFMpeg::create();
    
        foreach ($trackPaths as $track) {
            $path = $track->storeAs('music/' . $user_id . '/' . $release_id . '/tracks', $track->getClientOriginalName(), 'public');
    
            $audio = $ffmpeg->open($track->getPathname());
            $format = $audio->getFormat();
            $durationInSeconds = $format->get('duration');
            $durationFormatted = $this->convertDurationToMinutesSeconds($durationInSeconds);
    
            $trackData = [
                'user_id' => $user_id,
                'release_id' => $release_id,
                'track_path' => $path,
                'track_duration' => $durationFormatted
            ];
            Track::create($trackData);
        }
    
        if ($request->summary) {
            return redirect()->route('releases.step2', ['release_id' => $release->id, 'level' => $request->summary])->with('success', 'Tracks updated successfully.');
        }
        return redirect()->route('releases.step2', ['release_id' => $release_id, 'level' => 'edittrack']);
    }

    public function saveEditTrack(Request $request) {
        $track_ids = $request->track_id;
        $release_id = $request->release_id;
    
        $rules = [];
        $messages = [];
    
        for ($i = 0; $i < count($track_ids); $i++) {
            $rules['track_name.' . $i] = 'required|string|max:255';
            $rules['track_version.' . $i] = 'required|string|max:50';
            $rules['lyrics_language.' . $i] = 'required|string|max:50';
            $rules['explicit_content.' . $i] = 'required|string|max:50';
            $rules['primary_artist.' . $i] = 'required|string|max:255';
            $rules['featuring_artist.' . $i] = 'nullable|string|max:255';
            $rules['track_remixer.' . $i] = 'nullable|string|max:255';
            $rules['song_writer.' . $i] = 'required|string|max:255';
            $rules['track_producer.' . $i] = 'required|string|max:255';
            $rules['composer_name.' . $i] = 'required|string|max:255';
            $rules['label_name.' . $i] = 'required|string|max:255';
            $rules['isrc.' . $i] = 'required|string|max:255';
            $rules['primary_performers.' . $i] = 'required|string|max:255';
            $rules['pname.' . $i] = 'required|string|max:255';
            $rules['cname.' . $i] = 'required|string|max:255';
            $rules['ownership_for_sound_rec.' . $i] = 'required|string|max:255';
            $rules['country_of_rec.' . $i] = 'required|string|max:255';
            $rules['nationality.' . $i] = 'required|string|max:255';
    
            $index = $i + 1;
    
            $messages['track_name.' . $i . '.required'] = "Track name at track- $index is required.";
            $messages['track_version.' . $i . '.required'] = "Track version at track- $index is required.";
            $messages['lyrics_language.' . $i . '.required'] = "Lyrics language at track- $index is required.";
            $messages['explicit_content.' . $i . '.required'] = "Explicit content at track- $index is required.";
            $messages['primary_artist.' . $i . '.required'] = "Primary artist at track- $index is required.";
            $messages['featuring_artist.' . $i . '.nullable'] = "Featuring artist at track- $index is required.";
            $messages['track_remixer.' . $i . '.nullable'] = "Track remixer at track- $index is required.";
            $messages['song_writer.' . $i . '.required'] = "Song writer at track- $index is required.";
            $messages['track_producer.' . $i . '.required'] = "Track producer at track- $index is required.";
            $messages['composer_name.' . $i . '.required'] = "Composer name at track- $index is required.";
            $messages['label_name.' . $i . '.required'] = "Label name at track- $index is required.";
            $messages['isrc.' . $i . '.required'] = "ISRC code at track- $index is required.";
            $messages['primary_performers.' . $i . '.required'] = "Primary performer at track- $index is required.";
            $messages['pname.' . $i . '.required'] = "Publisher name at track- $index is required.";
            $messages['cname.' . $i . '.required'] = "Composer name at track- $index is required.";
            $messages['ownership_for_sound_rec.' . $i . '.required'] = "Ownership for sound recording at track- $index is required.";
            $messages['country_of_rec.' . $i . '.required'] = "Country of recording at track- $index is required.";
            $messages['nationality.' . $i . '.required'] = "Nationality at track- $index is required.";
        }
    
        //$validatedData = $request->validate($rules, $messages);
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'edittrack');
        }
    

        DB::beginTransaction(); // Start a transaction
        try {
            foreach($track_ids as $key => $track_id) {
            
                    $track = Track::findOrFail($track_id); 
                    $track->track_name = $request->track_name[$key];
                    $track->track_version = $request->track_version[$key];
                    $track->lyrics_language = $request->lyrics_language[$key];
                    $track->explicit_content = $request->explicit_content[$key];
                    $track->track_primary_artist = $request->primary_artist[$key];
                    $track->track_featuring_artist = $request->featuring_artist[$key];
                    $track->track_remixer = $request->track_remixer[$key];
                    $track->song_writer = $request->song_writer[$key];
                    $track->track_producer = $request->track_producer[$key];
                    $track->composer_name = $request->composer_name[$key];
                    $track->track_label_name = $request->label_name[$key];
                    $track->isrc = $request->isrc[$key];
                    $track->track_performers = $request->primary_performers[$key];
                    $track->pname = $request->pname[$key];
                    $track->cname = $request->cname[$key];
                    $track->ownership_for_sound_rec = $request->ownership_for_sound_rec[$key];
                    $track->country_of_rec = $request->country_of_rec[$key];
                    $track->nationality = $request->nationality[$key];
                    $track->save();
            }
               // If all tracks are saved successfully, then update the release status
                $release = Release::findOrFail($release_id);
                $release->form_status = 1;
                $release->save();
                DB::commit(); // Commit the transaction

                if($request->summary){
        
                    return redirect()->route('releases.step2', ['release_id'=>$release->id, 'level'=>$request->summary])->with('success', 'Tracks updated successfully.');
                }
              return redirect()->route('releases.step2',['release_id'=>$release_id, 'level'=>'summery'])->with('success', 'Tracks and release updated successfully.');

        }
        catch (\Exception $e) {
            // Handle the error, log it, or return a custom error response
            DB::rollback();
            return redirect()->back()->withErrors(['error' => 'Failed to update tracks and release: ' . $e->getMessage()], 'edittrack');
        }

      
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
    }

    /**
     * Display the specified resource.
     */
    public function show(Release $release)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Release $release)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Release $release)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Release $release)
    {
        //
    }






    //helper function

    public function convertDurationToMinutesSeconds($durationInSeconds) {
        $minutes = floor($durationInSeconds / 60);
        $seconds = $durationInSeconds % 60;
        return sprintf('%02d:%02d', $minutes, $seconds);
    }
}
