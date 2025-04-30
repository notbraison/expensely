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
        // Remove foreign key constraints
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign(['payment_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Re-add foreign key constraints if rolling back
        Schema::table('comments', function (Blueprint $table) {
            $table->foreign('payment_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }
};
