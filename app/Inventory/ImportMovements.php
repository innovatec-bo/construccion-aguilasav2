<?php
namespace App\Inventory;

use App\Warehouse\Quantity;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Importa la planilla de movimientos. Todo o nada: valida y simula con Ledger y solo entonces escribe,
 * dentro de una transaccion. Los saldos y costos ya guardados se cargan antes de simular.
 */
class ImportMovements
{
	/**
	 * @param bool $force importa aunque el mismo contenido ya se haya importado (lote activo)
	 * @return array{ok:bool,errors:array,movements:int,lines:int,batch:?string}
	 */
	public function execute(string $path, ?int $userId = null, bool $createWarehouses = false, bool $dryRun = false, bool $force = false, ?string $fileName = null): array
	{
		$import = new MovementsSheetImport();
		Excel::import($import, $path);
		$rows = $import->rows();

		$fingerprint = ImportProcessor::fingerprint($rows);
		if (!$force && ($previous = $this->activeBatchWith($fingerprint)))
		{
			return ['ok' => false, 'movements' => 0, 'lines' => 0, 'batch' => null, 'duplicate' => $previous->code, 'errors' => [[
				'row' => 0,
				'message' => 'Este contenido ya se importo el ' . $previous->created_at . ' (lote ' . $previous->code . ', archivo "' . $previous->file_name . '"). '
					. 'No se importo de nuevo. Si fue un error, anule ese lote; si es intencional, use --force.',
			]]];
		}

		return DB::transaction(function () use ($rows, $userId, $createWarehouses, $dryRun, $fingerprint, $fileName) {
			// bloquea saldos y costos mientras se importa
			$ledger = $this->loadLedger();
			$warehouses = $this->warehouseMap();
			if ($createWarehouses && !$dryRun)
				$warehouses = $this->createMissingWarehouses($rows, $warehouses, $userId);

			$materials = DB::table('mat_materials')->where('deleted_mat', '!=', 1)->pluck('id_mat', 'code_mat')->all();
			$result = ImportProcessor::run($rows, $warehouses, $materials, $ledger);

			$lineCount = array_sum(array_map(fn ($m) => count($m['lines']), $result['movements']));
			if ($result['errors'])
				return ['ok' => false, 'errors' => $result['errors'], 'movements' => 0, 'lines' => 0, 'batch' => null];
			if ($dryRun)
				return ['ok' => true, 'errors' => [], 'movements' => count($result['movements']), 'lines' => $lineCount, 'batch' => null];

			$batch = Str::upper(Str::random(10));
			$now = now();
			DB::table('inv_import_batches')->insert([
				'code' => $batch, 'fingerprint' => $fingerprint, 'file_name' => $fileName,
				'movements_count' => count($result['movements']), 'lines_count' => $lineCount,
				'status' => 'active', 'imported_by' => $userId, 'created_at' => $now, 'updated_at' => $now,
			]);
			foreach ($result['movements'] as $movement)
			{
				$id = DB::table('inv_movements')->insertGetId([
					'type' => $movement['type'], 'movement_date' => $movement['date'],
					'warehouse_id' => $movement['warehouse_id'], 'to_warehouse_id' => $movement['to_warehouse_id'],
					'reference' => $movement['reference'] ?: null, 'notes' => $movement['notes'] ?: null,
					'source' => 'excel', 'import_batch' => $batch, 'created_by' => $userId, 'updated_by' => $userId,
					'created_at' => $now, 'updated_at' => $now,
				]);
				$lines = [];
				foreach ($movement['lines'] as $line)
				{
					$lines[] = [
						'movement_id' => $id, 'material_id' => $line['material_id'], 'status_id' => $line['status_id'], 'tension_id' => $line['tension_id'],
						'quantity' => Quantity::format($line['qty']), 'unit_cost' => Money::format($line['unit_cost']),
						'unit_sale_price' => $line['sale'] === null ? null : Money::format($line['sale']),
						'detail' => $line['detail'], 'created_at' => $now, 'updated_at' => $now,
					];
				}
				DB::table('inv_movement_lines')->insert($lines);
			}
			$this->saveLedger($ledger, $result['touchedStock'], $result['touchedCost'], $now);

			return ['ok' => true, 'errors' => [], 'movements' => count($result['movements']), 'lines' => $lineCount, 'batch' => $batch];
		});
	}

