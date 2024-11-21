<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Link to users table
            $table->foreignId('rental_id')->constrained()->onDelete('cascade'); // Link to rentals table
            $table->enum('payment_method', ['bank_transfer', 'cash']); // Payment method (or you can add more options)
            $table->decimal('total_payment', 10, 2); // Total payment amount
            $table->enum('status', ['Pending', 'Completed', 'Failed'])->default('Pending'); // Transaction status
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
