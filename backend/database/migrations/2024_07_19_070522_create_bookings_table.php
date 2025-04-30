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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id('booking_id');
            
            // Foreign key for the 'users' table
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            // Foreign key for the 'room' table (use 'room' not 'rooms')
            $table->unsignedBigInteger('room_id');
            $table->foreign('room_id')->references('id')->on('room')->onDelete('cascade');
            
            $table->string('purpose');
            $table->enum('status', ['pending', 'confirmed', 'cancelled']);
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
