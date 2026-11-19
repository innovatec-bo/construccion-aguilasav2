<?php
namespace App\Inventory;

use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

/** Lee solo la hoja "Movimientos" (maatwebsite/excel ^3.1). */
class MovementsSheetImport implements WithMultipleSheets
{
	public MovementsSheetRows $sheet;

	public function __construct()
	{
		$this->sheet = new MovementsSheetRows();
	}

	public function sheets(): array
	{
		return ['Movimientos' => $this->sheet];
	}

	/** @return array<int,array> [numeroDeFila => celdas] sin el encabezado */
	public function rows(): array
	{
		$out = [];
		foreach ($this->sheet->rows as $i => $cells)
		{
			if ($i === 0)
				continue; // encabezado (fila 1)
			$out[$i + 1] = array_values($cells);
		}
		return $out;
	}
}

class MovementsSheetRows implements ToArray
{
	public array $rows = [];

	public function array(array $array)
	{
		$this->rows = $array;
	}
}