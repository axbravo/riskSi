<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */


    public function up()
    {
        Schema::create('preferences', function (Blueprint $table) {

            

             $table->integer('idUser')->unsigned();

             $table->integer('idCategories')->unsigned();

             $table->foreign('idUser')
                  ->references('id')
                  ->on('users');

             $table->foreign('idCategories')
                  ->references('id')
                  ->on('categories');

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
        Schema::drop('preferences', function (Blueprint $table) {
             //$table->dropForeign('users_idUser_foreign');
             //$table->dropForeign('categories_idCategories_foreign');

        });
    }
}
