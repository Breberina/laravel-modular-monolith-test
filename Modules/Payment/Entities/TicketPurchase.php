<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Event\Entities\Event;

class TicketPurchase extends Model
{
    protected $fillable = ['event_id', 'email', 'transaction_id'];


    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
