<?php

use Illuminate\Database\Seeder;
use App\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'id' => 1,
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'role_id' => 1,
            'admin_approval' => 1,
            'email_verified_at' => now(),
            'password' => bcrypt('verysafepassword'),
            
            
        ]);

        
    }
}
