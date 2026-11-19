<?php
namespace App\Inventory;

use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * Anula un lote importado: marca sus movimientos como eliminados y recalcula saldos y costos con los movimientos que quedan.
 * Si al quitarlo algun movimiento posterior se queda sin saldo, no se anula nada y se informa cuales.
 */
class VoidImportBatch
{
	/** @return array{ok:bool,errors:array<int,string>} */
	public function execute(string $code, ?int $userId = null, string $reason = ''): array
	{
		DB::beginTransaction();
		try
		{
			$batch = DB::table('inv_import_batches')->where('code', $code)->lockForUpdate()->first();
			if (!$batch)
			{
				DB::rollBack();
				return ['ok' => false, 'errors' => ['No existe el lote ' . $code . '.']];
			}
			if ($batch->status === 'voided')
			{
				DB::rollBack();
				return ['ok' => false, 'errors' => ['El lote ' . $code . ' ya fue anulado el ' . $batch->voided_at . '.']];
			}

			DB::table('inv_stock')->lockForUpdate()->get(['id']);
			DB::table('inv_costs')->lockForUpdate()->get(['id']);

			$now = now();
			DB::table('inv_movement_lines')
				->whereIn('movement_id', fn ($q) => $q->select('id')->from('inv_movements')->where('import_batch', $code))
				->whereNull('deleted_at')->update(['deleted_at' => $now]);
			DB::table('inv_movements')->where('import_batch', $code)->whereNull('deleted_at')
				->update(['deleted_at' => $now, 'updated_by' => $userId]);

			$rebuilder = new InventoryRebuilder();
			$replay = $rebuilder->replay();
			if ($replay['errors'])
			{
				DB::rollBack();
				return ['ok' => false, 'errors' => array_merge(
					['No se puede anular el lote ' . $code . ': otros movimientos dependen de el y se quedarian sin saldo.'],
					array_map(fn ($e) => $e['message'], $replay['errors'])
				)];
			}

			$rebuilder->persist($replay['ledger'], $replay['costUpdates']);
			DB::table('inv_import_batches')->where('code', $code)->update([
				'status' => 'voided', 'voided_at' => $now, 'voided_by' => $userId, 'void_reason' => $reason !== '' ? mb_substr($reason, 0, 255) : null, 'updated_at' => $now,
			]);
			DB::commit();
			return ['ok' => true, 'errors' => []];
		}
		catch (Throwable $e)
		{
			DB::rollBack();
			throw $e;
		}
	}
}
