<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendancedetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
   
           Schema::create('attendancedetail', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo');
            $table->timestamp('datetime')->nullable();
            $table->integer('attendance_id')->unsigned();
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
              Schema::drop('attendancedetail');
    }
}
