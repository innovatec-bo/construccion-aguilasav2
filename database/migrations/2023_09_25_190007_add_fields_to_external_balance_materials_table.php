<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToExternalBalanceMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('external_balance_materials', function (Blueprint $table) {
            $table->foreignId('external_balance_id')->references('id')->on('external_balance_materials')->after('id');
            $table->softDeletes();
            $table->blameable();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('external_balance_materials', function (Blueprint $table) {
            $table->dropForeign('external_balance_id');
            $table->dropColumn(['external_balance_id','deleted_at','created_by','updated_by']);
        });
        Schema::enableForeignKeyConstraints();
    }
}
