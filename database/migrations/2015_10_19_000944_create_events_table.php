<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('category_id')->unsigned();
            $table->integer('local_id')->unsigned();
            $table->integer('organizer_id')->unsigned();
            $table->string('description');
            $table->string('image');
            $table->timestamps();
            $table->softDeletes();
            $table->boolean('cancelled')->default(false);
            $table->string('publication_date');
            $table->string('selling_date');
            $table->string('time_length');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('events');
    }
}
