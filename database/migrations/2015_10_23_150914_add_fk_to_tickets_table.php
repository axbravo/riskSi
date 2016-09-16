<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->foreign('owner_id')
                ->references('id')
                ->on('users');
            
            $table->foreign('event_id')
                ->references('id')
                ->on('events')
                ->onDelete('cascade');

            $table->foreign('presentation_id')
                ->references('id')
                ->on('presentations')
                ->onDelete('cascade');

            $table->foreign('zone_id')
                ->references('id')
                ->on('zones')
                ->onDelete('cascade');

            $table->foreign('salesman_id')
                ->references('id')
                ->on('users');
            
            $table->foreign('promo_id')
                ->references('id')
                ->on('promotions');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign('tickets_owner_id_foreign');
            $table->dropForeign('tickets_event_id_foreign');
            $table->dropForeign('tickets_presentation_id_foreign');
            //$table->dropForeign('tickets_seat_id_foreign');
            $table->dropForeign('tickets_zone_id_foreign');
            $table->dropForeign('tickets_salesman_id_foreign');
            $table->dropForeign('tickets_promo_id_foreign');
        });
    }
}
