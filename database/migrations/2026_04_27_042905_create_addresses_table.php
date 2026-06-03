<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();

            // optional user (karena tidak pakai login)
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->string('province');
            $table->string('city');
            $table->string('district');
            $table->string('village');
            $table->text('detail_address');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}