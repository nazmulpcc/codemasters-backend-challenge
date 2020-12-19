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
 * @property bool $is_paid
 * @property float|int $due_amount
 * @property int $paid_amount
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
     * Accessor for $is_paid Attribute, indicates if payment is completed for this booking
     * @return bool
     */
    public function getIsPaidAttribute()
    {
        return $this->due_amount <= 0;
    }

    /**
     * Accessor for $paid_amount, indicates total paid amount
     * @return mixed
     */
    public function getPaidAmountAttribute()
    {
        return $this->payments->sum('amount');
    }

    /**
     * Accessor for $due_amount attribute, indicates the payment due amount
     * @return float|int
     */
    public function getDueAmountAttribute()
    {
        return $this->room->price - $this->paid_amount;
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
