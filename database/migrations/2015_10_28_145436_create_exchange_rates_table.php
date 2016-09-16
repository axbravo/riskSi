<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExchangeRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
           Schema::create('exchange_rates', function (Blueprint $table) {
            $table->increments('id');
            $table->double('buyingRate');
            $table->double('sellingRate');
            $table->integer('status');
            $table->timestamp('startDate');
            $table->timestamp('finishDate')->nullable();
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
        Schema::drop('exchange_rates');
    }
}
