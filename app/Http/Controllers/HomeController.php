<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Release;
use App\Models\Track;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
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
        if (Auth::user()->hasRole('Super Admin')) {
            $releases = Release::with('tracks')->get();
            // Count total approved, pending, rejected, and incomplete for all users
            $totalRelease = Release::count();
            $totalApproved = Release::where('status', 1)->count();
            $totalPending = Release::where('status', 0)->count();
            $totalRejected = Release::where('status', 2)->count();
            $totalComplete = Release::where('form_status', 1)->count();
            $totalIncomplete = Release::where('form_status', 0)->count();
    
        } else {
           
            $releases = Release::where('user_id', $user_id)->with('tracks')->get();
            // Count total approved, pending, rejected, and incomplete for the authenticated user
            $totalRelease = Release::where('user_id', $user_id)->count();
            $totalApproved = Release::where('user_id', $user_id)->where('status', 1)->count();
            $totalPending = Release::where('user_id', $user_id)->where('status', 0)->count();
            $totalRejected = Release::where('user_id', $user_id)->where('status', 2)->count();
            $totalComplete = Release::where('user_id', $user_id)->where('form_status', 1)->count();
            $totalIncomplete = Release::where('user_id', $user_id)->where('form_status', 0)->count();
        }
        

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

    public function profileEdit(Request $request) {
        $user =Auth::user();
        return view('edit-profile',['user'=>$user]);
    }


    public function profileUpdate(Request $request)
    {
        $user =Auth::user();
        $validatedData = $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|string|email:rfc,dns|max:250|unique:users,email,'.$user->id,
            'mobile' => 'required|digits:10|unique:users,mobile,'.$user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'full_address' => 'required|string', 
            'company_label' => 'required|string',
            'social_links.name.*' => 'nullable|string', // Ensure social link name is a string if provided
            'social_links.url.*' => 'nullable|url' // Ensure social link URL is a valid URL if provided
         ]);
        
         $input = $request->all();

         if(!empty($request->password)){
            $input['password'] = Hash::make($request->password);
        }else{
            $input = $request->except('password');
        }


         // Prepare social links data
         $socialLinks = [];
         if (isset($validatedData['social_links']['name']) && isset($validatedData['social_links']['url'])) {
             foreach ($validatedData['social_links']['name'] as $index => $name) {
                 $url = $validatedData['social_links']['url'][$index] ?? null;
                 if ($name && $url) {
                     $socialLinks[$name] = $url;
                 }
             }
         }
         

        $input['sociallinks'] = json_encode($socialLinks);
        $user->update($input);
     
        return redirect()->route('profile')
                ->withSuccess('Profile is updated successfully.');
       
    }






}
