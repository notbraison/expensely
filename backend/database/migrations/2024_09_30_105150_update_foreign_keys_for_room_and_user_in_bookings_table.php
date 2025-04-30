<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForeignKeysForRoomAndUserInBookingsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Drop the existing foreign key constraints on user_id and room_id
            $table->dropForeign(['user_id']);
            $table->dropForeign(['room_id']);
            
            // Update the foreign key for user_id to reference user_id in the users table
            $table->foreign('user_id')
                ->references('user_id') // Assuming 'user_id' is the primary key in the 'users' table
                ->on('users')
                ->onDelete('cascade'); // Cascade delete when a user is deleted

            // Update the foreign key for room_id to reference room_id in the room table
            $table->foreign('room_id')
                ->references('room_id') // Assuming 'room_id' is the primary key in the 'room' table
                ->on('room')
                ->onDelete('cascade'); // Cascade delete when a room is deleted
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Rollback: drop the updated foreign key constraints
            $table->dropForeign(['user_id']);
            $table->dropForeign(['room_id']);

            // Revert the foreign key back to the original setup
            $table->foreign('user_id')
                ->references('id') // Revert to default assumption that 'id' is the primary key
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('room_id')
                ->references('id') // Revert to default assumption that 'id' is the primary key
                ->on('room')
                ->onDelete('cascade');
        });
    }
}
