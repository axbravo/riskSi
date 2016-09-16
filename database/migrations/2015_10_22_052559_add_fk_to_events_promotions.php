<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToEventsPromotions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {



        
         Schema::table('promotions', function (Blueprint $table) {
            $table->foreign('event_id')
                  ->references('id')
                  ->on('events')->onDelete('cascade');
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
            $table->dropForeign('promotions_event_id_foreign');
        });
    }
}
