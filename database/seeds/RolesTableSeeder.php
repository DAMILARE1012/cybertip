<?php

use App\Role;
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
        $roles = [
            'Super_Admin',
            'Admin',
            'Analyst',
            'User',

        ];
        foreach ($roles as $key => $role) {
            $key++;
            Role::updateorCreate(['role_name' => $role],
                [
                    'role_id' => $key,
                    'role_name' => $role,
                ]
            );
        }

    }
}
