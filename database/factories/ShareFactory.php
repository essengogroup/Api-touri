<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Share>
 */
class ShareFactory extends Factory
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
            'shareable_id' => $this->faker->numberBetween(1, 10),
            'shareable_type' => $this->faker->randomElement(['App\Models\Comment', 'App\Models\Site', 'App\Models\Departement', 'App\Models\EventTouri']),
        ];
    }
}
