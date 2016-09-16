<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('lastname');
            $table->integer('di_type');
            $table->integer('di');
            $table->string('address');
            $table->string('email')->unique();
            $table->integer('phone');
            $table->string('image'); 
            $table->integer('points')->nullable();
            $table->timestamp('birthday');
            $table->timestamp('iniDate');
            $table->timestamp('endDate');
            $table->integer('role_id')->unsigned();
            $table->integer('module_id')->unsigned()->unique()->nullable();
            $table->string('password', 60);
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
