<?php
namespace App\Console\Commands;

use App\Inventory\InventoryRebuilder;
use App\Inventory\VoidImportBatch;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InventoryBatches extends Command
{
	protected $signature = 'inventory:batches {--void= : Codigo del lote a anular} {--reason= : Motivo de la anulacion} {--yes : No pedir confirmacion} {--check : Verifica que saldos y costos guardados coincidan con los movimientos}';
	protected $description = 'Lista lotes importados, anula un lote o verifica la consistencia del inventario interno';

	public function handle(): int
	{
		if ($this->option('check'))
		{
			$diffs = (new InventoryRebuilder())->check();
			if (!$diffs)
			{
				$this->info('Todo cuadra: saldos y costos coinciden con los movimientos.');
				return self::SUCCESS;
			}
			$this->error(count($diffs) . ' diferencia(s):');
			foreach (array_slice($diffs, 0, 50) as $d)
				$this->line('  ' . $d);
			return self::FAILURE;
		}

		if ($code = $this->option('void'))
		{
			if (!$this->option('yes') && !$this->confirm('Anular el lote ' . $code . ' y recalcular saldos y costos?'))
				return self::FAILURE;
			$result = (new VoidImportBatch())->execute($code, null, (string)$this->option('reason'));
			if (!$result['ok'])
			{
				foreach ($result['errors'] as $e)
					$this->error($e);
				return self::FAILURE;
			}
			$this->info('Lote ' . $code . ' anulado. Saldos y costos recalculados.');
			return self::SUCCESS;
		}

		$rows = DB::table('inv_import_batches')->orderByDesc('id')->get()->map(fn ($b) => [
			$b->code, $b->status, $b->created_at, $b->file_name, $b->movements_count, $b->lines_count, substr($b->fingerprint, 0, 8),
		])->all();
		$this->table(['Lote', 'Estado', 'Fecha', 'Archivo', 'Mov.', 'Lineas', 'Huella'], $rows);
		return self::SUCCESS;
	}
}
