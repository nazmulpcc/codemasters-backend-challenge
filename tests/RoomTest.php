<?php


use App\Models\Room;
use Laravel\Lumen\Testing\DatabaseMigrations;

class RoomTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createRoom();
        $this->be($this->getAdmin());
    }

    public function testIndexApi()
    {
        $this->get('/rooms');

        $this->assertResponseOk();

        $this->assertEquals(Room::count(), $this->response->json('total'));
    }

    public function testShowApi()
    {
        $room = Room::latest()->first();
        $this->get("/rooms/{$room->id}");

        $this->assertResponseOk();
        $this->assertEquals(
            $room->room_number, $this->response->json('data.room_number')
        );
    }
}
