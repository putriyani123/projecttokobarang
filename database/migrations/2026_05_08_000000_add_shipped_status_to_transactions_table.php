<?php

use Illuminate\Database\Migrations\Migration;
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
        // Ubah enum status agar menerima nilai 'shipped' dan 'delivered'
        DB::statement("ALTER TABLE transactions MODIFY COLUMN status ENUM('pending', 'paid', 'failed', 'shipped', 'delivered') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Kembalikan seperti semula (hati-hati jika ada data 'shipped' akan terpotong jika di-rollback)
        DB::statement("ALTER TABLE transactions MODIFY COLUMN status ENUM('pending', 'paid', 'failed') DEFAULT 'pending'");
    }
};
