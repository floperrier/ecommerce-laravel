<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsersAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('shipping_name');
            $table->string('address');
            $table->integer('zipcode');
            $table->string('country');
            $table->string('city');
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_addresses');
    }
}
