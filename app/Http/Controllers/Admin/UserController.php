<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Platform;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;


class UserController extends Controller
{
      /**
     * Instantiate a new UserController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-user|edit-user|delete-user|view-user', ['only' => ['index','show']]);
        $this->middleware('permission:create-user', ['only' => ['create','store']]);
        $this->middleware('permission:edit-user', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-user', ['only' => ['destroy','trashedUsers','restoreUser','deleteUser']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if(Auth::user()->hasRole('Super Admin')) {
            $filter_role = $request->role;

            $users = User::latest('id')->paginate(10);
            
            if ($filter_role != "") {
                $users = User::whereHas('roles', function ($query) use ($filter_role) {
                    $query->where('name', $filter_role);
                })->latest('id')->paginate(10);
            }
            
            $total_trashed = User::onlyTrashed()->get()->count();
            $roles = Role::pluck('name')->all();
            return view('admin.users.index',['users'=>$users,'roles'=>$roles, 'total_trashed'=>$total_trashed]);

         }else{
            
            $users = User::latest('id')
            ->where('created_by', Auth::user()->id)
            ->orWhere('id', Auth::user()->id)
            ->paginate(10);
            $total_trashed = User::onlyTrashed()->get()->count();
            return view('admin.users.index',['users'=>$users, 'total_trashed'=>$total_trashed]);
         }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::pluck('name')->all();
        $platforms = Platform::all();
        return view('admin.users.create', [
            'roles'      => $roles,
            'platforms'  =>$platforms
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|string|email:rfc,dns|max:250|unique:users,email',
            'mobile' => 'required|digits:10|unique:users,mobile',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'required',
            'full_address' => 'required|string', 
            'company_label' => 'required|string',
            'platform_id' => 'required|array', // Ensure platforms is an array
            'platform_id.*' => 'integer|exists:platforms,id', // Validate each platform ID
            'social_links.name.*' => 'nullable|string', // Ensure social link name is a string if provided
            'social_links.url.*' => 'nullable|url' // Ensure social link URL is a valid URL if provided
         ]);
         $input = $request->all();
         $input['password'] = Hash::make($request->password);
         $input['created_by'] = Auth::user()->id;
         $lastClientId = User::latest('id')->first()->client_id;
         $input['client_id'] = $lastClientId + 1;    
            // Convert platforms array to JSON
         $input['platform_id'] = json_encode($request->platform_id);    
         
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
         
         $input['sociallinks'] =  json_encode($socialLinks);
         $user = User::create($input);
         $user->assignRole($request->roles);

         return redirect()->route('users.index')
         ->withSuccess('New user is added successfully.');

    }

    public function show(User $user)
    {
       return view('admin.users.show', ['user'=>$user]);
    }

 
    public function edit(User $user)
    {
         // Check Only Super Admin can update his own Profile
         if ($user->hasRole('Super Admin')){
            if($user->id != auth()->user()->id){
                abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
            }
        }
        $platforms = Platform::all();

        return view('admin.users.edit', [
            'user' => $user,
            'roles' => Role::pluck('name')->all(),
            'userRoles' => $user->roles->pluck('name')->all(),
            'platforms'  =>$platforms
        ]);
    }

    public function updateProfileImage(Request $request, User $user)
    {
        // $request->validate([
        //     'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validate the image
        // ]);
    
        // echo "test";
        // die();  
        $currentImage = $request->input('currentImage');

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('user'), $imageName);
            $user->profile_image = $imageName;
         

            if ($currentImage && $currentImage !== $imageName) {
                $oldImagePath = public_path('user/' . $currentImage);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }
    
            $user->save();
        }
    
        return redirect()->back()->withSuccess('Profile image updated successfully.');
    }
    


    public function update(Request $request, User $user)
    {
    
        $validatedData = $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|string|email:rfc,dns|max:250|unique:users,email,'.$user->id,
            'mobile' => 'required|digits:10|unique:users,mobile,'.$user->id,
            'password' => 'nullable|string|min:8|confirmed',
             'roles' => 'required',
            'full_address' => 'required|string', 
            'company_label' => 'required|string',
            'platform_id' => 'required|array', // Ensure platforms is an array
            'platform_id.*' => 'integer|exists:platforms,id', // Validate each platform ID
            'social_links.name.*' => 'nullable|string', // Ensure social link name is a string if provided
            'social_links.url.*' => 'nullable|url' // Ensure social link URL is a valid URL if provided
         ]);
        
         $input = $request->all();

         if(!empty($request->password)){
            $input['password'] = Hash::make($request->password);
        }else{
            $input = $request->except('password');
        }
        $input['platform_id'] = json_encode($request->platform_id); 
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
        $user->syncRoles($request->roles);
    
        if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'profile') !== false) {
            return redirect()->route('profile');
        }
        

        return redirect()->route('users.index')
                ->withSuccess('User is updated successfully.');
       
    }

    public function destroy(User $user)
    {
         // About if user is Super Admin or User ID belongs to Auth User
         if ($user->hasRole('Super Admin') || $user->id == auth()->user()->id)
         {
             abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
         }
 
      
         $user->delete();
         return redirect()->route('users.index')
                 ->withSuccess('User is moved to trash successfully.');
    }

    public function trashedUsers() {
        $users = User::onlyTrashed()->paginate(3);      
        return view('admin.users.trashed', compact('users'));
    }

    public function restoreUser(Request $request, $id) {

        User::withTrashed()->find($id)->restore();
        return redirect()->route('users.trashed')->with('success', 'User restored successfully.');
     }
  
     public function deleteUser(Request $request, $id) {
        $user = User::withTrashed()->find($id);
        // About if user is Super Admin or User ID belongs to Auth User
        if ($user->hasRole('Super Admin') || $id == auth()->user()->id)
        {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
        }
        
        $user->syncRoles([]);
        $user->forceDelete();
        return redirect()->route('users.trashed')->with('success', 'User deleted successfully.');
     }

    //  public static function generate_client_id() {
    //     $number = mt_rand(1000000, 99999999); // 8 digit
    
    //     if (self::client_idExists($number)) {
    //         return self::generate_client_id();
    //     }
    //     return $number;
    // }

    // public static function client_idExists($number) {
    //     return User::where('client_id',$number)->exists();
    // }

}
