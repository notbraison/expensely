<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFloorsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('floors', function (Blueprint $table) {
            $table->dropForeign(['building_id']); // Remove the incorrect foreign key constraint
            $table->foreign('building_id')->references('building_id')->on('buildings'); // Add the correct one
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('floors', function (Blueprint $table) {
            $table->dropForeign(['building_id']); // Remove the correct foreign key constraint
            $table->foreign('building_id')->references('building_id')->on('building'); // Re-add the incorrect one (if needed)
        });
    }
}

