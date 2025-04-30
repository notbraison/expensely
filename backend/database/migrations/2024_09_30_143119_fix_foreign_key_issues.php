<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixForeignKeyIssues extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update foreign key constraints in the payments table
        Schema::table('payments', function (Blueprint $table) {
            // Drop existing foreign key constraints to ensure no conflicts
            $table->dropForeign(['user_id']);
            $table->dropForeign(['room_id']);
            
            // Fix the foreign key for user_id
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');

            // Fix the foreign key for room_id
            $table->foreign('room_id')->references('room_id')->on('room')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Drop the foreign keys in reverse
            $table->dropForeign(['user_id']);
            $table->dropForeign(['room_id']);
        });
    }
}
