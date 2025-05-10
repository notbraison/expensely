<?php

namespace Database\Seeders;

use App\Models\Notification;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Example of a notification
        Notification::create([
            'user_id' => 1,
            'title' => 'Rent Payment Due',
            'message' => 'Your rent payment is due in 3 days.',
            'type' => 'upcoming_bill',
            'read' => false,
            'date' => now()->addDays(3),
        ]);

        // Add more notifications as needed
        Notification::create([
            'user_id' => 1,
            'title' => 'Friend Request',
            'message' => 'John Doe has sent you a friend request.',
            'type' => 'friend_request',
            'read' => false,
            'date' => now(),
        ]);
    }
}