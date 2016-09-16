<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('address');
            $table->string('district');
            $table->string('province');
            $table->string('state');
            $table->string('phone');
            $table->string('email');
            $table->double('initial_cash');
            $table->double('actual_cash');
            $table->boolean('openModule');
            $table->timestamp('starTime');
            $table->timestamp('endTime');
            //$table->integer('salesman_id')->unsigned()->unique()->nullable();
            $table->string('image');
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
        Schema::drop('modules');
    }
}
