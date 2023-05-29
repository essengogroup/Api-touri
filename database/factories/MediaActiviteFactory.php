<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MediaActivite>
 */
class MediaActiviteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $imageUrl = 'https://picsum.photos/640/480?blur=2.webp?random=1?rand=' . uniqid();
        return [
            'activite_id' => $this->faker->numberBetween(1, 10),
            'name' => $this->faker->name,
            'path' => $imageUrl,
            'type' => $this->faker->randomElement(['image', 'video']),
            'is_main' => $this->faker->boolean,
        ];
    }
}
