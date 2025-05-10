<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\SavingsGoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalculatorController extends Controller
{
    // Function to calculate expense split
    public function calculateExpenseSplit(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'participants' => 'required|integer|min:1',
        ]);

        $splitAmount = $request->amount / $request->participants;

        return response()->json([
            'message' => 'Expense split calculated successfully!',
            'splitAmount' => number_format($splitAmount, 2),
        ]);
    }

    // Function to track the budget
    public function trackBudget(Request $request)
    {
        $request->validate([
            'monthly_budget' => 'required|numeric|min:0',
            'total_spending' => 'required|numeric|min:0',
        ]);

        $remainingBudget = $request->monthly_budget - $request->total_spending;

        if ($remainingBudget > 0) {
            return response()->json([
                'message' => 'You are within budget!',
                'remainingBudget' => number_format($remainingBudget, 2)
            ]);
        } else {
            return response()->json([
                'message' => 'You have exceeded your budget!',
                'remainingBudget' => number_format(abs($remainingBudget), 2)
            ]);
        }
    }

    // Function to calculate savings goal
    public function calculateSavingsGoal(Request $request)
    {
        $request->validate([
            'goal_amount' => 'required|numeric|min:1',
            'months_to_save' => 'required|integer|min:1',
        ]);

        $monthlySavings = $request->goal_amount / $request->months_to_save;

        return response()->json([
            'message' => 'Savings goal calculated successfully!',
            'monthlySavings' => number_format($monthlySavings, 2),
        ]);
    }

    // Store a new savings goal
    public function storeSavingsGoal(Request $request)
    {
        $request->validate([
            'goal_name' => 'required|string|max:255',
            'goal_amount' => 'required|numeric|min:1',
            'months_to_save' => 'required|integer|min:1',
        ]);

        $goal = new SavingsGoal([
            'user_id' => Auth::id(),
            'goal_name' => $request->goal_name,
            'goal_amount' => $request->goal_amount,
            'months_to_save' => $request->months_to_save,
        ]);
        $goal->save();

        return response()->json(['message' => 'Savings goal added successfully!', 'goal' => $goal]);
    }
}
