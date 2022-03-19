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
			'alias' => $faker->userName,
            'real_name' => $faker->name,
            'post' => $faker->text,
            'url' => $faker->imageUrl,
            'time' => $faker->date(),
            'geolocation' => $faker->state,
            'source' => "Twitter",
        ]);
	}
}
}
