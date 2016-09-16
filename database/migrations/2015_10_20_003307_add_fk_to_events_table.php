<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
                    $table->foreign('category_id')
                  ->references('id')
                  ->on('categories');
            $table->foreign('local_id')
                  ->references('id')
                  ->on('locals');
            $table->foreign('organizer_id')
                  ->references('id')
                  ->on('organizers');
              });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign('events_category_id_foreign');
            $table->dropForeign('events_local_id_foreign');
            $table->dropForeign('events_organizer_id_foreign');
        });
    }
}
