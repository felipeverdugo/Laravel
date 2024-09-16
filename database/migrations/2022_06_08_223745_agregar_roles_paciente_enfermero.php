<?php

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarRolesPacienteEnfermero extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'Admin',
                'email'          => 'admin@admin.com',
                'dni'            => '12123123',
                'password'       => bcrypt('password'),
                'remember_token' => null,
                // 'user_token'     => '1234',
                'last_name'      => 'istrador'
            ],
        ];

        User::insert($users);

        $r1 = Role::firstOrCreate(["name" => "Admin"]);
        $r2 = Role::firstOrCreate(["name" => "Enfermero"]);
        $r3 = Role::firstOrCreate(["name" => "Paciente"]);

        Permission::firstOrCreate(['name' => 'manage users']);

        $r1->givePermissionTo('manage users');

        $user = User::first();
        $user->assignRole($r1);
        $user->assignRole($r2);
        $user->assignRole($r3);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
