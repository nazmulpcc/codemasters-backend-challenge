<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Payment
 * @package App\Models
 * @property int $id
 * @property int $customer_id
 * @property int $booking_id
 * @property double $amount
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Payment extends Model
{
    protected $guarded = [];

    /**
     * A payment is made by a Customer
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * A payment is made for a Booking
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
