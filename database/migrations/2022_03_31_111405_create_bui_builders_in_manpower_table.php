<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuiBuildersInManpowerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bui_builders_in_manpower', function (Blueprint $table) {
            $table->bigInteger('id_bim')->primary();
            $table->bigInteger('labor_cost_log_id_bim')->nullable();
            $table->bigInteger('user_id_bim')->nullable();
            $table->smallInteger('deleted_bim')->default(0);
            $table->dateTime('createdon_bim')->nullable();
            $table->bigInteger('createdby_bim')->nullable();
            $table->dateTime('editedon_bim')->nullable();
            $table->bigInteger('editedby_bim')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bui_builders_in_manpower');
    }
}
