<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Reference to users table
            $table->string('title'); // Title of the notification
            $table->text('message'); // Message content of the notification
            $table->enum('type', ['upcoming_bill', 'overdue_payment', 'friend_request', 'system_alert', 'custom_reminder']); // Type of notification
            $table->boolean('read')->default(false); // Read status (unread by default)
            $table->timestamp('date')->nullable(); // Date of notification (optional, used for scheduling reminders)
            $table->timestamps(); // Laravel's created_at and updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
