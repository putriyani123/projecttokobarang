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

            // 🔥 FIX DI SINI (boleh null karena tanpa login)
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->foreignId('address_id')->constrained()->cascadeOnDelete();

            $table->string('midtrans_order_id')->unique();
            $table->integer('total_price');

            $table->enum('status', ['pending','paid','failed'])->default('pending');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}