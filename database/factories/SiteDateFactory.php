<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SiteDate>
 */
class SiteDateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'departement_id' => $this->faker->numberBetween(1, 10),
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'address' => $this->faker->address,
            'price' => $this->faker->numberBetween(100, 1000),
            'is_date_required' => $this->faker->boolean,
            'is_active' => $this->faker->boolean,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
        ];
    }
}
