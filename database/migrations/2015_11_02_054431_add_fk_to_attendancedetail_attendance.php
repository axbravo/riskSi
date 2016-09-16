<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToAttendancedetailAttendance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
           Schema::table('attendancedetail', function (Blueprint $table) {
            $table->foreign('attendance_id')
                  ->references('id')
                  ->on('attendance')->onDelete('cascade');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attendancedetail', function (Blueprint $table) {
            $table->dropForeign('attendancedetail_attendance_id_foreign');
        });
    }
}
