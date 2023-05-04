<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExternalBalanceMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('external_balance_materials', function (Blueprint $table) {
            $table->id();
            $table->string('ElementoPEP');
            $table->string('Proyecto');
            $table->string('Contratista');
            $table->string('Material');
            $table->string('Texto_breve_de_material');
            $table->string('Alm');
            $table->string('Cantidad');
            $table->string('Lote');
            $table->string('CMv');
            $table->string('Docmat');
            $table->string('Reserva');
            $table->string('Textocabdocumento');
            $table->string('Referencia');
            $table->string('Fecontab');
            $table->string('Fechadoc');
            $table->string('Registrado');
            $table->string('EjMat');
            $table->string('Cecoste');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('external_balance_materials');
    }
}
