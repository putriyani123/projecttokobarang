<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {Schema::create('checkouts', function (Blueprint $table) {
    $table->id();
    $table->string('order_id')->unique();
    $table->integer('total');
    $table->string('status')->default('pending');
    $table->string('snap_token')->nullable();
    $table->timestamps();
});
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('checkouts');
    }
}
