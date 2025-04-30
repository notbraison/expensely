<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForeignKeysInBookingsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Drop the existing foreign key on room_id to 'rooms' if it exists
            $table->dropForeign(['room_id']);
            
            // Add a new foreign key that references the 'room' table instead of 'rooms'
            $table->foreign('room_id')
                ->references('id') // Assuming 'id' is the primary key in the 'room' table
                ->on('room')
                ->onDelete('cascade'); // Cascade delete when room is deleted
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Rollback the foreign key reference to the 'rooms' table
            $table->dropForeign(['room_id']);
            
            // Revert the foreign key back to 'rooms' table
            $table->foreign('room_id')
                ->references('id') // Assuming 'id' is the primary key in the 'rooms' table
                ->on('rooms')
                ->onDelete('cascade');
        });
    }
}
