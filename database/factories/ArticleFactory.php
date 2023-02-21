<?php

namespace Database\Factories;

use App\Models\Tag;
use App\Models\User;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->sentence,
            'content' => fake()->paragraphs(3, true),
            'description' => fake()->paragraphs(3, true),
            'image' => fake()->imageUrl(),
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
        ];
    }
    public function configure()
    {
        return $this->afterCreating(function (Article $article) {
            $tags = Tag::factory()->count(3)->create();
            $article->tags()->attach($tags);
        });
    }

}
