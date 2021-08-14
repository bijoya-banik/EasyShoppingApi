<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
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
            $table->integer('userId');
            $table->string('address');
            $table->string('phone');
            $table->double('shippingPrice',10, 2);
            $table->double('subTotal',10, 2);
            $table->double('grandTotal',10, 2);
            $table->string('paymentType');
            $table->string('status');
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
}
