<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inv_warehouses', function (Blueprint $t) {
            $t->id();
            $t->string('code', 20)->unique();
            $t->string('name', 120);
            $t->string('address', 255)->nullable();
            $t->boolean('active')->default(true);
            $t->unsignedBigInteger('created_by')->nullable();
            $t->unsignedBigInteger('updated_by')->nullable();
            $t->timestamps();
            $t->softDeletes();
        });

        // Cabecera: ingreso, egreso o traslado. No pertenece a ningun proyecto (project_id queda para cuando un proyecto consuma de estos almacenes).
        Schema::create('inv_movements', function (Blueprint $t) {
            $t->id();
            $t->enum('type', ['initial', 'entry', 'exit', 'transfer']);
            $t->date('movement_date');
            $t->foreignId('warehouse_id')->constrained('inv_warehouses');          // almacen (origen en traslados)
            $t->foreignId('to_warehouse_id')->nullable()->constrained('inv_warehouses'); // solo traslados
            $t->unsignedBigInteger('project_id')->nullable();                      // reservado, no se usa todavia
            $t->string('reference', 120)->nullable();                              // factura, acta, etc.
            $t->string('notes', 500)->nullable();
            $t->string('source', 20)->default('form');                             // form | excel
            $t->string('import_batch', 40)->nullable();
            $t->unsignedBigInteger('created_by')->nullable();
            $t->unsignedBigInteger('updated_by')->nullable();
            $t->timestamps();
            $t->softDeletes();
            $t->index(['warehouse_id', 'movement_date']);
            $t->index('import_batch');
        });

        Schema::create('inv_movement_lines', function (Blueprint $t) {
            $t->id();
            $t->foreignId('movement_id')->constrained('inv_movements');
            $t->unsignedInteger('material_id');       // mat_materials.id_mat
            $t->unsignedTinyInteger('status_id');     // 1 Nuevo, 2 Viejo, 3 Retirado en buen estado, 4 Indefinido
            $t->unsignedTinyInteger('tension_id');    // 1 Media, 2 Baja, 3 Transformador, 4 Indefinido
            $t->decimal('quantity', 12, 2);
            $t->decimal('unit_cost', 14, 4)->nullable();        // compra (ingresos); en egresos/traslados se guarda el promedio aplicado
            $t->decimal('unit_sale_price', 14, 4)->nullable();  // venta (opcional)
            $t->string('detail', 255)->nullable();
            $t->timestamps();
            $t->softDeletes();
            $t->index(['material_id', 'status_id', 'tension_id']);
        });

        // Saldo por almacen (se actualiza al guardar cada movimiento)
        Schema::create('inv_stock', function (Blueprint $t) {
            $t->id();
            $t->foreignId('warehouse_id')->constrained('inv_warehouses');
            $t->unsignedInteger('material_id');
            $t->unsignedTinyInteger('status_id');
            $t->unsignedTinyInteger('tension_id');
            $t->decimal('quantity', 12, 2)->default(0);
            $t->timestamps();
            $t->unique(['warehouse_id', 'material_id', 'status_id', 'tension_id'], 'inv_stock_unique');
        });

        // Costo promedio ponderado GLOBAL por material + estado + tension
        Schema::create('inv_costs', function (Blueprint $t) {
            $t->id();
            $t->unsignedInteger('material_id');
            $t->unsignedTinyInteger('status_id');
            $t->unsignedTinyInteger('tension_id');
            $t->decimal('quantity', 12, 2)->default(0);         // existencia total entre almacenes
            $t->decimal('total_value', 18, 6)->default(0);      // valor total (Bs)
            $t->decimal('avg_cost', 14, 4)->default(0);         // ultimo promedio (se conserva si la existencia llega a 0)
            $t->decimal('last_sale_price', 14, 4)->nullable();
            $t->timestamps();
            $t->unique(['material_id', 'status_id', 'tension_id'], 'inv_costs_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inv_costs');
        Schema::dropIfExists('inv_stock');
        Schema::dropIfExists('inv_movement_lines');
        Schema::dropIfExists('inv_movements');
        Schema::dropIfExists('inv_warehouses');
    }
};