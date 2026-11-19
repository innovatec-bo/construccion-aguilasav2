<?php
namespace App\Inventory;

use App\Warehouse\Quantity;
use InvalidArgumentException;

/**
 * Reproduce movimientos ya guardados, en orden, sobre un Ledger vacio (logica pura, sin base de datos).
 * Se usa para recalcular saldos y costos despues de anular un lote y para verificar que lo guardado cuadra.
 */
class Replayer
{
	/**
	 * @param iterable $lines filas en el orden en que se aplicaron: movement_id, line_id, type, warehouse_id, to_warehouse_id,
	 *                        material_id, status_id, tension_id, qty (centesimas), unit_cost (diezmilesimas), sale (?int), reference, batch
	 * @return array{errors:array,costUpdates:array<int,int>} costUpdates: line_id => costo promedio recalculado (solo egresos y traslados que cambiaron)
	 */
	public static function run(Ledger $ledger, iterable $lines): array
	{
		$errors = [];
		$costUpdates = [];
		foreach ($lines as $l)
		{
			$key = Ledger::key((int)$l['material_id'], (int)$l['status_id'], (int)$l['tension_id']);
			$qty = (int)$l['qty'];
			try
			{
				switch ($l['type'])
				{
					case 'initial':
					case 'entry':
						$ledger->entry((int)$l['warehouse_id'], $key, $qty, (int)$l['unit_cost'], $l['sale'] === null ? null : (int)$l['sale']);
						break;
					case 'exit':
					case 'transfer':
						$applied = $ledger->avgCost($key);
						if ($l['type'] === 'exit')
							$ledger->exit((int)$l['warehouse_id'], $key, $qty);
						else
							$ledger->transfer((int)$l['warehouse_id'], (int)$l['to_warehouse_id'], $key, $qty);
						if ($applied !== (int)$l['unit_cost'])
							$costUpdates[(int)$l['line_id']] = $applied;
						break;
				}
			}
			catch (InvalidArgumentException $e)
			{
				$errors[] = [
					'movement_id' => (int)$l['movement_id'], 'line_id' => (int)$l['line_id'], 'batch' => $l['batch'] ?? null,
					'message' => 'Movimiento ' . $l['movement_id'] . ' (' . $l['type'] . ', ' . ($l['reference'] ?: 'sin referencia') . '): '
						. $e->getMessage() . ' para material ' . $l['material_id'] . ' / estado ' . $l['status_id'] . ' / tension ' . $l['tension_id']
						. ', cantidad ' . Quantity::format($qty) . '.',
				];
			}
		}
		return ['errors' => $errors, 'costUpdates' => $costUpdates];
	}
}
