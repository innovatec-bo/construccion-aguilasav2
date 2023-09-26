<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeGrafoToExternalBalanceMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('external_balance_materials', function (Blueprint $table) {
            $table->string('ElementoPEP')->nullable()->change();
            $table->string('Proyecto')->nullable()->change();
            $table->string('Contratista')->nullable()->change();
            $table->string('Material')->nullable()->change();
            $table->string('Texto_breve_de_material')->nullable()->change();
            $table->string('Alm')->nullable()->change();
            $table->string('Cantidad')->nullable()->change();
            $table->string('Lote')->nullable()->change();
            $table->string('CMv')->nullable()->change();
            $table->string('Docmat')->nullable()->change();
            $table->string('Reserva')->nullable()->change();
            $table->string('Textocabdocumento')->nullable()->change();
            $table->string('Referencia')->nullable()->change();
            $table->string('EjMat')->nullable()->change();
            $table->string('Cecoste')->nullable()->change();
            $table->string('Grafo')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('external_balance_materials', function (Blueprint $table) {
            $table->string('ElementoPEP')->change();
            $table->string('Proyecto')->change();
            $table->string('Contratista')->change();
            $table->string('Material')->change();
            $table->string('Texto_breve_de_material')->change();
            $table->string('Alm')->change();
            $table->string('Cantidad')->change();
            $table->string('Lote')->change();
            $table->string('CMv')->change();
            $table->string('Docmat')->change();
            $table->string('Reserva')->change();
            $table->string('Textocabdocumento')->change();
            $table->string('Referencia')->change();
            $table->string('EjMat')->change();
            $table->string('Cecoste')->change();
            $table->string('Grafo')->change();
        });
    }
}
