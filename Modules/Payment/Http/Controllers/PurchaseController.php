<?php

namespace Modules\Payment\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Event\Entities\Event;
use Modules\Payment\Entities\TicketPurchase;

class PurchaseController extends Controller
{
    public function purchase(Request $request, $eventId)
    {
        // Find the event
        $event = Event::findOrFail($eventId);

        // Validate request data
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid email address.'], 400);
        }

        // Check if event is closed or sold out
        if (!$event->isSalesOpen()) {
            return response()->json(['error' => 'The event is closed.'], 400);
        }

        if ($event->available_tickets <= 0) {
            return response()->json(['error' => 'No available seats for this event.'], 400);
        }

        // Check for duplicate purchases by the same email for this event
        $existingPurchase = TicketPurchase::where('event_id', $event->id)
            ->where('email', $request->email)
            ->first();

        if ($existingPurchase) {
            return response()->json(['error' => 'Email already used for this event.'], 400);
        }

        // Process the purchase and update sold tickets
        $purchase = TicketPurchase::create([
            'event_id' => $event->id,
            'email' => $request->email,
            'transaction_id' => uniqid(),
        ]);

        // Update sold tickets count
        $event->decrement('available_tickets');

        return response()->json(
            ['transaction_id' => $purchase->transaction_id], 200
        );
    }
}
