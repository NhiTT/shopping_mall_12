<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $factory->define(Category::class, function (Faker\Generator $faker) {
            return [
                'name' => $faker->name,
                'slug' => $faker->slug,
                'parent_id' => str_random(1),
            ];
        });
    }
}
