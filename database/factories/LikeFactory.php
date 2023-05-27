<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Like>
 */
class LikeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 10),
            'likeable_id' => $this->faker->numberBetween(1, 10),
            'likeable_type' => $this->faker->randomElement(['App\Models\Comment', 'App\Models\Site', 'App\Models\Departement', 'App\Models\EventTouri']),
        ];
    }
}
