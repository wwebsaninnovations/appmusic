<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Release;
use App\Models\Track;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {

        $user_id = Auth::user()->id;
        $releases = Release::where('user_id', $user_id)->with('tracks')->get();
        // Count total approved, pending, rejected, and incomplete
        $totalRelease = Release::where('user_id', $user_id)->count();
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

        return view('home', compact('totalRelease', 'totalApproved', 'totalPending', 'totalRejected', 'totalComplete', 'totalIncomplete', 'totalTracks', 'totalTracksApproved'));
                
    }

    public function profile(){
       $user =Auth::user();
       return view('profile',['user'=>$user]);
    }
}
