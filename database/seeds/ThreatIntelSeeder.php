<?php

use Illuminate\Database\Seeder;

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
		DB::table('users')->insert([
			'alias' => $faker->name,
            'real_name' => $faker->real_name,
            'post' => $faker->post,
            'url' => $faker->url,
            'time' => $faker->time,
            'geolocation' => $faker->location,
            'source' => $faker->source,
        ]);
	}
}
}
