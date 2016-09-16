<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToZonePromotion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
             
         Schema::table('promotions', function (Blueprint $table) {
            $table->foreign('zone_id')
                  ->references('id')
                  ->on('zones')->onDelete('cascade');
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
            $table->dropForeign('promotions_zone_id_foreign');
        });
    }
}
