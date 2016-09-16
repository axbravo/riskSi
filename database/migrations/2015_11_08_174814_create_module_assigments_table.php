<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModuleAssigmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('module_assigments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('module_id')->unsigned();
            //$table->string('nameModule');
            $table->integer('salesman_id')->unsigned();
            //$table->integer('nameSalesman');
            $table->integer('status');
            $table->timestamp('dateAssigments');
            $table->timestamp('dateMoveAssigments')->nullable();
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
        //
        Schema::drop('module_assigments');
    }
}
