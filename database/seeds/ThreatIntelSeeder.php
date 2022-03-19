<?php

use App\ThreatIntel;
use Illuminate\Database\Seeder;


class ThreatIntelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        
        ThreatIntel::factory()->count(5)->create();

	}
}
