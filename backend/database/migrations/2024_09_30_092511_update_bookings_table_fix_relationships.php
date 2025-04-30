<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBookingsTableFixRelationships extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Update the foreign key for the 'users' table
            $table->foreign('user_id')
                ->references('id') // Ensure the correct primary key for the 'users' table
                ->on('users')
                ->onDelete('cascade');

            // Update the foreign key for the 'room' table (not 'rooms')
            $table->foreign('room_id')
                ->references('id') // Ensure the correct primary key for the 'room' table
                ->on('room')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Drop foreign keys
            $table->dropForeign(['user_id']);
            $table->dropForeign(['room_id']);
        });
    }
}
