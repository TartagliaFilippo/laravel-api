<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Type;
use Illuminate\Support\Str;

use Faker\Generator as Faker;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $type_ids = Type::all()->pluck('id');

        for ($i = 0; $i < 50; $i++) {
            $project = new Project();

            $project->type_id = $faker->randomElement($type_ids);
            $project->title = $faker->words(3, true);
            $project->url = $faker->url();
            $project->content = $faker->paragraphs(2, true);
            $project->slug = Str::slug($project->title);
            $project->save();
        }
    }
}