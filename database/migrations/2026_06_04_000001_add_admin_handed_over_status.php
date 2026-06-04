<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE transactions MODIFY COLUMN status ENUM('pending', 'paid', 'confirmed', 'assigned', 'courier_accepted', 'admin_handed_over', 'failed', 'shipped', 'delivered', 'completed', 'returned') DEFAULT 'pending'");
    }

    public function down()
    {
        DB::statement("ALTER TABLE transactions MODIFY COLUMN status ENUM('pending', 'paid', 'confirmed', 'assigned', 'courier_accepted', 'failed', 'shipped', 'delivered', 'completed', 'returned') DEFAULT 'pending'");
    }
};
