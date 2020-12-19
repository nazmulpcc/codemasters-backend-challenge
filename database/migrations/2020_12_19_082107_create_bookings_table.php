<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('room_number');
            $table->timestamp('arrived_at')->nullable();
            $table->timestamp('checkout_at')->nullable();
            $table->string('type');
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('room_number')->references('room_number')->on('rooms')
                ->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
