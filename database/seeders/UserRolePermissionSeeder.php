<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class UserRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define permissions
        $permissions = [
            'create-role',
            'edit-role',
            'delete-role',
            'create-user',
            'edit-user',
            'delete-user',
            'view-user',
            // 'create-book',
            // 'edit-book',
            // 'delete-book',
            // 'view-book'
        ];
 
        // Create or update permissions
        foreach ($permissions as $permissionName) {
            Permission::updateOrCreate(['name' => $permissionName]);
        }

        // Create or update roles
        $superAdminRole = Role::updateOrCreate(['name' => 'Super Admin']);
        $adminRole = Role::updateOrCreate(['name' => 'Admin']);
       // $storeManagerRole = Role::updateOrCreate(['name' => 'Store Manager']);

        // Sync all permissions to super admin role
        $permissions = Permission::pluck('id')->all();
        $superAdminRole->syncPermissions($permissions);

        // Assign specific permissions to admin role
        $adminRole->givePermissionTo([
            'create-user',
            'edit-user',
            'delete-user',
            // 'create-book',
            // 'edit-book',
            // 'delete-book'
        ]);
  
        // Assign specific permissions to product manager role
        // $storeManagerRole->givePermissionTo([
        //     'create-book',
        //     'edit-book',
        //     'delete-book'
        // ]);

        // Creating or updating Super Admin User
        $superAdminUser = User::updateOrCreate([
            'email' => 'sanjank.mvteams@gmail.com'
        ], [
            'name' => 'Sanjan', 
            'mobile' =>'8340106146',
            'password' => Hash::make('12345678')
        ]);
        $superAdminUser->assignRole($superAdminRole);

        // Creating or updating Admin User
        $adminUser = User::updateOrCreate([
            'email' => 'krishna@gmail.com'
        ], [
            'name' => 'krishna', 
            'mobile' =>'8284910963',
            'password' => Hash::make('12345678')
        ]);
        $adminUser->assignRole($adminRole);

        // Creating or updating Product Manager User
        // $storeManagerUser = User::updateOrCreate([
        //     'email' => 'neha@gmail.com'
        // ], [
        //     'name' => 'neha', 
        //     'mobile' =>'1234567890',
        //     'password' => Hash::make('12345678')
        // ]);
        // $storeManagerUser->assignRole($storeManagerRole);
    }
}

