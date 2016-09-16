<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeatsFunctionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slot_presentation', function (Blueprint $table) {
            $table->integer('slot_id')->unsigned()->index('slot_presentation_slot_id_foreign');
            $table->integer('presentation_id')->unsigned()->index('slot_presentation_presentation_id_foreign');
            $table->integer('sale_id')->unsigned()->nullable();
            $table->integer('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('slot_presentation');
    }
}
