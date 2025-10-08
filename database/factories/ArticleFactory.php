<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'source_key' => fake()->randomElement(explode(',', config('sources.keys'))),
            'external_id' => fake()->uuid,
            'title' => fake()->sentence,
            'summary' => fake()->paragraph,
            'body' => fake()->paragraphs(3, true),
            'url' => fake()->url,
            'image_url' => fake()->imageUrl(),
            'published_at' => Carbon::now()->subDays(rand(0, 10)),
            'author' => fake()->name(),
            'language' => 'en',
            'raw_json' => [],
        ];
    }
}
