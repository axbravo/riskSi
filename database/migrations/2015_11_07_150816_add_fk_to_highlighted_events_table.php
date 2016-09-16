<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToHighlightedEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('highlightedevents', function (Blueprint $table) {
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
        Schema::table('highlightedevents', function (Blueprint $table) {
            $table->dropForeign('highlightedevents_event_id_foreign');
        });
    }
}
