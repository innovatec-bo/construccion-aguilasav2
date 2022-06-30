<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExternalObservationTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('external_observation_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30);
            $table->string('slug', 30);
            $table->timestamps();
            $table->softDeletes();
            $table->blameable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('external_observation_types');
    }
}
