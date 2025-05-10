<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Friendship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendshipController extends Controller
{
    // Send a friend request
    public function sendRequest($friendId)
    {
        $friend = User::findOrFail($friendId);
        $userId = Auth::id(); // Get the current logged-in user's ID

        // Check if the friend request already exists
        $existingRequest = Friendship::where(function ($query) use ($userId, $friendId) {
            $query->where('user_id', $userId)->where('friend_id', $friendId);
        })->orWhere(function ($query) use ($userId, $friendId) {
            $query->where('user_id', $friendId)->where('friend_id', $userId);
        })->first();

        if ($existingRequest) {
            return response()->json(['message' => 'Friend request already sent or exists'], 400);
        }

        // Create the friendship record
        Friendship::create([
            'user_id' => $userId,
            'friend_id' => $friendId,
            'status' => 'pending',
        ]);

        return response()->json(['message' => 'Friend request sent successfully']);
    }

    // Send a friend request by email
    public function sendFriendRequestByEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',  // Ensure email exists in the users table
        ]);

        $friend = User::where('email', $request->email)->first();
        $userId = Auth::id();  // Get the logged-in user's ID

        // Check if a friendship already exists
        $existingRequest = Friendship::where(function ($query) use ($userId, $friend) {
            $query->where('user_id', $userId)->where('friend_id', $friend->user_id);
        })->orWhere(function ($query) use ($userId, $friend) {
            $query->where('user_id', $friend->user_id)->where('friend_id', $userId);
        })->first();

        if ($existingRequest) {
            return response()->json(['message' => 'Friend request already sent or exists'], 400);
        }

        // Create the friendship request
        Friendship::create([
            'user_id' => $userId,
            'friend_id' => $friend->user_id,
            'status' => 'pending',
        ]);

        return response()->json(['message' => 'Friend request sent successfully']);
    }

    // Accept or decline a friend request
    public function respondToRequest($friendshipId, Request $request)
    {
        $friendship = Friendship::findOrFail($friendshipId);

        if ($friendship->user_id !== Auth::id() && $friendship->friend_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized action'], 403);
        }

        $request->validate(['status' => 'required|in:accepted,declined']);
        $friendship->status = $request->status;
        $friendship->save();

        return response()->json(['message' => 'Friend request ' . $request->status]);
    }

    // Fetch the friends of the logged-in user
    public function viewFriends()
    {
        $user = Auth::user();
        $friends = $user->friends()->wherePivot('status', 'accepted')->get();

        return response()->json(['data' => $friends]);
    }

    // Remove a friend
    public function removeFriend($friendshipId)
    {
        $friendship = Friendship::findOrFail($friendshipId);

        // Ensure the logged-in user is part of this friendship
        if ($friendship->user_id !== Auth::id() && $friendship->friend_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized action'], 403);
        }

        $friendship->delete();

        return response()->json(['message' => 'Friend removed successfully']);
    }

}


