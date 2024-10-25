<?php

namespace Modules\Payment\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Modules\Event\Entities\Event;
use Modules\Venue\Entities\Venue;
use Modules\Payment\Entities\TicketPurchase;

class TicketPurchaseTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_purchase_a_ticket()
    {
        $venue = Venue::factory()->create(['capacity' => 100]);
        $event = Event::factory()->create(['venue_id' => $venue->id, 'available_tickets' => 50]);

        $response = $this->postJson("/api/events/{$event->id}/purchase", [
            'email' => 'test@example.com',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['transaction_id']);
    }

    /** @test */
    public function it_cannot_purchase_ticket_if_sold_out()
    {
        $venue = Venue::factory()->create(['capacity' => 100]);
        $event = Event::factory()->create(['venue_id' => $venue->id, 'available_tickets' => 0]);

        $response = $this->postJson("/api/events/{$event->id}/purchase", [
            'email' => 'test@example.com',
        ]);

        $response->assertStatus(400)
            ->assertJson(['error' => 'No available seats for this event.']);
    }
}
