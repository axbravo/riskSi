<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToDistributionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('distribution', function (Blueprint $table) {
            $table->foreign('local_id')
                  ->references('id')
                  ->on('locals')->onDelete('cascade');
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('distribution', function (Blueprint $table) {
            $table->dropForeign('distribution_local_id_foreign');
            
        });
    }
}
