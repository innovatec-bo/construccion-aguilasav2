<?php
namespace App\Inventory;

use App\Warehouse\Quantity;
use Generator;
use Illuminate\Support\Facades\DB;

/**
 * Recalcula saldos (inv_stock) y costos (inv_costs) reproduciendo, en orden de registro (id), todos los
 * movimientos vigentes. Es el mismo orden en que se aplicaron originalmente, por eso el costo promedio coincide.
 */
class InventoryRebuilder
{
	/** @return array{ledger:Ledger,errors:array,costUpdates:array} */
	public function replay(): array
	{
		$ledger = new Ledger();
		$result = Replayer::run($ledger, $this->lines());
		return ['ledger' => $ledger, 'errors' => $result['errors'], 'costUpdates' => $result['costUpdates']];
	}

	private function lines(): Generator
	{
		$query = DB::table('inv_movement_lines as l')
			->join('inv_movements as m', 'm.id', '=', 'l.movement_id')
			->whereNull('m.deleted_at')->whereNull('l.deleted_at')
			->orderBy('m.id')->orderBy('l.id')
			->select('l.id as line_id', 'l.movement_id', 'm.type', 'm.warehouse_id', 'm.to_warehouse_id', 'm.reference', 'm.import_batch',
				'l.material_id', 'l.status_id', 'l.tension_id', 'l.quantity', 'l.unit_cost', 'l.unit_sale_price');

		foreach ($query->cursor() as $r)
		{
			yield [
				'line_id' => $r->line_id, 'movement_id' => $r->movement_id, 'type' => $r->type,
				'warehouse_id' => $r->warehouse_id, 'to_warehouse_id' => $r->to_warehouse_id,
				'material_id' => $r->material_id, 'status_id' => $r->status_id, 'tension_id' => $r->tension_id,
				'qty' => Quantity::parse($r->quantity) ?? 0,
				'unit_cost' => Money::parse($r->unit_cost) ?? 0,
				'sale' => $r->unit_sale_price === null ? null : Money::parse($r->unit_sale_price),
				'reference' => $r->reference, 'batch' => $r->import_batch,
			];
		}
	}

	/** Reemplaza inv_stock e inv_costs por lo recalculado y corrige el costo aplicado en egresos y traslados. */
	public function persist(Ledger $ledger, array $costUpdates): void
	{
		$now = now();
		DB::table('inv_stock')->delete();
		DB::table('inv_costs')->delete();

		$stock = [];
		foreach ($ledger->stock as $warehouseId => $keys)
		{
			foreach ($keys as $key => $qty)
			{
				[$m, $s, $t] = array_map('intval', explode('|', $key));
				$stock[] = ['warehouse_id' => $warehouseId, 'material_id' => $m, 'status_id' => $s, 'tension_id' => $t,
					'quantity' => Quantity::format($qty), 'created_at' => $now, 'updated_at' => $now];
			}
		}
		foreach (array_chunk($stock, 500) as $chunk)
			DB::table('inv_stock')->insert($chunk);

		$costs = [];
		foreach ($ledger->cost as $key => $c)
		{
			[$m, $s, $t] = array_map('intval', explode('|', $key));
			$costs[] = ['material_id' => $m, 'status_id' => $s, 'tension_id' => $t,
				'quantity' => Quantity::format($c['qty']), 'total_value' => Money::formatMicro($c['value']),
				'avg_cost' => Money::format($c['avg']), 'last_sale_price' => $c['sale'] === null ? null : Money::format($c['sale']),
				'created_at' => $now, 'updated_at' => $now];
		}
		foreach (array_chunk($costs, 500) as $chunk)
			DB::table('inv_costs')->insert($chunk);

		foreach ($costUpdates as $lineId => $avg)
			DB::table('inv_movement_lines')->where('id', $lineId)->update(['unit_cost' => Money::format($avg), 'updated_at' => $now]);
	}

	/**
	 * Compara lo guardado con lo recalculado. Devuelve las diferencias (vacio = todo cuadra).
	 * @return array<int,string>
	 */
	public function check(): array
	{
		$replay = $this->replay();
		$diffs = array_map(fn ($e) => $e['message'], $replay['errors']);
		$ledger = $replay['ledger'];

		$stored = [];
		foreach (DB::table('inv_stock')->get() as $r)
			$stored[$r->warehouse_id . '#' . Ledger::key($r->material_id, $r->status_id, $r->tension_id)] = Quantity::parse($r->quantity) ?? 0;
		$expected = [];
		foreach ($ledger->stock as $w => $keys)
			foreach ($keys as $key => $qty)
				$expected[$w . '#' . $key] = $qty;
		foreach (array_unique(array_merge(array_keys($stored), array_keys($expected))) as $k)
		{
			$a = $stored[$k] ?? 0; $b = $expected[$k] ?? 0;
			if ($a !== $b)
				$diffs[] = 'Saldo ' . $k . ': guardado ' . Quantity::format($a) . ', recalculado ' . Quantity::format($b);
		}

		$storedCost = [];
		foreach (DB::table('inv_costs')->get() as $r)
			$storedCost[Ledger::key($r->material_id, $r->status_id, $r->tension_id)] = [Quantity::parse($r->quantity) ?? 0, Money::parse($r->avg_cost) ?? 0];
		foreach ($ledger->cost as $key => $c)
		{
			$s = $storedCost[$key] ?? [0, 0];
			if ($s[0] !== $c['qty'] || ($c['qty'] > 0 && $s[1] !== $c['avg']))
				$diffs[] = 'Costo ' . $key . ': guardado ' . Quantity::format($s[0]) . ' u a ' . Money::format($s[1]) . ', recalculado ' . Quantity::format($c['qty']) . ' u a ' . Money::format($c['avg']);
		}
		foreach (array_diff_key($storedCost, $ledger->cost) as $key => $s)
			$diffs[] = 'Costo ' . $key . ': existe guardado pero no en el recalculo.';
		return $diffs;
	}
}
