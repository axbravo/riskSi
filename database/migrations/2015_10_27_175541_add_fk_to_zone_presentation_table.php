<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToZonePresentationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('zone_presentation', function (Blueprint $table) {
            $table->foreign('zone_id')
                  ->references('id')
                  ->on('zones')->onDelete('cascade');
            $table->foreign('presentation_id')
                  ->references('id')
                  ->on('presentations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('zone_presentation', function (Blueprint $table) {
            $table->dropForeign('zone_presentation_zone_id_foreign');
            $table->dropForeign('zone_presentation_presentation_id_foreign');
        });
    }
}
