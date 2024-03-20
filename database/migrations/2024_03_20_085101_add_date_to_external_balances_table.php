<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDateToExternalBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('external_balances', function (Blueprint $table) {
            $table->date('manual_entry_date')->after('total_TR')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('external_balances', function (Blueprint $table) {
            $table->dropColumn(['manual_entry_date']);
        });
    }
}
