<?php

namespace Database\Factories;

use App\Models\Source;
use Carbon\Carbon;
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
    public function definition(): array
    {
        return [
            'source_id' => Source::factory(),
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
