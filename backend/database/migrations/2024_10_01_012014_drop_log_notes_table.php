<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropLogNotesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::dropIfExists('log_notes');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // You can define the structure of the table here if you want to rollback
        Schema::create('log_notes', function (Blueprint $table) {
            $table->id('note_id');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('payment_id')->constrained('payments')->onDelete('cascade');
            $table->foreignId('room_id')->constrained('room')->onDelete('cascade');
            $table->string('log_note_text', 8000);
            $table->timestamps();
        });
    }
}
