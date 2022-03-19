<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ThreatIntelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
{
	for ($i = 0; $i < 100; $i++) {
		DB::table('threat_intels')->insert([
			'alias' => $faker->userName,
            'real_name' => $faker->name,
            'post' => $faker->text,
            'url' => $faker->imageUrl,
            'time' => $faker->dateTimeThisYear,
            'geolocation' => $faker->region,
            'source' => "Twitter",
        ]);
	}
}
}
