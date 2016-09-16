<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToCommentEvent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('comment', function (Blueprint $table) {
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
         Schema::table('comment', function (Blueprint $table) {
            $table->dropForeign('comment_event_id_foreign');
        });
    }
}
