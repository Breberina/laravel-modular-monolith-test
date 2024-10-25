<?php

namespace Modules\Venue\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Event\Entities\Event;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Venue\Database\factories\VenueFactory;


class Venue extends Model
{

    use HasFactory;

    protected $fillable = ['name', 'capacity'];

    public function events(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Event::class);
    }

    protected static function newFactory(): VenueFactory
    {
        return VenueFactory::new();
    }
}
