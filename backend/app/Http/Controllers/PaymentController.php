<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Store a newly created payment in storage.
     */
    public function store(Request $request)
{
    $validatedData = $request->validate([
        'user_id' => 'required|exists:users,user_id',
        'room_id' => 'required|exists:room,room_id',
        'booking_id' => 'required|exists:bookings,booking_id',
        'amount' => 'required|numeric',
        'payment_method' => 'required|string',
        'payment_account' => 'nullable|string', // Ensure this is included in validation
        'status' => 'required|in:pending,completed,failed,refunded',
        'paid_at' => 'nullable|date',
    ]);

    $payment = null;
    try {
        // Use a transaction to ensure data integrity
        DB::transaction(function () use ($validatedData, &$payment) {
            // Generate a unique transaction ID
            $transactionId = uniqid();

            // Create payment with all required fields including booking_id and transaction_id
            $payment = Payment::create(array_merge($validatedData, [
                'transaction_id' => $transactionId, // Add transaction_id
            ]));

            // Update room status if the payment is successful
            if ($validatedData['status'] === 'completed') {
                $room = Room::find($validatedData['room_id']);
                $room->status = 'booked';
                $room->save();
            }
        });

        return response()->json([
            'message' => 'Payment created successfully!',
            'payment' => $payment,
        ], 201);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Error creating payment: ' . $e->getMessage(),
        ], 500);
    }
}

    /**
     * Show the payment details.
     */
    public function show($id)
    {
        $payment = Payment::findOrFail($id);

        return response()->json([
            'payment' => $payment,
        ], 200);
    }
    public function showAll(Request $request)
    {
        //display all $payments
        $payment = Payment::all();

        if ($payment) {
            return response()->json($payment);
        } else {
            return response("No payments found");
        }
    }

    /**
     * Update the specified payment status.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'status' => 'required|in:pending,completed,failed,refunded',
        ]);

        $payment = Payment::findOrFail($id);

        try {
            DB::transaction(function () use ($payment, $validatedData) {
                $payment->update($validatedData);

                // Update room status based on payment status
                $room = Room::find($payment->room_id);
                if ($validatedData['status'] === 'completed') {
                    $room->status = 'booked';
                } elseif (in_array($validatedData['status'], ['refunded', 'failed'])) {
                    $room->status = 'vacant';
                }
                $room->save();
            });

            return response()->json([
                'message' => 'Payment status updated successfully!',
                'payment' => $payment,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error updating payment status: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Simulate a payment for testing purposes and store it in the database on success.
     */
    public function simulatePayment(Request $request)
{
    $validatedData = $request->validate([
        'user_id' => 'required|exists:users,user_id',
        'room_id' => 'required|exists:room,room_id',
        'booking_id' => 'required|exists:bookings,booking_id',
        'payment_method' => 'required|in:credit_card,mobile_wallet,bank_transfer,m-pesa',
        'amount' => 'required|numeric',
        'payment_account' => 'nullable|string', // Add this line
    ]);

    // Simulate payment success or failure
   // $paymentSuccess = rand(0, 1); // Randomly decide if the payment is successful
    $paymentSuccess = 1 ; //make it work every time
    if ($paymentSuccess) {
        try {
            // Generate a unique transaction ID
            $transactionId = uniqid();

            $payment = Payment::create([
                'user_id' => $validatedData['user_id'],
                'room_id' => $validatedData['room_id'],
                'booking_id' => $validatedData['booking_id'], // Ensure this is included
                'amount' => $validatedData['amount'],
                'payment_method' => $validatedData['payment_method'],
                'payment_account' => $validatedData['payment_account'], 
                'transaction_id' => $transactionId, // Ensure this is included
                'status' => 'completed',
                'paid_at' => now(),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Payment processed successfully',
                'transaction_id' => $transactionId,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Payment processing error: ' . $e->getMessage(),
            ], 500);
        }
    } else {
        return response()->json([
            'status' => 'failure',
            'message' => 'Payment failed. Please try again.',
        ], 400);
    }
}

// In app/Http/Controllers/PaymentController.php

public function getPaymentHistory($user_id)
{
    // Fetch payments made by the user with corresponding room details
    $payments = Payment::with('room') // Assuming the Payment model has a relationship defined with Room
        ->where('user_id', $user_id)
        ->get();

    // Transform the response to include relevant payment and room data
    $paymentHistory = $payments->map(function ($payment) {
        // Fetch room details if not already loaded
        $room = $payment->room()->with('floor.building')->first(); // Fetch the room details

        return [
            'payment_id' => $payment->payment_id,
            'user_id' => $payment->user_id,
            'room_id' => $payment->room_id,
            'room_name' => $room ? $room->room_name : 'N/A', // Include room name
            'amount' => $payment->amount,
            'paid_at' => $payment->paid_at,
            'status' => $payment->status,
            'transaction_id' => $payment->transaction_id,
            'booking_id' => $payment->booking_id,
            'payment_method' => $payment->payment_method,
            'payment_account' => $payment->payment_account,
        ];
    });

    return response()->json($paymentHistory, 200);
}



public function destroy($id)
{
    try {
        $payment = Payment::findOrFail($id); // Use findOrFail to ensure the payment exists

        // Check if the payment was completed and the room should be made vacant
        if ($payment->status === 'completed') {
            $room = Room::find($payment->room_id);
            if ($room) {
                $room->status = 'vacant'; // Set room status to vacant
                $room->save(); // Save the updated room status
            }
        }

        // Delete the payment
        $payment->delete();

        return response()->json(['message' => 'Payment deleted successfully.'], 200);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Error deleting payment: ' . $e->getMessage()], 500);
    }
}



}
