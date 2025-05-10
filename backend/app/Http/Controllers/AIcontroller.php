<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AIController extends Controller
{
    public function getInsights(Request $request)
    {
        // Sample AI logic (use OpenAI or other AI APIs here)
        $query = $request->input('query');

        // Example logic to give insights based on the query
        if (strpos($query, 'spending') !== false) {
            // Example AI insights related to spending (could be dynamic based on real data)
            return response()->json([
                'response' => 'Based on your last 3 months, you are spending 30% more on entertainment compared to other categories. Consider reducing your monthly subscriptions to save more.'
            ]);
        }

        // Handle more conditions or send a default response
        return response()->json([
            'response' => 'I can provide insights based on your expenses. Please ask me something related to your spending or budget.'
        ]);
    }
}
