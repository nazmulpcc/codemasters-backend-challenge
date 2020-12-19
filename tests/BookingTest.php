<?php


use App\Models\Booking;
use Laravel\Lumen\Testing\DatabaseMigrations;

class BookingTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var \App\Models\Customer
     */
    protected $customer;

    /**
     * @var \App\Models\Room
     */
    protected $room;

    protected function setUp(): void
    {
        parent::setUp();

        $this->be($this->getAdmin());
        $this->room = $this->createRoom();
        $this->customer = $this->createCustomer();
    }

    public function testCreateApi()
    {
        $previous = Booking::count();

        $this->post('/bookings', [
            'room_number' => $this->room->room_number,
            'customer_id' => $this->customer->id,
            'type'        => 'general',
            'amount_paid' => 50
        ]);

        $this->assertResponseOk();
        $this->seeInDatabase('bookings', [
            'room_number' => $this->room->room_number,
            'customer_id' => $this->customer->id,
        ]);
        $this->assertEquals(
            $previous + 1, Booking::count()
        );
        $this->assertEquals(
            $this->room->price-50, $this->response->json('data.due_amount')
        );
    }
}