	private function activeBatchWith(string $fingerprint)
	{
		return DB::table('inv_import_batches')->where('fingerprint', $fingerprint)->where('status', 'active')->orderByDesc('id')->first();
	}

	private function loadLedger(): Ledger
	{
		$stock = [];
		foreach (DB::table('inv_stock')->lockForUpdate()->get() as $r)
			$stock[] = ['warehouse_id' => $r->warehouse_id, 'key' => Ledger::key($r->material_id, $r->status_id, $r->tension_id), 'qty' => Quantity::parse($r->quantity) ?? 0];

		$costs = [];
		foreach (DB::table('inv_costs')->lockForUpdate()->get() as $r)
			$costs[] = [
				'key' => Ledger::key($r->material_id, $r->status_id, $r->tension_id),
				'qty' => Quantity::parse($r->quantity) ?? 0,
				'value' => (int)str_replace('.', '', (string)$r->total_value),
				'avg' => Money::parse($r->avg_cost) ?? 0,
				'sale' => $r->last_sale_price === null ? null : Money::parse($r->last_sale_price),
			];

		$ledger = new Ledger();
		$ledger->load($stock, $costs);
		return $ledger;
	}

	private function saveLedger(Ledger $ledger, array $touchedStock, array $touchedCost, $now): void
	{
		$stockRows = [];
		foreach ($touchedStock as [$warehouseId, $key])
		{
			[$m, $s, $t] = array_map('intval', explode('|', $key));
			$stockRows[] = ['warehouse_id' => $warehouseId, 'material_id' => $m, 'status_id' => $s, 'tension_id' => $t,
				'quantity' => Quantity::format($ledger->balance($warehouseId, $key)), 'created_at' => $now, 'updated_at' => $now];
		}
		foreach (array_chunk($stockRows, 500) as $chunk)
			DB::table('inv_stock')->upsert($chunk, ['warehouse_id', 'material_id', 'status_id', 'tension_id'], ['quantity', 'updated_at']);

		$costRows = [];
		foreach ($touchedCost as $key)
		{
			[$m, $s, $t] = array_map('intval', explode('|', $key));
			$c = $ledger->cost[$key];
			$costRows[] = ['material_id' => $m, 'status_id' => $s, 'tension_id' => $t,
				'quantity' => Quantity::format($c['qty']), 'total_value' => Money::formatMicro($c['value']),
				'avg_cost' => Money::format($c['avg']), 'last_sale_price' => $c['sale'] === null ? null : Money::format($c['sale']),
				'created_at' => $now, 'updated_at' => $now];
		}
		foreach (array_chunk($costRows, 500) as $chunk)
			DB::table('inv_costs')->upsert($chunk, ['material_id', 'status_id', 'tension_id'], ['quantity', 'total_value', 'avg_cost', 'last_sale_price', 'updated_at']);
	}

	/** @return array<string,int> nombre normalizado => id */
	private function warehouseMap(): array
	{
		$map = [];
		foreach (DB::table('inv_warehouses')->whereNull('deleted_at')->get(['id', 'name']) as $w)
			$map[ImportProcessor::norm($w->name)] = (int)$w->id;
		return $map;
	}

	private function createMissingWarehouses(array $rows, array $map, ?int $userId): array
	{
		foreach ($rows as $cells)
		{
			foreach ([2, 3] as $col)
			{
				$name = trim((string)($cells[$col] ?? ''));
				if ($name === '' || isset($map[ImportProcessor::norm($name)]))
					continue;
				$id = DB::table('inv_warehouses')->insertGetId([
					'code' => 'ALM-' . str_pad((string)(DB::table('inv_warehouses')->count() + 1), 3, '0', STR_PAD_LEFT),
					'name' => $name, 'active' => true, 'created_by' => $userId, 'updated_by' => $userId,
					'created_at' => now(), 'updated_at' => now(),
				]);
				$map[ImportProcessor::norm($name)] = (int)$id;
			}
		}
		return $map;
	}
}