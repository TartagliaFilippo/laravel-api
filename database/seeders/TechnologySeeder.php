<?php

namespace Database\Seeders;

use App\Models\Technology;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Faker\Generator as Faker;

class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $_technologies = ["html", "css", "bootstrap", "sass", "js", "vue", "php", "mysql", "laravel"];

        foreach ($_technologies as $_technology) {

            $technology = new Technology();
            $technology->label = $_technology;
            $technology->color = $faker->hexColor();
            $technology->save();
        }

    }
}