<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activite>
 */
class ActiviteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            // 'image_path' => $this->faker->image(
            //     storage_path('app/public/activites'),
            //     640,
            //     480,
            //     null,
            //     false
            // ),
            'image_path' => $this->faker->imageUrl(640, 480, 'sports', true),
        ];
    }
}
