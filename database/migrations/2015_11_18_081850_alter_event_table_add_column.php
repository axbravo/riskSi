<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterEventTableAddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('distribution_image')->nullable();
            $table->integer('promoter_id')->unsigned();
            $table->integer('percentage_comission')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('distribution_image');
            $table->dropColumn('promoter_id');
            $table->dropColumn('percentage_comission');
        });
    }
}
