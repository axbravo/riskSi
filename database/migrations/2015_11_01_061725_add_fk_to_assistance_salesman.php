<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToAssistanceSalesman extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       
          
       Schema::table('attendance', function (Blueprint $table) {
            $table->foreign('salesman_id')
                  ->references('id')
                  ->on('users')->onDelete('cascade');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
          Schema::table('attendance', function (Blueprint $table) {
            $table->dropForeign('attendance_salesman_id_foreign');
        });



    }
}
