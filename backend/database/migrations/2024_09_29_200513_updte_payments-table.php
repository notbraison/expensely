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
        Schema::table('payments', function (Blueprint $table) {
            // Add a new transaction_id column
            $table->string('transaction_id')->nullable()->after('payment_id'); // Add a unique transaction ID (nullable)
            
            // Rename payment_at to paid_at for clarity
            $table->renameColumn('payment_at', 'paid_at');

            // Modify status to include 'refunded' and set default to 'pending'
            $table->enum('status', ['pending', 'completed', 'failed', 'refunded'])
                  ->default('pending')
                  ->change();

             $table->dropColumn('balance');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Reverse the changes
            $table->dropColumn('transaction_id'); // Drop the transaction_id column
            $table->renameColumn('paid_at', 'payment_at'); // Rename paid_at back to payment_at
            $table->enum('status', ['pending', 'completed', 'failed'])->default('pending')->change(); // Revert status to original

            // Optional: Recreate the balance field if you removed it
            // $table->double('balance');
        });
    }
};
