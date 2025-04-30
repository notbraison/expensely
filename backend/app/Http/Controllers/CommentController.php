<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function createComment(Request $request)
    {
        $request->validate([
            'comment_text' => 'required|string|max:8000',
            'payment_id' => 'exists:payments,payment_id',
            'room_id' => 'required|integer', // No longer checking foreign key
            'user_id' => 'integer', // No longer checking foreign key
            'admin_id' => 'integer' // No longer checking foreign key
        ]);

        $comment = Comment::create([
            'user_id' => $request->user_id,
            'admin_id' => $request->admin_id,
            'comment_text' => $request->comment_text,
            'payment_id' => $request->payment_id,
            'room_id' => $request->room_id,
        ]);

        return response()->json($comment, 201);
    }

    public function index()
    {
        $comments = Comment::whereNotNull('user_id')->orderBy('created_at', 'desc')->get();
        return response()->json($comments, 200);
    }

    //function to get comments where admin_id is not null
    public function getAdminComments()
    {
        $comments = Comment::whereNotNull('admin_id')->orderBy('created_at', 'desc')->get();
        return response()->json($comments, 200);
    }

    public function edit($id)
    {
        $comment = Comment::findOrFail($id);
        return response()->json($comment, 200);
    }

    public function update(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);

        $validatedData = $request->validate([
            'comment_text' => 'required|string|max:8000',
        ]);

        $comment->update($validatedData);
        return response()->json($comment, 200);
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return response()->json(['message' => 'Comment deleted successfully'], 200);
    }

    // New function to get comments by user ID
    public function getCommentsByUserId($userId)
    {
        $comments = Comment::where('user_id', $userId)->orderBy('created_at', 'desc')->get();
        return response()->json($comments, 200);
    }

    // New function to get comments by room ID
    public function getCommentsByRoomId($roomId)
    {
        $comments = Comment::where('room_id', $roomId)->orderBy('created_at', 'desc')->get();
        return response()->json($comments, 200);
    }
}
