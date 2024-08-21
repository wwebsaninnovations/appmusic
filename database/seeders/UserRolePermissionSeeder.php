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
            'create-release',
            'edit-release',
            'delete-release',
            'approve-release',
            'delivered-release',
            'take-down-release',
            'create-genre',
            'edit-genre',
            'delete-genre',
            'create-platform',
            'edit-platform',
            'delete-platform',
            'create-ownershiptype',
            'edit-ownershiptype',
            'delete-ownershiptype'
        ];
        
       //Created Permission
       foreach ($permissions as $permission) {
        Permission::updateOrCreate(['name' => $permission]);
       }
    
        // Create roles
        $superAdminRole = Role::updateOrCreate(['name' => 'Super Admin']);
    
        //Asign Role to the user
        $permissions = Permission::pluck('id')->all();
        $superAdminRole->syncPermissions($permissions);

           
        $superAdminUser = User::updateOrCreate([
            'email' => 'superadmin@gmail.com',
            'name' => 'Tabrej', 
            'mobile' =>'8340106146',
            'password' => Hash::make('12345678'),
            'client_id' => 100001,

        ]);

        $superAdminUser->assignRole($superAdminRole);

        // Create roles for regular users
        $userRole = Role::updateOrCreate(['name'=> 'User']);
            // Assign default permissions to user
        $userRole->givePermissionTo([
            'create-release',
            'edit-release',
            'delete-release',
        ]);
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

