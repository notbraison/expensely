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
        Schema::create('room', function (Blueprint $table) {
            $table->id("room_id");
            $table->unsignedBigInteger('floor_id');
            $table->foreign('floor_id')->references('floor_id')->on('floor');
            $table->string("size");
            $table->string("room_name");
            $table->string("number_of_bedrooms");
            $table->string("type");            
            $table->enum("status",['booked','vacant','maintenance']);            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room');
    }
};
