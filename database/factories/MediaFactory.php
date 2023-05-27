<?php

namespace Database\Factories;

use App\Models\Site;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Media>
 */
class MediaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $imageUrl = 'https://picsum.photos/640/480?blur=2.webp?random=1?rand=' . uniqid();
        return [
            'site_id' => $this->faker->numberBetween(1, 10),
            'name' => $this->faker->name,
//            'path' => $this->faker->imageUrl(640, 480, 'paris', true),
            'path' => $imageUrl,
            'type' => $this->faker->randomElement(['image', 'video']),
            'is_main' => $this->faker->boolean,
        ];
    }
}
