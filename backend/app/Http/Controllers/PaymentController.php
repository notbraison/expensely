<?php

namespace App\Http\Controllers;

use App\Models\Payment; // Assuming you have a Payment model
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // Fetch all payments made by the logged-in user
    public function index(Request $request)
    {
        $user = auth()->user();

        // Get payments related to the user
        $payments = Payment::where('user_id', $user->user_id)
                           ->orderBy('created_at', 'desc') // You can order by date
                           ->get();

        return response()->json($payments);
    }

    // View details of a specific payment
    public function show($paymentId)
    {
        $payment = Payment::findOrFail($paymentId);

        // Ensure the payment belongs to the authenticated user
        if ($payment->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($payment);
    }
}
