<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePoliticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //


        Schema::create('politics', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->string('name');
            $table->text('description');
            $table->string('state');
            $table->timestamps();
            $table->softDeletes();
          
        });




    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('politics');
    }
}
