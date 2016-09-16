<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToSeatsFunctionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slot_presentation', function (Blueprint $table) {
            $table->foreign('slot_id')
                  ->references('id')
                  ->on('slots')->onDelete('cascade');
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
        Schema::table('slot_presentation', function (Blueprint $table) {
            $table->dropForeign('slot_presentation_slot_id_foreign');
            $table->dropForeign('slot_presentation_presentation_id_foreign');
        });
    }
}
