<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToPromotionAccesspromotion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


       Schema::table('promotions', function (Blueprint $table) {
            $table->foreign('access_id')
                  ->references('id')
                  ->on('accessPromotion')->onDelete('cascade');
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
            $table->dropForeign('promotions_access_id_foreign');
        });
    }
}
