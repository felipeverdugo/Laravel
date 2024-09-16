<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'Admin',
                'email'          => 'admin@admin.com',
                'dni'            => '12123123',
                'password'       => bcrypt('password'),
                'remember_token' => null,
                'user_token'     => '1234',
                'last_name'      => 'istrador'
            ],
        ];

        User::insert($users);

        //  Add roles/permissions 

        $r1 = Role::firstOrCreate(["name" => "Superadmin"]);
        $r2 = Role::firstOrCreate(["name" => "Admin"]);
        $r3 = Role::firstOrCreate(["name" => "User"]);

        $p1 = Permission::firstOrCreate(['name' => 'manage users']);

        $r1->givePermissionTo('manage users');

        $user = User::first();
        $user->assignRole($r1);
        $user->assignRole($r2);
        $user->assignRole($r3);
    }
}
