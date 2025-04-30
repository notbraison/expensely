<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('payments', function (Blueprint $table) {
        // Drop the incorrect foreign key first, if it exists
        $table->dropForeign(['room_id']); 

        // Add the correct foreign key referencing 'room'
        $table->foreign('room_id')->references('id')->on('room')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('payments', function (Blueprint $table) {
        // Optionally, you can reverse the change here
        $table->dropForeign(['room_id']);
        $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
    });
}

};
