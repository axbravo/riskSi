<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //


           Schema::create('promotions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');

            $table->timestamp('startday');
            $table->timestamp('endday');
            $table->text('description');
            
            $table->timestamps();
            $table->softDeletes();
            $table->integer('event_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->integer('typePromotion')->unsigned();//Indicara si la promocion es del tipo descuento u oferta
        //Promocion descuento
            $table->float('desc')->nullable();
            $table->integer('access_id')->unsigned()->nullable();
        //Promocion oferta
            $table->integer('zone_id')->unsigned()->nullable();

            $table->integer('carry')->nullable();
            $table->integer('pay')->nullable();


        });




    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::drop('promotions');
    }
}
