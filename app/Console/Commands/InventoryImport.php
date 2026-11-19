<?php
namespace App\Console\Commands;

use App\Inventory\ImportMovements;
use Illuminate\Console\Command;

class InventoryImport extends Command
{
	protected $signature = 'inventory:import {file : Ruta de la planilla .xlsx} {--dry-run : Solo valida, no guarda} {--create-warehouses : Crea los almacenes que no existan} {--force : Importa aunque el mismo contenido ya se haya importado}';
	protected $description = 'Importa la planilla de movimientos de almacen (todo o nada)';

	public function handle(ImportMovements $importer): int
	{
		$path = $this->argument('file');
		if (!is_file($path))
		{
			$this->error('No se encuentra el archivo.');
			return self::FAILURE;
		}

		$result = $importer->execute($path, null, (bool)$this->option('create-warehouses'), (bool)$this->option('dry-run'), (bool)$this->option('force'), basename($path));
		if (!$result['ok'])
		{
			$this->error(isset($result['duplicate']) ? 'Archivo duplicado. No se guardo nada:' : 'El archivo tiene ' . count($result['errors']) . ' error(es). No se guardo nada:');
			foreach ($result['errors'] as $e)
				$this->line(($e['row'] > 0 ? '  Fila ' . $e['row'] . ': ' : '  ') . $e['message']);
			return self::FAILURE;
		}

		$this->info(($this->option('dry-run') ? 'Validacion correcta (no se guardo nada). ' : 'Importado. ')
			. $result['movements'] . ' movimiento(s), ' . $result['lines'] . ' linea(s).' . ($result['batch'] ? ' Lote: ' . $result['batch'] : ''));
		return self::SUCCESS;
	}
}