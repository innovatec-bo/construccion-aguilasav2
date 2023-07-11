<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUmboToWflContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wfl_contracts', function (Blueprint $table) {
            $table->decimal('umbo')->after('expiration_date_con');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wfl_contracts', function (Blueprint $table) {
            $table->dropColumn('umbo');
        });
    }
}
