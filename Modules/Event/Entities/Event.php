<?php

namespace Modules\Event\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Event\Database\factories\EventFactory;
use Modules\Venue\Entities\Venue;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{

    use HasFactory;

    protected $fillable = ['name', 'venue_id', 'available_tickets', 'ticket_sales_end_date'];

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function isSalesOpen()
    {
        return now()->lt($this->ticket_sales_end_date);
    }

    protected static function newFactory()
    {
        return EventFactory::new();
    }
}
