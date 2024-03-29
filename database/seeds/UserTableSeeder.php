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
            'name' => 'Super Admin',
            'email' => 'admin@admin.com',
            'phoneNumber'=> '09030450989',
            'companyName' => 'CyberTip Nigeria Limited',
            'companyRole' => 'Administrator',
            'companyWebsite' => 'www.cybertip.com',
            'googleProfile' => 'www.google.com/damilare',
            'facebookProfile' => 'www.facebook.com/damilare_emmanuel',
            'role_id' => Role::where('role_name','Super_Admin')->first()->role_id,
            'admin_approval' => 1,
            'timeIn' => now(),
            'timeOut' => null,
            'email_verified_at' => now(),
            'password' => bcrypt('verysafepassword'),
        ]);
    }
}
