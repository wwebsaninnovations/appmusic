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
class ReleaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $user_id = Auth::user()->id;
        // $musics  = Music::where('user_id',$user_id)->paginate(3);
        return view('admin.releases.index');
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
        $release = Release::find( $request->release_id);
        $level = $request->level;

        $tracks = Track::where('release_id',$request->release_id)->get();
      
        return view('admin.releases.step2', ['release' => $release, 'tracks'=>$tracks, 'level'=> $level]);
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
        $release->genre = $validatedData['genre'];
        $release->sub_genre = $validatedData['sub_genre'];
        $release->format = $validatedData['format'];
        $release->cname = $validatedData['cname_basic'];
        $release->pname = $validatedData['pname_basic'];
        $release->original_release_date = $validatedData['original_release_date'];
        $release->sales_date = $validatedData['sales_date'];
        $release->save();
       
        return redirect()->route('releases.step2', ['release_id'=>$release->id, 'level'=>'artwork']);

    }
    
    public function saveArtwork(Request $request) {
        $user_id = Auth::user()->id;
        $release_id = $request->release_id;
        $validatedData = $request->validate([
            'thumbnail' => 'required|file|mimes:jpeg,tiff|dimensions:min_width=1600,min_height=1600,max_width=6000,max_height=6000',
        ],[
            'thumbnail.mimes' => 'The thumbnail must be a file of type: TIF, JPG.',
            'thumbnail.dimensions' => 'The thumbnail must be between 1600 x 1600 pixels and 6000 x 6000 pixels.',
         ]);

        $path = $request->file('thumbnail')->storeAs(
            'music/'.$user_id.'/'.$release_id.'/thumbnail',
            $request->file('thumbnail')->getClientOriginalName(), 'public'
        );

        $release =Release::find($release_id);
        $release->thumbnail_path = $path;
        $release->save();
        return redirect()->route('releases.step2', ['release_id'=>$release->id, 'level'=>'uploadtrack']);

    }

    public function saveUploadTrack(Request $request) {

    
        $user_id = Auth::user()->id;
        $release_id = $request->release_id;
        $validatedData = $request->validate([
            'track_paths.*' => 'required|file|mimes:audio/mpeg,mpga,mp3,wav,aac', // specify additional audio formats as needed
        ]);

        // Initialize FFMpeg
        $ffmpeg = FFMpeg::create();

        foreach ($request->file('track_paths') as $track) {
            $path = $track->storeAs('music/'.$user_id.'/'. $release_id.'/tracks',$track->getClientOriginalName(), 'public');  

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
            $track = Track::create($trackData);
        }
        return redirect()->route('releases.step2', ['release_id'=>$release_id, 'level'=>'edittrack']);
    }

    public function saveEditTrack(Request $request) {
        $track_ids = $request->track_id;
        $release_id = $request->release_id;
        $validatedData = $request->validate( [
            'track_name' => 'required|array',
            'track_name.*' => 'required|string|max:255|index_increment',
            'track_version' => 'required|array',
            'track_version.*' => 'required|string|max:50|index_increment',
            'lyrics_language' => 'required|array',
            'lyrics_language.*' => 'required|string|max:50|index_increment',
            'explicit_content' => 'required|array',
            'explicit_content.*' => 'required|string|max:50|index_increment',
            'primary_artist' => 'required|array',
            'primary_artist.*' => 'required|string|max:255|index_increment',
            'featuring_artist' => 'nullable|array',
            'featuring_artist.*' => 'nullable|string|max:255|index_increment',
            'track_remixer' => 'nullable|array',
            'track_remixer.*' => 'nullable|string|max:255|index_increment',
            'song_writer' => 'required|array',
            'song_writer.*' => 'required|string|max:255|index_increment',
            'track_producer' => 'required|array',
            'track_producer.*' => 'required|string|max:255|index_increment',
            'composer_name' => 'required|array',
            'composer_name.*' => 'required|string|max:255|index_increment',
            'label_name' => 'required|array',
            'label_name.*' => 'required|string|max:255|index_increment',
            'isrc' => 'required|array',
            'isrc.*' => 'required|string|max:255|index_increment',
            'primary_performers' => 'required|array',
            'primary_performers.*' => 'required|string|max:255|index_increment',
            'pname' => 'required|array',
            'pname.*' => 'required|string|max:255|index_increment',
            'cname' => 'required|array',
            'cname.*' => 'required|string|max:255|index_increment',
            'ownership_for_sound_rec' => 'required|array',
            'ownership_for_sound_rec.*' => 'required|string|max:255|index_increment',
            'country_of_rec' => 'required|array',
            'country_of_rec.*' => 'required|string|max:255|index_increment',
            'nationality' => 'required|array',
            'nationality.*' => 'required|string|max:255|index_increment',
        ], [
            'track_name.required' => 'Track names are required.',
            'track_name.*.required' => 'Track name at index :index is required.',
            'track_version.required' => 'Track versions are required.',
            'track_version.*.required' => 'Track version at index :index is required.',
            'lyrics_language.required' => 'Lyrics languages are required.',
            'lyrics_language.*.required' => 'Lyrics language at index :index is required.',
            'explicit_content.required' => 'Explicit content is required.',
            'explicit_content.*.required' => 'Explicit content at index :index is required.',
            'primary_artist.required' => 'Primary artists are required.',
            'primary_artist.*.required' => 'Primary artist at index :index is required.',
            'song_writer.required' => 'Song writers are required.',
            'song_writer.*.required' => 'Song writer at index :index is required.',
            'track_producer.required' => 'Track producers are required.',
            'track_producer.*.required' => 'Track producer at index :index is required.',
            'composer_name.required' => 'Composer names are required.',
            'composer_name.*.required' => 'Composer name at index :index is required.',
            'label_name.required' => 'Label names are required.',
            'label_name.*.required' => 'Label name at index :index is required.',
            'isrc.required' => 'ISRC codes are required.',
            'isrc.*.required' => 'ISRC code at index :index is required.',
            'primary_performers.required' => 'Primary performers are required.',
            'primary_performers.*.required' => 'Primary performer at index :index is required.',
            'pname.required' => 'Publisher names are required.',
            'pname.*.required' => 'Publisher name at index :index is required.',
            'cname.required' => 'Composer names are required.',
            'cname.*.required' => 'Composer name at index :index is required.',
            'ownership_for_sound_rec.required' => 'Ownership for sound recording is required.',
            'ownership_for_sound_rec.*.required' => 'Ownership for sound recording at index :index is required.',
            'country_of_rec.required' => 'Country of recording is required.',
            'country_of_rec.*.required' => 'Country of recording at index :index is required.',
            'nationality.required' => 'Nationalities are required.',
            'nationality.*.required' => 'Nationality at index :index is required.',
        ]);

        // foreach($track_ids  as $key=> $track_id )  {
        //     $track =Track::find($track_id);
        //     $track->track_name = $request->track_name[$key];
        //     $track->track_version = $request->track_version[$key];
        //     $track->lyrics_language =  $request->lyrics_language[$key];
        //     $track->save();
        // }  
        return redirect()->route('releases.step2', ['release_id'=>$release_id, 'level'=>'schedulingPricing']);

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
