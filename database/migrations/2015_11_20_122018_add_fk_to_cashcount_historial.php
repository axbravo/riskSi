<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToCashcountHistorial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('cashcount_historials', function (Blueprint $table) {
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
        Schema::table('cashcount_historials', function (Blueprint $table) {
            $table->dropForeign('cashcount_historials_salesman_id_foreign');
            $table->dropForeign('cashcount_historials_module_id_foreign');
        });
    }
}
