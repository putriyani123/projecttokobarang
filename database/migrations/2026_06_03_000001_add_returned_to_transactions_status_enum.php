<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. Add 'returned' to the transactions table status ENUM
        DB::statement("ALTER TABLE transactions MODIFY COLUMN status ENUM('pending', 'paid', 'confirmed', 'failed', 'shipped', 'delivered', 'completed', 'returned') DEFAULT 'pending'");

        // 2. Add 'status' column to transaction_items table
        Schema::table('transaction_items', function (Blueprint $table) {
            $table->string('status')->default('pending')->after('price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 1. Remove 'status' column from transaction_items
        Schema::table('transaction_items', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        // 2. Modify transactions status ENUM back
        DB::statement("ALTER TABLE transactions MODIFY COLUMN status ENUM('pending', 'paid', 'confirmed', 'failed', 'shipped', 'delivered', 'completed') DEFAULT 'pending'");
    }
};
