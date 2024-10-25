<?php

namespace Modules\Event\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Event\Entities\Event;
use Modules\Venue\Entities\Venue;

class EventFactory extends Factory
{
    protected $model = Event::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'venue_id' => Venue::factory(),
            'available_tickets' => $this->faker->numberBetween(0, 50),
            'ticket_sales_end_date' => $this->faker->dateTimeBetween('now', '+1 month'),
        ];
    }
}
