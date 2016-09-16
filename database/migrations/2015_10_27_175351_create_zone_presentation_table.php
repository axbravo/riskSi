<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateZonePresentationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zone_presentation', function (Blueprint $table) {
            $table->integer('zone_id')->unsigned()->index('zone_presentation_zone_id_foreign');
            $table->integer('presentation_id')->unsigned()->index('zone_presentation_presentation_id_foreign');
            $table->integer('slots_availables');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('zone_presentation');
    }
}
