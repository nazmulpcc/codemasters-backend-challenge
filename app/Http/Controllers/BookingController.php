<?php


namespace App\Http\Controllers;


use App\Models\Booking;
use App\Models\Payment;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Bookings List API
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $bookings = Booking::with(['customer', 'room'])
            ->latest()->paginate($request->input('limit', 10));

        return $this->success($bookings);
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'room_number' => 'required|exists:rooms',
            'customer_id' => 'required|exists:customers,id',
            'type'        => 'required',
            'arrived_at'  => 'nullable|date'
        ]);

        $data['arrived_at'] = $request->filled('arrived_at')
            ? Carbon::parse($data['arrived_at'])
            : Carbon::now();

        $room = Room::where('room_number', $request->input('room_number'))
            ->where('locked_at', null)->first();

        // Lock a room as per the booking
        if($room){
            $room->update(['locked_at' => $data['arrived_at']]);
        }else{
            return $this->failed(null, 'The Room is not available now');
        }

        /** @var Booking $booking */
        $booking = Booking::create($data);
        if($amount = $request->input('amount_paid')){
            $booking->payments()->create([
                'customer_id' => $data['customer_id'],
                'amount'      => $amount
            ]);
        }
        $booking->load(['customer', 'room', 'payments']);
        $booking->append(['due_amount', 'paid_amount']);

        return $this->success($booking);
    }

    /**
     * Show Booking
     * @param $booking
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($booking, Request $request)
    {
        /** @var Booking $booking */
        $booking = Booking::with(['customer', 'room', 'payments'])
            ->findOrFail($booking);
        $booking->append(['due_amount', 'paid_amount']);

        return $this->success($booking);
    }

    /**
     * @param $booking
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function pay($booking, Request $request)
    {
        $this->validate($request, [
            'amount' => 'required|numeric|min:1'
        ]);

        /** @var Booking $booking */
        $booking = Booking::with(['room', 'payments'])->find($booking);
        if($booking->is_paid){
            return $this->failed(null,'Payment is already complete for this booking.');
        }

        $booking->payments()->create([
            'customer_id' => $booking->customer_id,
            'amount'      => $request->input('amount')
        ]);

        return $this->success(null, 'Payment has been added');
    }

    /**
     * Perform a checkout action on a booking
     * @param $booking
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function checkout($booking, Request $request)
    {
        /** @var Booking $booking */
        $booking = Booking::with(['payments', 'room'])->find($booking);

        $this->validate($request, [
            'amount_paid' => [$booking->is_paid ? 'nullable' : 'required', 'numeric', 'min:'. $booking->due_amount]
        ]);

        if($amount = $request->input('amount_paid', 0)){
            $booking->payments()->create([
                'customer_id' => $booking->customer_id,
                'amount'      => $amount
            ]);
        }

        $booking->room->update(['locked_at' => null]); // release the room
        $booking->update(['checkout_at' => Carbon::now()]); // set checkout time

        return $this->success();
    }
}
