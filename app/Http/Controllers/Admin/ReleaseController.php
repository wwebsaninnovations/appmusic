<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Release;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator; 
use App\Rules\FutureDate;
// use FFMpeg\FFMpeg;
use App\Http\Requests\ValidateTrackRequest;
use DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Platform;
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

    public function getReleaseData(Request $request)
    {
        $user_id = Auth::id(); // Using Auth::id() directly to get the authenticated user's ID
        $columns = ['srn','id', 'thumbnail_path', 'release_name', 'format', 'release_code', 'upc', 'status'];
    
        $length = $request->input('length');
        $column = $request->input('order.0.column', 0); // Index of column to sort, default to 0
        $dir = $request->input('order.0.dir', 'desc'); // Order direction
        $searchValue = $request->input('search.value');
    
        // Validate column index
        if (!isset($columns[$column])) {
            $column = 0; // Default to the first column if invalid
        }
    
        $query = Release::where('user_id', $user_id)
                        ->with('tracks') // Assuming 'tracks' is a relationship defined in your Release model
                        ->orderBy($columns[$column], $dir);
    
        if ($searchValue) {
            $query->where(function($q) use ($searchValue) {
                $q->where('release_name', 'like', "%{$searchValue}%")
                  ->orWhere('format', 'like', "%{$searchValue}%")
                  ->orWhere('release_code', 'like', "%{$searchValue}%")
                  ->orWhere('upc', 'like', "%{$searchValue}%")
                  ->orWhere(function ($q) use ($searchValue) {
                      if (strtolower($searchValue) == 'pending') {
                          $q->orWhere('status', 0);
                      } elseif (strtolower($searchValue) == 'approved') {
                          $q->orWhere('status', 1);
                      } elseif (strtolower($searchValue) == 'rejected') {
                          $q->orWhere('status', 2);
                      }
                  })
                  ->orWhere(function ($q) use ($searchValue) {
                    if (strtolower($searchValue) == 'incomplete') {
                        $q->orWhere('form_status', 0);
                    } elseif (strtolower($searchValue) == 'complete') {
                        $q->orWhere('form_status', 1);
                    } 
                });
            });
        }
    
        $totalRecords = $query->count();
        $releases = $query->offset($request->input('start'))->limit($length)->get();
    
        $data = [];
    
        if ($releases->isNotEmpty()) {
            $count = 1;
            foreach ($releases as $release) {
                $status = match ($release->status) {
                    0 => 'Pending',
                    1 => 'Approved',
                    default => 'Rejected'
                };
                $form_status = match ($release->form_status) {
                    0 => 'Incomplete',
                    1 => 'Complete',
                };


    
                $data[] = [
                    'srn'         =>$count++,
                    'id'           => $release->id,
                    'thumbnail'    => $release->thumbnail_path, // Adjust this to match your actual attribute name
                    'release_name' => $release->release_name,
                    'format'       => $release->format, // Adjust attribute name to lowercase 'format'
                    'code'         => $release->release_code,
                    'upc'          => $release->upc,
                    'status'       => $status,
                    'form_status'  => $form_status
                ];
            }
        }
    
        // Count total approved, pending, rejected, and incomplete
        $totalApproved = Release::where('user_id', $user_id)->where('status', 1)->count();
        $totalPending = Release::where('user_id', $user_id)->where('status', 0)->count();
        $totalRejected = Release::where('user_id', $user_id)->where('status', 2)->count();
        $totalComplete = Release::where('user_id', $user_id)->where('form_status', 1)->count();
        $totalIncomplete = Release::where('user_id', $user_id)->where('form_status', 0)->count();
        // Count total tracks across all releases
        $totalTracks = 0;
        // Count total tracks from approved releases only
        $totalTracksApproved = 0;

        foreach ($releases as $release) {
            $totalTracks += $release->tracks->count();

            if ($release->status == 1) {
                $totalTracksApproved += $release->tracks->count();
            }
        }

        return response()->json([
            'data' => $data,
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'totalApproved' => $totalApproved,
            'totalPending' => $totalPending,
            'totalRejected' => $totalRejected,
            'totalComplete' => $totalComplete,
            'totalIncomplete' => $totalIncomplete,
            'totalTracks'=>$totalTracks,
            'totalTracksApproved'=>$totalTracksApproved
        ]);
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
        $platforms = Platform::all();
        
        $viewData = [
            'release' => $release,
            'level' => $level,
            'platforms' => $platforms
        ];
    

        if ($request->has('summary')) {
            $viewData['summary'] = $request->summary;
            return view('admin.releases.step2', $viewData)->with('success', 'Basic information updated successfully.');
        }

        return view('admin.releases.step2', $viewData);
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
        $file = $request->file('file');
         // Check if the file is valid
        if (!$file->isValid()) {
            return back()->withErrors(['file' => 'Invalid file upload']);
        }

        // Get image dimensions
        $imagedetails = getimagesize($file);
        if ($imagedetails === false) {
            return back()->withErrors(['file' => 'Invalid image data']);
        }

        $width = $imagedetails[0];
        $height = $imagedetails[1];

        // Validate dimensions
        if ($width < 3000 || $height < 3000 || $width > 6000 || $height > 6000) {

            if ($request->ajax()) {
                return response()->json(['status' => 'success', 'message' => 'The thumbnail must be between 3000 x 3000 pixels and 6000 x 6000 pixels.']);
            }
            return back()->withErrors(['file' => 'The thumbnail must be between 3000 x 3000 pixels and 6000 x 6000 pixels.']);
        }

        if ($width != $height) {

            if ($request->ajax()) {
                return response()->json(['status' => 'success', 'message' => 'The thumbnail must be a square.']);
            }
            return back()->withErrors(['file' => 'The thumbnail must be a square.']);
        }
    
        if ($file) {
            if (!empty($release->thumbnail_path)) {
                Storage::disk('public')->delete($release->thumbnail_path);
            }
    
            $filePath = $file->storeAs('music/' . $user_id . '/' . $release_id . '/thumbnail', $file->getClientOriginalName(), 'public');
    
            // Update the thumbnail path in the database
            $release->thumbnail_path = $filePath;
            $release->save();

            if($request->summary){
        
                return redirect()->route('releases.step2', ['release_id'=>$release->id, 'level'=>$request->summary])->with('success', 'Artwork  updated successfully.');
            }
            return redirect()->route('releases.step2', ['release_id' => $release_id, 'level' => 'artwork'])->with('success', 'Tracks updated successfully.');
        } else {
            return redirect()->back(['status' => 'error', 'message' => 'No file uploaded'], 400);
        }
    }
    
    public function saveUploadTrack(Request $request) 
    {
        $user_id = Auth::user()->id;
        $release_id = $request->release_id;
        $release = Release::find($release_id);
        $format = $release->format;
    
        // Retrieve existing tracks from the database
        $existingTracks = Track::where('release_id', $release_id)->get();
        $existingTrackCount = $existingTracks->count();
    
        // Get the new track files from the request
        $newTrackFiles = $request->file('file') ?? [];
        $newTrackCount = count($newTrackFiles);
    
        // Calculate the total count of tracks
        $totalTrackCount = $existingTrackCount + $newTrackCount;
    
        // Validate track limits based on format
        if ($format == "ep" && $totalTrackCount > 5) {
            return response()->json(['status' => 'error', 'message' => 'You have already uploaded maximum number of files for '. $format]);
        }
    
        if ($format == "album" && $totalTrackCount > 30) {
            return response()->json(['status' => 'error', 'message' => 'You have already uploaded maximum number of files for '. $format]);
        }
    
        if ($format == "single" && $totalTrackCount != 1) {
            return response()->json(['status' => 'error', 'message' => 'Single track should be exactly 1.']);
        }
    
        // Store new tracks
        if ($newTrackCount > 0) {
            foreach ($newTrackFiles as $track) {
                $originalName = $track->getClientOriginalName();
                $track_path = 'music/' . $user_id . '/' . $release_id . '/tracks/'.$originalName;
                $newTrackName = $originalName;

                // Check if the track name already exists
                $existingTrackRow = Track::where('release_id', $release_id)->where('track_path',  $track_path)->first();
                if ($existingTrackRow) {
                      // Generate a unique filename by appending the current timestamp
                    $filenameWithoutExtension = pathinfo($originalName, PATHINFO_FILENAME);
                    $extension = $track->getClientOriginalExtension();
                    $newTrackName = $filenameWithoutExtension . '_' . time() . '.' . $extension;
                }
         
                // Store the file with the unique filename
                $path = $track->storeAs('music/' . $user_id . '/' . $release_id . '/tracks', $newTrackName, 'public');
    
                // Save track data to the database
                $trackData = [
                    'user_id' => $user_id,
                    'release_id' => $release_id,
                    'track_path' => $path,
                ];
                Track::create($trackData);
            }
        }
    
        return response()->json(['status' => 'success', 'message' => 'Track uploaded successfully.']);
        // Redirect with success message
        // if ($request->summary) {
        //     return redirect()->route('releases.step2', ['release_id' => $release->id, 'level' => $request->summary])->with('success', 'Tracks updated successfully.');
        // }
    
        // return redirect()->route('releases.step2', ['release_id' => $release_id, 'level' => 'uploadtrack'])->with('success', 'Tracks updated successfully.');
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
    
            $messages['track_name.' . $i . '.required'] = "Track name is required.";
            $messages['track_version.' . $i . '.required'] = "Track version is required.";
            $messages['lyrics_language.' . $i . '.required'] = "Lyrics language is required.";
            $messages['explicit_content.' . $i . '.required'] = "Explicit content is required.";
            $messages['primary_artist.' . $i . '.required'] = "Primary artist is required.";
            $messages['featuring_artist.' . $i . '.nullable'] = "Featuring artist is required.";
            $messages['track_remixer.' . $i . '.nullable'] = "Track remixer is required.";
            $messages['song_writer.' . $i . '.required'] = "Song writer is required.";
            $messages['track_producer.' . $i . '.required'] = "Track producer is required.";
            $messages['composer_name.' . $i . '.required'] = "Composer name is required.";
            $messages['label_name.' . $i . '.required'] = "Label name is required.";
            $messages['isrc.' . $i . '.required'] = "ISRC code is required.";
            $messages['primary_performers.' . $i . '.required'] = "Primary performer is required.";
            $messages['pname.' . $i . '.required'] = "Publisher name is required.";
            $messages['cname.' . $i . '.required'] = "Composer name is required.";
            $messages['ownership_for_sound_rec.' . $i . '.required'] = "Ownership for sound recording is required.";
            $messages['country_of_rec.' . $i . '.required'] = "Country of recording is required.";
            $messages['nationality.' . $i . '.required'] = "Nationality is required.";
        }
    
        //$validatedData = $request->validate($rules, $messages);
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator, 'edittrack');
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
              return redirect()->route('releases.step2',['release_id'=>$release_id, 'level'=>'platforms'])->with('success', 'Tracks and release updated successfully.');

        }
        catch (\Exception $e) {
            // Handle the error, log it, or return a custom error response
            DB::rollback();
            return redirect()->back()->withErrors(['error' => 'Failed to update tracks and release: ' . $e->getMessage()], 'edittrack');
        }

      
    }


    public function savePlatforms(Request $request)
    {
        $user_id = Auth::user()->id;
        $release_id = $request->release_id;
        $rules =[
            'platforms' => 'required|array',
            'platforms.*' => 'exists:platforms,id',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator, 'platforms');
        }

        $release = Release::find($release_id);
        $release->platforms()->sync($request->platforms ?? []);
    
        if($request->summary){
        
            return redirect()->route('releases.step2', ['release_id'=>$release->id, 'level'=>$request->summary])->with('success', 'Platforms updated successfully.');
        }
        return redirect()->route('releases.step2',['release_id'=>$release_id, 'level'=>'summary'])->with('success', 'Platforms updated successfully.');
    }
    


    public function removeUploadTrack(Request $request) {
        $user_id = Auth::user()->id;
        $filename = $request->fn;
        $release_id = $request->release_id;
        $track_path = "music/{$user_id}/{$release_id}/tracks/{$filename}";
    
        // Find the track in the database
        $track = Track::where('track_path', $track_path)->first();
    
        if ($track) {
            // Delete the track record from the database
            $track->delete();
    
            // Remove the file from the filesystem
            if (Storage::disk('public')->exists($track_path)) {
                Storage::disk('public')->delete($track_path);

                // Handle AJAX request
                if ($request->ajax()) {
                    return response()->json(['status' => 'success', 'message' => 'Track deleted successfully']);
                }

                // Handle form submission
                return redirect()->back()->with('success', 'Track deleted successfully');

            }else{

                 // Handle AJAX request
            if ($request->ajax()) {
                return response()->json(['status' => 'success', 'message' => 'Track not deleted successfully']);
            }
    
            // Handle form submission
            return redirect()->back()->with('success', 'Track not deleted successfully');


            }
    
           
        } else {
            // Handle AJAX request
            if ($request->ajax()) {
                return response()->json(['status' => 'error', 'message' => 'Track not found'], 404);
            }
    
            // Handle form submission
            return redirect()->back()->with('error', 'Track not found');
        }
    }

    public function removeArtwork(Request $request) {
        $user_id = Auth::user()->id;
        $filename = $request->fn;
        $release_id = $request->release_id;
        $thumbnail_path = "music/{$user_id}/{$release_id}/thumbnail/{$filename}";
    
        // Find the track in the database
        $release = Release::where('thumbnail_path', $thumbnail_path)->first();
    
        if ($release) {
            // Set Empty
            $release->thumbnail_path="";
            $release->save();
            // Remove the file from the filesystem

            if (Storage::disk('public')->exists($thumbnail_path)) {
                // File exists, delete it
                Storage::disk('public')->delete($thumbnail_path);
                return response()->json(['status' => 'success', 'message' => 'Artwork deleted successfully']);
            } else {
                // File does not exist
                return response()->json(['status' => 'error', 'message' => 'Artwork file not found']);
            }
      
        } else {
            // Handle AJAX request
            return response()->json(['status' => 'error', 'message' => 'Artwork not found'], 404);
        }
    }



    public function getArtwork(Request $request) {
      $user_id = Auth::user()->id;  
      $filename = $request->fn;
      $release_id = $request->release_id;
      return  "music/{$user_id}/{$release_id}/thumbnail/{$filename}";
    }




    public function deleteReleaseData(Request $request)
    {

        $id = $request->id;

        $release = Release::find($id);

        if (!$release) {
            return response()->json(['message' => 'Release not found'], 404);
        }

     // Perform any necessary cleanup, e.g., deleting associated tracks or files
         $release->delete();
         return response()->json(['message' => 'Release deleted successfully'], 200);
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
