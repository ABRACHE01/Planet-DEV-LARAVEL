<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Article;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    // protected $model = Article::class;

    public function definition()
    {
        $faker = \Faker\Factory::create();

        return [
            'title' => $faker->word(),
            'image' => $faker->imageUrl(640, 480, 'animals', true),
            'description' => $faker->sentence(20),
            'content' => $faker->paragraph(2),
            // 'user_id' => $faker->numberBetween(1, 10),
            'category_id' => $faker->numberBetween(1, 10),
            'user_id' => User::factory(),

        ];
    }
}