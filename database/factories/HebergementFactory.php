<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hebergement>
 */
class HebergementFactory extends Factory
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
            'description' => $this->faker->text(),
            'image_path' => $this->faker->imageUrl(),
            'price' => $this->faker->randomFloat(2, 0, 1000),
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'is_available' => $this->faker->boolean,
        ];
    }
}
