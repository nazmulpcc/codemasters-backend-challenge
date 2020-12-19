<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Room
 * @package App\Models
 * @property int $id
 * @property string $room_number
 * @property float $price
 * @property int $max_persons
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Booking[]|Collection $bookings
 */
class Room extends Model
{
    protected $guarded = [];

    /**
     * Each room can be booked many times
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'room_number', 'room_number');
    }
}
