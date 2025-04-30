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
            Schema::create('payments', function (Blueprint $table) {
                $table->id('payment_id');
                $table->unsignedBigInteger('user_id');
                $table->foreign('user_id')->references('user_id')->on('user');
                $table->unsignedBigInteger('room_id');
                $table->foreign('room_id')->references('room_id')->on('room');
                $table->datetime('payment_at');
                $table->double('amount');
                $table->double('balance');
                $table->enum('status',['pending','completed','failed']);
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('payments');
        }
    };
