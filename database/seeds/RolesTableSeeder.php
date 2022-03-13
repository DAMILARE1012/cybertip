<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\Role::create([
            'role_key' => 1,
            'role_name' => 'Admin', 
        ]);

        \App\Role::create([
            'role_key' => 2,
            'role_name' => 'Manager', 
        ]);

        \App\Role::create([
            'role_key' => 3,
            'role_name' => 'User', 
        ]);
    }
}
