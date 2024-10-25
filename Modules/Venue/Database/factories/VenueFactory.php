<?php

namespace Modules\Venue\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Venue\Entities\Venue;

class VenueFactory extends Factory
{
    protected $model = Venue::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company . ' Venue',
            'capacity' => $this->faker->numberBetween(50, 500),
        ];
    }
}
