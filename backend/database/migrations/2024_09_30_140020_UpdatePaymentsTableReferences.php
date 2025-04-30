<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePaymentsTableReferences extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Drop existing incorrect foreign key constraints if they exist
            $table->dropForeign(['user_id']);
            $table->dropForeign(['room_id']);

            // Fix the user_id foreign key reference
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Fix the room_id foreign key reference
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');

            // Fix the booking_id foreign key reference if it was created earlier
            if (Schema::hasColumn('payments', 'booking_id')) {
                $table->dropForeign(['booking_id']); // Drop old foreign key if it exists
                $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Rollback the changes by dropping the fixed foreign keys
            $table->dropForeign(['user_id']);
            $table->dropForeign(['room_id']);
            if (Schema::hasColumn('payments', 'booking_id')) {
                $table->dropForeign(['booking_id']);
            }
        });
    }
}
