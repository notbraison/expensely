<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('comments', function (Blueprint $table) {
        $table->unsignedBigInteger('admin_id')->nullable(); // Add nullable admin_id column
    });
}

public function down(): void
{
    Schema::table('comments', function (Blueprint $table) {
        $table->dropColumn('admin_id'); // Drop the admin_id column if rolled back
    });
}

};
