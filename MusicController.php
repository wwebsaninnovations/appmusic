<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Music;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MusicController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-music|edit-music|delete-music', ['only' => ['index']]);
        $this->middleware('permission:create-music', ['only' => ['step1','saveStep1','step2','saveStep2','step3','store']]);
        $this->middleware('permission:edit-music', ['only' => ['editStep1','updateStep1','editStep2','updateStep2','editStep3','update']]);
        $this->middleware('permission:delete-music', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $musics  = Music::where('user_id',$user_id)->paginate(3);
        return view('admin.musics.index',['musics'=>$musics]);
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create(){}

    public function step1(){
        return view('admin.musics.step1');
    }
    
    public function saveStep1(Request $request) {
        
        $user_id = Auth::user()->id;
        $validatedData = $request->validate([
            'musicType' => 'required|in:single,ep,album',
        ]);
    
        $music = Music::create([
            'type' => $validatedData['musicType'],
            'user_id' => $user_id 
        ]);
        return redirect()->route('musics.step2', ['music_id' => $music->id])->with('success', 'Step -I Completed.!');
    }
    

    public function step2(Request $request){

        $music_id = $request->input('music_id');

        if(!$music_id ){
            return redirect()->route('musics.step1');
        }

        return view('admin.musics.step2',['music_id' => $music_id]);
    }
    
    public function saveStep2(Request $request) {

        $music_id = $request->music_id;
        $user_id = Auth::user()->id;

        $music = Music::find($music_id);

        if($user_id != $music->user_id) {

            abort(403, 'Unauthorized action!');
        }

   
        $validatedData = $request->validate([
            'thumbnail' => 'required|image|max:2048',
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'trackCode' => 'required|string|max:255',
            'releaseDate' => 'required|date',
            'genre' => 'required|string|max:255',
        ]);


        $path = $request->file('thumbnail')->storeAs(
            'music/'.$user_id.'/'.$validatedData['trackCode'].'/thumbnail',
            $request->file('thumbnail')->getClientOriginalName()
        );
        

   
        $music->thumbnail_path = $path;
        $music->title = $validatedData['title'];
        $music->artist = $validatedData['artist'];
        $music->track_code = $validatedData['trackCode'];
        $music->release_date = $validatedData['releaseDate'];
        $music->genre = $validatedData['title'];
    
      
        $music->save();

        return redirect()->route('musics.step3', ['music_id' => $music->id])->with('success', 'Step -2 Completed.!');

    }
    
    public function step3(Request $request){

        $music_id = $request->input('music_id');
        if(!$music_id ){
            return redirect()->route('musics.step2');
        }
        return view('admin.musics.step3',['music_id' => $music_id]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $music_id = $request->music_id;
        $user_id = Auth::user()->id;
        $music = Music::find($music_id);

        if($user_id != $music->user_id) {
            abort(403, 'Unauthorized action!');
        }

        $request->validate([
            'trackFile.*' => 'required|max:20480', 
        ]);

    
        $trackcode =  $music->track_code;

        //audio|mpeg

        $trackPaths = [];
        foreach ($request->file('trackFile') as $track) {
            $path = $track->storeAs('music/'.$user_id.'/'. $trackcode.'/tracks',$track->getClientOriginalName());  
            $trackPaths[] = $path;
        }
        
        $music->track_paths = json_encode($trackPaths);
        $music->save();
        return redirect()->route('musics.index')->with('success', 'Music tracks uploaded successfully.');
    }


    /**
     * Display the specified resource.
     */
   public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {}
  

   public function editStep1(string $id){

     
     $music = Music::findOrFail($id);

     $user_id = Auth::user()->id;

     if($user_id != $music->user_id) {
         abort(403, 'Unauthorized action!');
     }


     return view('admin.musics.editStep1', compact('music'));
   }


   public function updateStep1(Request $request) {

     $music_id =$request->music_id;
     $music = Music::find($music_id);
     $user_id = Auth::user()->id;

     if($user_id != $music->user_id) {
         abort(403, 'Unauthorized action!');
     }

    $validatedData = $request->validate([
        'musicType' => 'required|in:single,ep,album',
    ]);



    $music->type =  $validatedData['musicType'];
    $music->save();

    return redirect()->route('musics.editStep2',$music_id)->with('success', 'Step -I Updated.!');
  }



   public function editStep2(string $id){

     $music = Music::findOrFail($id);

     $user_id = Auth::user()->id;
     if($user_id != $music->user_id) {
         abort(403, 'Unauthorized action!');
     }
     return view('admin.musics.editStep2', compact('music'));
    
   }

   public function updateStep2(Request $request) {

    $music_id = $request->music_id;

    $user_id = Auth::user()->id;
    $music = Music::find($music_id);

    if($user_id != $music->user_id) {
        abort(403, 'Unauthorized action!');
    }
    
    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'artist' => 'required|string|max:255',
        'trackCode' => 'required|string|max:255',
        'releaseDate' => 'required|date',
        'genre' => 'required|string|max:255',
    ]);

    if ($request->hasFile('thumbnail')) {

        $old_path = $music->thumbnail_path;

        if (Storage::exists($old_path)) {
            Storage::delete($old_path);
        }
        $path = $request->file('thumbnail')->storeAs(
            'music/'.$user_id.'/'.$validatedData['trackCode'].'/thumbnail',
            $request->file('thumbnail')->getClientOriginalName()
        );

        $music->thumbnail_path = $path;
    }

    $music->title = $validatedData['title'];
    $music->artist = $validatedData['artist'];
    $music->track_code = $validatedData['trackCode'];
    $music->release_date = $validatedData['releaseDate'];
    $music->genre = $validatedData['title'];
    $music->user_id = $user_id;
  
    $music->save();

    return redirect()->route('musics.editStep3', $music->id)->with('success', 'Step -2 updated.!');

}

   public function editStep3(string $id){

      $music = Music::findOrFail($id);
      $user_id = Auth::user()->id;

      if($user_id != $music->user_id) {
        abort(403, 'Unauthorized action!');
      }

      return view('admin.musics.editStep3',['music' => $music]);

  }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        //audio|mpeg
        $music_id = $request->music_id;

        $music = Music::find($music_id);
        $user_id = Auth::user()->id;
      
        if($user_id != $music->user_id) {
          abort(403, 'Unauthorized action!');
        }

        $request->validate([
            'trackFile.*' => 'required|max:20480', 
        ]);

 
        $trackcode =  $music->track_code;
        $trackPaths = [];

        if($request->hasFile('trackFile')){

           $old_tracks_paths = json_decode( $music->track_paths);

           foreach( $old_tracks_paths as $track){
                if (Storage::exists($track)) {
                    Storage::delete($track);
                }
           }
        
            foreach ($request->file('trackFile') as $track) {
                $path = $track->storeAs('music/'.$user_id.'/'. $trackcode.'/tracks',$track->getClientOriginalName());  
                $trackPaths[] = $path;
            }
            
            $music->track_paths = json_encode($trackPaths);

            $music->save();
        }

        return redirect()->route('musics.index')->with('success', 'Music tracks Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function generateTrackCode() {
        $number = mt_rand(1000000000, 9999999999); 
    
        if ($this->trackCodeExists($number)) {
            return $this->generateTrackCode(); // Recursive call to generate a new code
        }

        return response()->json([
            "status" => true,
            "trackCode" => $number
        ]);

    }
    
    public function trackCodeExists($number) {
        return Music::where('track_code', $number)->exists();
    }
    
}
