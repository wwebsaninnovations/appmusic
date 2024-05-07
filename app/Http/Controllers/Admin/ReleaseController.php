<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Release;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator; 

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
            'release_version' => 'nullable|string|max:255',
            'release_code' => 'nullable|string|max:255',
            'upc' => 'nullable|string|max:255'
        ]);

        $validateData['user_id'] = $user_id;
        $release = Release::create($validateData);

        return redirect()->route('releases.step2', ['release_id'=>$release->id, 'level'=>'basic']);
    }
    
    //step2 is associated with basic, artwork, uploadTrack and editTrack forms 
    public function step2(Request $request){
        $release = Release::find( $request->release_id);
        $level = $request->level;
        return view('admin.releases.step2', ['release' => $release, 'level'=> $level]);
    }

    public function saveBasic(Request $request) {

        $user_id = Auth::user()->id;
        $release =  Release ::find($request->release_id);

        // if($user_id != $music->user_id) {
        //     abort(403, 'Unauthorized action!');
        // }

        $validatedData = $request->validate([
          
            'upc' => 'required|string',
            'release_code' => 'required|string|max:255',
            'release_language' => 'required|string|max:255',
            'release_name' => 'required|string|max:255',
            'release_version' => 'required|string',
            'primary_artist' => 'required|string|max:255',
            'featuring_artist' => 'required|string|max:255',
            'producer_artist'=> 'required|string|max:255',
            'genre'=> 'required|string|max:255',
            'sub_genre' => 'required|string|max:255',
            'format' => 'required|in:single,ep,album',
            'cname' => 'required|string|max:255',
        ]);

        $release->upc = $validatedData['upc'];
        $release->release_code = $validatedData['release_code'];
        $release->meta_language = $validatedData['release_language'];
        $release->release_name = $validatedData['release_name'];
        $release->release_version = $validatedData['release_version'];
        $release->primary_artist = $validatedData['primary_artist'];
        $release->featuring_artist = $validatedData['featuring_artist'];
        $release->genre = $validatedData['genre'];
        $release->sub_genre = $validatedData['sub_genre'];
        $release->format = $validatedData['format'];
        $release->copy_rights = $validatedData['cname'];
      
        $release->save();
       

        return redirect()->route('releases.step2', ['release_id'=>$release->id, 'level'=>'artwork']);

    }
    
    public function saveArtwork(Request $request) {

        echo "hello";
        die;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
}
