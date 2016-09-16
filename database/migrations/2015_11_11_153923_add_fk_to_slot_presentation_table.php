<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToSlotPresentationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slot_presentation', function (Blueprint $table) {
            $table->foreign('sale_id')
                ->references('id')
                ->on('tickets');
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
            $table->dropForeign('slot_presentation_sale_id_foreign');
        });
    }
}
