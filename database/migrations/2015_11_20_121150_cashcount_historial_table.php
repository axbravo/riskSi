<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CashcountHistorialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::create('cashcount_historials', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('module_id')->unsigned();
            //$table->string('nameModule');
            $table->integer('salesman_id')->unsigned();
            //$table->integer('nameSalesman');
            $table->double('initial_cash');
            $table->double('sales_cash');
            $table->double('devolutions_cash');
            $table->double('total_cash');
            $table->timestamp('dateCashCount');
            $table->softDeletes();
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
         Schema::drop('cashcount_historials');
    }
}
