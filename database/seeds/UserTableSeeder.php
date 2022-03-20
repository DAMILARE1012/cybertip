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
        \App\User::updateorCreate(['email' => 'admin@admin.com'],[
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'phoneNumber'=> '09030450989',
            'companyName' => 'CyberTip Nigeria Limited',
            'companyRole' => 'Administrator',
            'companyWebsite' => 'www.cybertip.com',
            'role_id' => Role::where('role_name','Admin')->first()->id,
            'admin_approval' => 1,
            'email_verified_at' => now(),
            'password' => bcrypt('verysafepassword'),


        ]);
    }
}
