<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/YYYY_MM_DD_modify_comments_table_for_expenses.php
public function up()
{
    Schema::table('comments', function (Blueprint $table) {
        // Remove unnecessary columns
        $table->dropColumn('admin_id');
    });
}

public function down()
{
    Schema::table('comments', function (Blueprint $table) {
        // Revert the changes if rolling back
        $table->dropColumn('expense_id');
        $table->dropColumn('user_id');
        $table->dropColumn('comment_text');

        // Re-add removed columns if necessary
        $table->foreignId('payment_id');
        $table->foreignId('room_id');
    });
}

};
