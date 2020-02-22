<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $role = new Role;
        $role->name = "Usuario Comprador";
        $role->id = 1;
        $role->save();

        $role = new Role;
        $role->name = "Usuario Interno";
        $role->id = 2;
        $role->save();

        $role = new Role;
        $role->name = "Usuario Administrador";
        $role->id = 3;
        $role->save();

    }
}
