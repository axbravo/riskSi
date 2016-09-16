<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('organizers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('organizerName');
            $table->string('organizerLastName');
            $table->string('businessName');
            $table->string('ruc');
            $table->integer('events');
            $table->integer('countNumber');
            $table->integer('telephone');
            $table->string('dni');
            $table->string('email');
            $table->string('address');
            $table->string('image');
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
            
         Schema::drop('organizers');

    }
}
