<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Room;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // Store a new booking
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'room_id' => 'required|exists:room,room_id',
            'purpose' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $booking = Booking::create([
            'user_id' => $request->user_id,
            'room_id' => $request->room_id,
            'purpose' => $request->purpose,
            'status' => 'pending',
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return response()->json(['message' => 'Booking created successfully!', 'booking' => $booking], 201);
    }

    // Fetch all bookings or bookings for a specific user
    public function index(Request $request, $user_id = null)
    {
        if ($user_id) {
            // Fetch bookings for a specific user
            $bookings = Booking::where('user_id', $user_id)->with('room')->get();
        } else {
            // Fetch all bookings
            $bookings = Booking::with('room')->get();
        }

        return response()->json($bookings, 200);
    }

    // Show a specific booking by ID
    public function show($id)
    {
        $booking = Booking::with('room')->findOrFail($id);
        return response()->json($booking, 200);
    }

    // Update a payment status
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'status' => 'required|in:pending,completed,failed,refunded',
        ]);

        // Find the payment and update its status
        $payment = Payment::findOrFail($id);
        $payment->update($validatedData);

        // Update room status accordingly
        $room = Room::find($payment->room_id);

        if ($payment->status == 'completed') {
            $room->status = 'booked';
        } elseif (in_array($payment->status, ['refunded', 'failed'])) {
            $room->status = 'vacant'; // Revert room to vacant if payment fails or is refunded
        }

        $room->save();

        return response()->json([
            'message' => 'Payment status updated successfully!',
            'payment' => $payment,
        ], 200);
    }

    public function destroy($id)
{
    $booking = Booking::findOrFail($id);
    $booking->delete(); // This will remove the booking from the 'bookings' table
    return response()->json(['message' => 'Booking canceled successfully.'], 200);
}


}
