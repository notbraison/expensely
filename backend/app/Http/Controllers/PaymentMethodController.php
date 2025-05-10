<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class PaymentMethodController extends Controller
{
    //
    public function addPaymentMethod(Request $request)
    {
        $request->validate([
            'method' => 'required|in:mpesa,paypal,stripe,stanchart',
            'account_id' => 'required|string',
        ]);

        $paymentMethod = PaymentMethod::create([
            'user_id' => Auth::id(),
            'method' => $request->method,
            'account_id' => $request->account_id,
        ]);

        return response()->json(['message' => 'Payment method added successfully']);
    }

    public function getPaymentMethods()
    {
        $paymentMethods = PaymentMethod::where('user_id', Auth::id())->get();

        return response()->json($paymentMethods);
    }

    public function removePaymentMethod($paymentMethodId)
    {
        $paymentMethod = PaymentMethod::findOrFail($paymentMethodId);

        if ($paymentMethod->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $paymentMethod->delete();

        return response()->json(['message' => 'Payment method removed successfully']);
    }
}
