<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EventTouri>
 */
class EventTouriFactory extends Factory
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
            'description' => $this->faker->text(200),
            'image_path' => $this->faker->imageUrl(),
            'date_event' => $this->faker->date(),
            'place' => $this->faker->numberBetween(1, 100),
            'price' => $this->faker->randomFloat(2, 100, 1000),
            'status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }
}
