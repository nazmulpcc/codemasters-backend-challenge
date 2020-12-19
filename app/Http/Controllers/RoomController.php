<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $rooms = Room::latest()
            ->paginate($request->input('limit', 10));

        return $this->success($rooms);
    }

    /**
     * @param Room $room
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($room, Request $request)
    {
        $room = Room::findOrFail($room);
        $room->load(['bookings']);

        return $this->success($room);
    }
}
