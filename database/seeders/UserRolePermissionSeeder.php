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
            'create-music',
            'edit-music',
            'delete-music',
        ];
       //Created Permission
       foreach ($permissions as $permission) {
        Permission::create(['name' => $permission]);
       }
       
        $superAdminUser = User::updateOrCreate([
            'email' => 'superadmin@gmail.com',
            'name' => 'Tabrej', 
            'mobile' =>'8340106146',
            'password' => Hash::make('12345678'),
            'client_id' => 100001

        ]);

          $adminUser = User::updateOrCreate([
            'email' => 'krishna@gmail.com',
            'name' => 'krishna', 
            'mobile' =>'8284910963',
            'password' => Hash::make('12345678'),
            'client_id' => 100002
        ]);

           // Create roles
         $superAdminRole = Role::create(['name' => 'Super Admin']);
         $adminRole = Role::create(['name' => 'Admin']);
        // Create roles for regular users
         $userRole = Role::create(['name'=> 'User']);

    
      
        // Assign specific permissions to admin role
        $adminRole->givePermissionTo([
            'create-user',
            'edit-user',
            'delete-user',
        ]);

        // Assign specific permissions to product manager role
        $userRole->givePermissionTo([
            'create-music',
            'edit-music',
            'delete-music',
        ]);

        //Asign Role to the user
        $permissions = Permission::pluck('id')->all();
        $superAdminRole->syncPermissions($permissions);

        $superAdminUser->assignRole($superAdminRole);
        $adminUser->assignRole($adminRole);


    }


    // public static function generate_client_id() {
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

