<?php

namespace App\Http\Controllers;

use App\Models\LogNotes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogNotesController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'log_note_text' => 'required|string|max:8000',
            'payment_id' => 'required|exists:payments,payment_id',
            'room_id' => 'required',
           'user_id' => 'required|exists:users,user_id',
        ]);

        $logNote = LogNotes::create([
            'user_id' =>  $validatedData['user_id'],
            'log_note_text' => $validatedData['log_note_text'],
            'payment_id' => $validatedData['payment_id'],
            'room_id' => $validatedData['room_id'],
        ]);

        return response()->json($logNote, 201);
    }

    public function index()
    {
        $logNotes = LogNotes::with(['user', 'room'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($logNotes, 200);
    }

    public function edit($id)
    {
        $logNote = LogNotes::findOrFail($id);
        // Check if the logged-in user is the one who created the log note
        if ($logNote->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($logNote, 200);
    }

    public function update(Request $request, $id)
    {
        $logNote = LogNotes::findOrFail($id);
        // Check if the logged-in user is the one who created the log note
        if ($logNote->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validatedData = $request->validate([
            'log_note_text' => 'required|string|max:8000',
        ]);

        $logNote->update($validatedData);

        return response()->json($logNote, 200);
    }

    public function destroy($id)
    {
        $logNote = LogNotes::findOrFail($id);
        // Check if the logged-in user is the one who created the log note
        if ($logNote->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $logNote->delete();

        return response()->json(['message' => 'Log note deleted successfully'], 200);
    }
}
