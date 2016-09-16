<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssistance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       

           Schema::create('attendance', function (Blueprint $table) {
            $table->increments('id');

            $table->timestamp('datetime');
            $table->timestamp('datetimestart');
            $table->timestamp('datetimeend')->nullable();
            $table->integer('salesman_id')->unsigned();
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
              Schema::drop('attendance');
    }
}
