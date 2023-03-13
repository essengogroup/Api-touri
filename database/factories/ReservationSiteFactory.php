<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ReservationSite>
 */
class ReservationSiteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'site_id' => \App\Models\Site::factory(),
            'user_id' => \App\Models\User::factory(),
            'site_date_id' => \App\Models\SiteDate::factory(),
            'price' => $this->faker->randomFloat(2, 0, 1000),
            'nb_personnes' => $this->faker->numberBetween(1, 10),
            'is_paid' => $this->faker->boolean,
            'status' => $this->faker->randomElement(['pending', 'accepted', 'refused', 'canceled']),
            'commentaire' => $this->faker->text,
        ];
    }
}
