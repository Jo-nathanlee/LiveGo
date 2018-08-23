<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckoutOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkout_order', function (Blueprint $table) {
            $table->increments('id');
            $table->string('page_id');
            $table->string('page_name');
            $table->string('order_id');
            $table->string('fb_id');
            $table->string('name');
            $table->string('goods_name');
            $table->string('goods_price');
            $table->string('goods_num');
            $table->string('order_status');
            $table->string('created_time');
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
        Schema::dropIfExists('checkout_order');
    }
}
