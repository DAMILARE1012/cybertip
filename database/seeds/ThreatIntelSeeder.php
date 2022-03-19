<?php

use App\ThreatIntel;
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
		ThreatIntel::create([
			'alias' => $faker->userName,
            'real_name' => $faker->name,
            'post' => $faker->text,
            'url' => $faker->imageUrl,
            'time' => $faker->dateTimeThisYear,
            'geolocation' => $faker->region,
            'source' => "Twitter",
        ]);

        factory(App\ThreatIntel::class, 150)->create();

	}
}
