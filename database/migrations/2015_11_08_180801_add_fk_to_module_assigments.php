<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToModuleAssigments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('module_assigments', function (Blueprint $table) {
            $table->foreign('salesman_id')->references('id')->on('users');
            $table->foreign('module_id')->references('id')->on('modules');
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
        Schema::table('module_assigments', function (Blueprint $table) {
            $table->dropForeign('module_assigments_salesman_id_foreign');
            $table->dropForeign('module_assigments_module_id_foreign');
        });
    }
}
