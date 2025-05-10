<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Fetch all notifications for the authenticated user
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())->get();
        return response()->json($notifications);
    }

    // Mark a notification as read
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);

        // Ensure the notification belongs to the logged-in user
        if ($notification->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $notification->read = true;
        $notification->save();

        return response()->json(['message' => 'Notification marked as read']);
    }

    // Mark all notifications as read
    public function markAllAsRead()
    {
        $notifications = Notification::where('user_id', Auth::id())->get();

        foreach ($notifications as $notification) {
            $notification->read = true;
            $notification->save();
        }

        return response()->json(['message' => 'All notifications marked as read']);
    }

    // Delete a notification
    public function delete($id)
    {
        $notification = Notification::findOrFail($id);

        // Ensure the notification belongs to the logged-in user
        if ($notification->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $notification->delete();

        return response()->json(['message' => 'Notification deleted']);
    }
}
