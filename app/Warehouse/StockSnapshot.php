<?php

namespace App\Warehouse;

/**
 * Foto del stock de UN proyecto, construida con las filas de MaterialSummaryPaginationHandler (v5):
 * una fila por material + tension + estado.
 *
 *  - available(): disponible en almacen de la fila exacta (quantity_in_warehouse).
 *  - pending(): pendiente en CRE por proyecto + material (pending_material_in_cre, igual en todas las filas del par).
 *  - deliveredNewNet(): entregado al constructor neto de devoluciones Nuevo, por proyecto + material
 *    (suma de quantity_materials_delivered_to_builder de todas las filas del material).
 */
final class StockSnapshot
{
	/** @var array<string,int> */
	private array $available = [];
	/** @var array<int,int> */
	private array $pending = [];
	/** @var array<int,int> */
	private array $deliveredNet = [];

	public static function key(int $materialId, int $tension, int $status) : string
	{
		return $materialId . '|' . $tension . '|' . $status;
	}

	/**
	 * @param iterable<array|object> $rows filas del handler
	 */
	public static function fromRows(iterable $rows) : self
	{
		$snapshot = new self();
		foreach ($rows as $row)
		{
			$row = (array)$row;
			$material = (int)$row['material_id'];
			$key = self::key($material, (int)$row['tension_id_prm'], (int)$row['status_id_prm']);

			$snapshot->available[$key] = ($snapshot->available[$key] ?? 0) + Quantity::fromDb($row['quantity_in_warehouse']);
			// repetido en cada fila del par: basta con tomarlo una vez
			if (!array_key_exists($material, $snapshot->pending))
				$snapshot->pending[$material] = Quantity::fromDb($row['pending_material_in_cre']);
			$snapshot->deliveredNet[$material] = ($snapshot->deliveredNet[$material] ?? 0)
				+ Quantity::fromDb($row['quantity_materials_delivered_to_builder']);
		}
		return $snapshot;
	}

	public function available(int $materialId, int $tension, int $status) : int
	{
		return $this->available[self::key($materialId, $tension, $status)] ?? 0;
	}

	public function pending(int $materialId) : int
	{
		return $this->pending[$materialId] ?? 0;
	}

	public function deliveredNewNet(int $materialId) : int
	{
		return $this->deliveredNet[$materialId] ?? 0;
	}
}