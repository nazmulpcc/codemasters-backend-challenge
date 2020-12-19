<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i<10; $i++){
            Room::firstOrCreate([
                'room_number' => 100 + $i,
            ], [
                'price'       => 100,
                'max_persons' => rand(3, 10),
                'room_type'   => 'general'
            ]);
        }
    }
}
