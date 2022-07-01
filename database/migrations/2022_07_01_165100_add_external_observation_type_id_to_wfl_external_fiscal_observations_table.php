<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExternalObservationTypeIdToWflExternalFiscalObservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wfl_external_fiscal_observations', function (Blueprint $table) {
            $table->unsignedBigInteger('external_observation_type_id')->nullable()->after('fixed_efo');
            $table->foreign('external_observation_type_id','fk_external_observation_type_id')->references('id')->on('external_observation_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wfl_external_fiscal_observations', function (Blueprint $table) {
            $table->dropForeign('fk_external_observation_type_id');
            $table->dropColumn('external_observation_type_id');
        });
    }
}
