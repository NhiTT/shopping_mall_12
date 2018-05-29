<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditOrdersDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders_detail', function (Blueprint $table) {
            $table->foreign('product_attributes_id')->references('id')->on('product_attributes')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign('order_id')->references('id')->on('orders')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
