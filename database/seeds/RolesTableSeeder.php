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
            'Admin',
            'Manager',
            'User',

        ];
        foreach ($roles as $key => $role) {
            Role::updateorCreate(['role_name' => $role],
                [
                    'role_id' => $key,
                    'role_name' => $role,
                ]
            );
        }

    }
}
