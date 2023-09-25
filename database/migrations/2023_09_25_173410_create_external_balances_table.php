<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExternalBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('external_balances', function (Blueprint $table) {
            $table->id();
            $table->integer('total_records')->default(0);
            $table->integer('total_records_221')->default(0);
            $table->integer('total_records_222')->default(0);
            $table->integer('total_projects')->default(0);
            $table->integer('total_material_types')->default(0);
            $table->integer('total_BT')->default(0);
            $table->integer('total_MT')->default(0);
            $table->integer('total_TR')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->blameable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('external_balances');
    }
}
