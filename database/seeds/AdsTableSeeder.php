<?php

use App\Ad;
use Illuminate\Database\Seeder;

class AdsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        foreach (range(1, 10) as $index) {
            Ad::create(
                [
                    'title' => $faker->sentence(6),
                    'body' => $faker->paragraph(10)
                ]
            );
        }
    }
}
