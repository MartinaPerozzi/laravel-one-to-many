<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\Type;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $labels = ["Web Development", "GraphicDesign&Illustration"];
        // Ciclo per generare con Faker
        foreach ($labels as $label) {
            $type = new Type;
            $type->label = $label;
            $type->color = $faker->hexColor();
            $type->save();
        }
    }
}
