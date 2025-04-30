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
        // Drop the 'rooms' table if it exists
        Schema::dropIfExists('room');

        // Create the new 'room' table
        Schema::create('room', function (Blueprint $table) {
            $table->id("room_id");
            $table->unsignedBigInteger('floor_id');
            $table->foreign('floor_id')->references('floor_id')->on('floors');
            $table->string("size");
            $table->string("room_name");
            $table->string("number_of_bedrooms");
            $table->string("type");            
            $table->enum("status", ['booked', 'vacant', 'maintenance']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the 'room' table if rolling back the migration
        Schema::dropIfExists('room');

        // Optionally, recreate the 'rooms' table if you need to roll back to the old structure
        Schema::create('room', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Example field
            $table->timestamps();
        });
    }
};
