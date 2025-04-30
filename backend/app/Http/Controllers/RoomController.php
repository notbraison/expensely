<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;



class RoomController extends Controller
{
    public function getRooms()
    {
        // Retrieve all rooms with their associated floor and building info
        $rooms = Room::with('floor.building')->get();

        return response()->json($rooms, 200);
    }

    public function getRoom($id)
    {
        // Retrieve a specific room by ID with associated floor and building info
        $room = Room::with('floor.building')->find($id);

        if (!$room) {
            return response()->json(['message' => 'Room not found'], 404);
        }

        return response()->json($room, 200);
    }

    /* public function getRoomsByFloor($floor_id)
    {
        // Fetch rooms for the specific floor, along with associated building info
        $rooms = Room::with('floor.building')->where('floor_id', $floor_id)->get();
        return response()->json($rooms, 200);
    } */

    public function getRoomsByFloor($floor_id)
{
    $rooms = Room::where('floor_id', $floor_id)->get(); // Fetch rooms for the specific floor
    return response()->json($rooms);
}
    
    

    public function addRoom(Request $request)
{
    // Validate request data
    $validator = Validator::make($request->all(), [
        'floor_id' => 'required|exists:floors,floor_id',
        'room_name' => 'required|string|max:255',
        'size' => 'required|string',
        'number_of_bedrooms' => 'required|integer|min:0',
        'type' => 'nullable|string|in:standard room,single room,twin room,bedsitter,studio,deluxe room,suite,king room,queen room',
        'status' => 'nullable|string|in:vacant,booked,maintenance',
        'rate' => 'required|integer',
        'currency' => 'required|string|in:Kenyan Shilling,US Dollar,Euro,Japanese Yen,Pound Sterling,Austrian Dollar,Canadian Dollar'
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 400);
    }

    try {
        // Create new room using only the validated data
        $room = Room::create($request->only([
            'floor_id',
            'room_name',
            'size',
            'number_of_bedrooms',
            'type',
            'status',
            'rate',
            'currency'
        ]));

        return response()->json($room, 201); // Return newly created room with status 201

    } catch (QueryException $e) {
        // Handle database errors
        return response()->json(['message' => 'Room creation failed.', 'error' => $e->getMessage()], 500);
    }
}


    public function updateRoom(Request $request, $id)
    {
        // Retrieve the room by ID
        $room = Room::find($id);
    
        if (!$room) {
            return response()->json(['message' => 'Room not found'], 404);
        }
    
        // Validate request data
        $validator = Validator::make($request->all(), [
            'room_name' => 'string|max:255',
            'size' => 'string',
            'number_of_bedrooms' => 'integer|min:0',
            'type' => 'string|in:standard room,single room,twin room,bedsitter,studio,deluxe room,suite,king room,queen room',
            'status' => 'string|in:vacant,booked,maintenance',
            'rate' => 'required|integer',
            'currency' => 'required|string|in:Kenyan Shilling,US Dollar,Euro,Japanese Yen,Pound Sterling,Austrian Dollar,Canadian Dollar'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
    
        // Update room with new data
        $room->update($request->only([
            'room_name',
            'size',
            'number_of_bedrooms',
            'type',
            'status',
            'rate',
            'currency'
        ]));
    
        return response()->json($room, 200); // Return updated room
    }
    
    public function updateRoomStatus(Request $request, $id)
{
    $room = Room::findOrFail($id);
    $room->status = $request->input('status', 'vacant'); // Default to 'vacant' if no status is provided
    $room->save();

    return response()->json(['message' => 'Room status updated successfully'], 200);
}


    public function deleteRoom($id)
    {
        // Retrieve the room by ID
        $room = Room::find($id);

        if (!$room) {
            return response()->json(['message' => 'Room not found'], 404);
        }

        $room->delete();

        return response()->json(['message' => 'Room deleted successfully'], 200);
    }

    public function getVacantRooms()
{
    // Fetch rooms that are vacant
    $vacantRooms = Room::where('status', 'vacant')->with('floor.building')->get();

    return response()->json($vacantRooms, 200);
}

public function getRentedRoomsByUser($user_id)
{
    // Fetch all payments made by the user with corresponding room and booking details
    $rentedRooms = Payment::with(['room', 'booking']) // Load room and booking relationships
        ->where('user_id', $user_id)
        ->where('status', 'completed') // Only completed payments
        ->get();

    // Transform the response to include the necessary details
    $roomsInfo = $rentedRooms->map(function ($payment) {
        return [
            'payment_id' => $payment->payment_id,
            'user_id' => $payment->user_id,
            'room_id' => $payment->room_id,
            'booking_id' => $payment->booking_id,
            'room_name' => $payment->room->room_name,
            'type' => $payment->room->type,
            'size' => $payment->room->size,
            'number_of_bedrooms' => $payment->room->number_of_bedrooms,
            'rate' => $payment->amount,
            'currency' => $payment->payment_account,
            'paid_at' => $payment->paid_at,
            'booking' => [
                'booking_id' => $payment->booking->booking_id,
                'start_date' => $payment->booking->start_date,
                'end_date' => $payment->booking->end_date,
                'status' => $payment->booking->status,
                'purpose' => $payment->booking->purpose,
            ]
        ];
    });

    return response()->json($roomsInfo, 200);
}




}
