<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('car_id')->constrained('cars')->onDelete('cascade');
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->text('address');
            $table->string('id_card');
            $table->integer('duration');
            $table->dateTime('return_date');
            $table->dateTime('start_date');
            $table->string('payment_method');
            $table->decimal('total_payment', 10, 2);
            $table->string('status')->default('tersedia');
            // $table->unsignedBigInteger('rental_id')->nullable()->after('password');
            // $table->foreign('rental_id')->references('id')->on('rentals')->onDelete('cascade');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
