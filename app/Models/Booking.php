<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Booking
 * @package App\Models
 * @property int $id
 * @property int $customer_id
 * @property string $room_number
 * @property Carbon $arrived_at
 * @property Carbon $checkout_at
 * @property string $type
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Customer $customer
 * @property Payment[]|Collection $payments
 * @property Room $room
 *
 */
class Booking extends Model
{
    protected $guarded = [];

    protected $dates = ['arrived_at', 'checkout_at'];

    /**
     * A booking belongs to a Customer
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * A booking may have multiple payments
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * A booking entry belongs to a specific room
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_number', 'room_number');
    }
}
