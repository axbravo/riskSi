<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('payment_date')->nullable();
            $table->string('reserve');
            $table->timestamp('refund_date')->nullable();
            $table->boolean('cancelled')->default(false);
            $table->integer('quantity');
            $table->integer('discount')->nullable();
            $table->integer('owner_id')->unsigned()->nullable();
            $table->integer('event_id')->unsigned();
            $table->integer('presentation_id')->unsigned();
            $table->integer('zone_id')->unsigned();
            $table->integer('promo_id')->unsigned()->nullable();
            $table->integer('salesman_id')->nullable()->unsigned();
            $table->integer('designee')->nullable()->unsigned();
            $table->boolean('picked_up');
            $table->float('price');
            $table->float('total_price');
            $table->timestamp('cashCount_register')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tickets');
    }
}
