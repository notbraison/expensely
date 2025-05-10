<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // Fetch transactions for the logged-in user
        $transactions = Transaction::where('user_id', $user->user_id)->get();

        return response()->json($transactions);
    }
}
