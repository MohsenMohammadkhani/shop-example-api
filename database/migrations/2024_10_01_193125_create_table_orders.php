<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('price_order')->unsigned();
            $table->integer('price_total')->unsigned();
            $table->integer('price_tax')->unsigned();
            $table->integer('price_delivery')->unsigned();
            $table->integer('discount_id')->nullable();
            $table->date('delivery_date');
            $table->string('delivery_detail');
            $table->enum('status', ['1', '2', '3', '4'])->default('1');
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
        Schema::dropIfExists('orders');
    }
};
