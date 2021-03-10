<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
  
        $usuario = new User();
        $usuario->name = 'Admin';
        $usuario->email = 'admin@admin.com';
        $usuario->password = bcrypt('admin123');
        $usuario->save();
        
        
        $role1 = New Role();
        $role1->name = 'administrador';
        $role1->save();

        $role2 = New Role();
        $role2->name = 'usuario';
        $role2->save();

        $roleuser = New RoleUser();
        $roleuser->user_id = 1;
        $roleuser->role_id = 1;
        $roleuser->save();

    }
}
