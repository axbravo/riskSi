<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToUserPromotion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {



        
         Schema::table('promotions', function (Blueprint $table) {
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
          Schema::table('promotions', function (Blueprint $table) {
            $table->dropForeign('promotions_user_id_foreign');
        });
    }
}
