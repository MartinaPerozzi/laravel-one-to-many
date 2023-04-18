<?php

namespace Database\Seeders;

// Importando iniziando a scrivere Project nel for con suggerimento.
use App\Models\Project;
// Importare per lo SLUG
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 40; $i++) {
            $project = new Project;
            $project->title = $faker->sentence(2);
            $project->slug = Str::of($project->title)->slug('-');
            $project->text = $faker->text(90);
            // $project->image = $faker->imageUrl(640, 480, 'animals', true);
            $project->save();
        }
    }
}
