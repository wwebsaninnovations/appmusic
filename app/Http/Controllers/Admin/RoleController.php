<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
class RoleController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-role|edit-role|delete-role', ['only' => ['index','show']]);
        $this->middleware('permission:create-role', ['only' => ['create','store']]);
        $this->middleware('permission:edit-role', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-role', ['only' => ['destroy']]);
    }
 
    public function index()
    {
        $roles = Role::orderBy('id','DESC')->paginate(10);
        return view('admin.roles.index', [
            'roles' => $roles 
        ]);
    }
    public function create()
    {
       return view('admin.roles.create', [
        'permissions' => Permission::get()
       ]);
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:250|unique:roles,name',
            'permissions' => 'required',
         ]);

         $role = Role::create(['name' => $request->name]);
        
         $permissions = Permission::whereIn('id', $request->permissions)->pluck('name')->toArray();
         if (in_array('edit-role', $permissions) || in_array('create-role', $permissions) || in_array('delete-role', $permissions)) {
             abort(403, 'YOU DO NOT HAVE PERMISSION TO ADD ROLE PERMISSIONS');
         }
         $role ->syncPermissions($permissions);

         return redirect()->route('roles.index')
         ->withSuccess('New role is added successfully.');
  
    }

    public function show(Role $role)
    {
        $rolePermissions = Permission::join("role_has_permissions","permission_id","=","id")
        ->where("role_id",$role->id)
        ->select('name')
        ->get();
        return view('admin.roles.show', [
            'role' => $role,
            'rolePermissions' => $rolePermissions
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        
    
        if($role->name=='Super Admin'){
            abort(403, 'SUPER ADMIN ROLE CAN NOT BE DELETED');
        }

        $rolePermissions = DB::table("role_has_permissions")->where("role_id",$role->id)
            ->pluck('permission_id')
            ->all();

        return view('admin.roles.edit', [
            'role' => $role,
            'permissions' => Permission::get(),
            'rolePermissions' => $rolePermissions
        ]);  
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:250|unique:roles,name,'.$role->id,
            'permissions' => 'required',
         ]);

        $input = $request->only('name');

        if($role->name != "User") {
            $role->update($input); 
        }

        $permissions = Permission::whereIn('id', $request->permissions)->pluck('name')->toArray();

        if (in_array('edit-role', $permissions) || in_array('create-role', $permissions) || in_array('delete-role', $permissions)) {
            abort(403, 'YOU DO NOT HAVE PERMISSION TO ADD ROLE PERMISSIONS');
        }
        $role->syncPermissions($permissions);    
        
        return redirect()->route('roles.index')
                ->withSuccess('Role is updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
       
        if ($role->name === 'Super Admin' || $role->name === 'User' || auth()->user()->hasRole($role->name)) {
            abort(403, 'YOU CAN NOT DELETE THIS ROLE');
        }
        
        if (!auth()->user()->hasRole('Super Admin')) {
            abort(403, 'YOU DO NOT HAVE PERMISSION TO DELETE ROLE');
        }
        
        $role->delete();
        
        return redirect()->route('roles.index')->withSuccess('Role deleted successfully.');
    }
}
