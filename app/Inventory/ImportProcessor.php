<?php
namespace App\Inventory;

use App\Warehouse\Quantity;
use DateTime;
use InvalidArgumentException;

/**
 * Valida y simula una planilla de movimientos sin tocar la base de datos.
 * Entrada: filas de la hoja "Movimientos" (la fila 1 es el encabezado; aqui se reciben ya sin el, con su numero de fila).
 * Columnas de la planilla (A..O): tipo, fecha, almacen, almacen destino, material (codigo - descripcion),
 * codigo / nombre / unidad (formulas, se ignoran), estado, tension, cantidad, costo, precio venta, documento, observacion.
 * Si hay un solo error en cualquier fila, no se devuelve ningun movimiento.
 */
class ImportProcessor
{
	const COL_TYPE = 0, COL_DATE = 1, COL_WAREHOUSE = 2, COL_TO_WAREHOUSE = 3, COL_MATERIAL = 4,
		COL_STATUS = 8, COL_TENSION = 9, COL_QTY = 10, COL_COST = 11, COL_SALE = 12, COL_REFERENCE = 13, COL_NOTES = 14;

	const TYPES = ['saldo inicial' => 'initial', 'ingreso' => 'entry', 'egreso' => 'exit', 'traslado' => 'transfer'];
	const STATUSES = ['nuevo' => 1, 'viejo' => 2, 'retirado en buen estado' => 3, 'indefinido' => 4];
	const TENSIONS = ['media' => 1, 'baja' => 2, 'transformador' => 3, 'indefinido' => 4];

	/**
	 * @param array<int,array> $rows       [numeroDeFila => celdas[0..11]]
	 * @param array<string,int> $warehouses nombre normalizado (ver norm()) => id
	 * @param array<string,int> $materials  codigo => id
	 * @return array{movements:array,errors:array,touchedStock:array,touchedCost:array}
	 */
	public static function run(array $rows, array $warehouses, array $materials, Ledger $ledger): array
	{
		$errors = [];
		$lines = [];
		foreach ($rows as $rowNumber => $cells)
		{
			if (self::isBlank($cells))
				continue;
			$line = self::parseRow((int)$rowNumber, $cells, $warehouses, $materials, $errors);
			if ($line !== null)
				$lines[] = $line;
		}
		if ($errors)
			return ['movements' => [], 'errors' => $errors, 'touchedStock' => [], 'touchedCost' => []];
		if (!$lines)
			return ['movements' => [], 'errors' => [['row' => 0, 'message' => 'El archivo no tiene filas con datos.']], 'touchedStock' => [], 'touchedCost' => []];

		// fecha y, dentro de la misma fecha, orden de fila
		usort($lines, fn ($a, $b) => [$a['date'], $a['row']] <=> [$b['date'], $b['row']]);

		$touchedStock = [];
		$touchedCost = [];
		$movements = [];
		foreach ($lines as $line)
		{
			$key = Ledger::key($line['material_id'], $line['status_id'], $line['tension_id']);
			try
			{
				switch ($line['type'])
				{
					case 'initial':
					case 'entry':
						$ledger->entry($line['warehouse_id'], $key, $line['qty'], $line['cost'], $line['sale']);
						$line['applied_cost'] = $line['cost'];
						break;
					case 'exit':
						$line['applied_cost'] = $ledger->avgCost($key);
						$ledger->exit($line['warehouse_id'], $key, $line['qty']);
						break;
					case 'transfer':
						$line['applied_cost'] = $ledger->avgCost($key);
						$ledger->transfer($line['warehouse_id'], $line['to_warehouse_id'], $key, $line['qty']);
						$touchedStock[$line['to_warehouse_id'] . '|' . $key] = [$line['to_warehouse_id'], $key];
						break;
				}
			}
			catch (InvalidArgumentException $e)
			{
				$have = Quantity::format($ledger->balance($line['warehouse_id'], $key));
				$errors[] = ['row' => $line['row'], 'message' => 'Saldo insuficiente en "' . $line['warehouse_name'] . '" para ' . $line['material_label']
					. ' (' . $line['status_name'] . ', ' . $line['tension_name'] . '): disponible ' . $have . ', se pide ' . Quantity::format($line['qty']) . '.'];
				continue;
			}
			$touchedStock[$line['warehouse_id'] . '|' . $key] = [$line['warehouse_id'], $key];
			$touchedCost[$key] = true;

			$groupKey = implode('|', [$line['type'], $line['date'], $line['warehouse_id'], $line['to_warehouse_id'] ?? '', $line['reference']]);
			if (!isset($movements[$groupKey]))
			{
				$movements[$groupKey] = ['type' => $line['type'], 'date' => $line['date'], 'warehouse_id' => $line['warehouse_id'],
					'to_warehouse_id' => $line['to_warehouse_id'] ?? null, 'reference' => $line['reference'], 'notes' => $line['notes'], 'lines' => []];
			}
			$movements[$groupKey]['lines'][] = [
				'row' => $line['row'], 'material_id' => $line['material_id'], 'status_id' => $line['status_id'], 'tension_id' => $line['tension_id'],
				'qty' => $line['qty'], 'unit_cost' => $line['applied_cost'], 'sale' => $line['sale'], 'detail' => $line['detail'],
			];
		}

		if ($errors)
		{
			usort($errors, fn ($a, $b) => $a['row'] <=> $b['row']);
			return ['movements' => [], 'errors' => $errors, 'touchedStock' => [], 'touchedCost' => []];
		}
		return ['movements' => array_values($movements), 'errors' => [], 'touchedStock' => array_values($touchedStock), 'touchedCost' => array_keys($touchedCost)];
	}

	/**
	 * Huella del CONTENIDO de la planilla: no cambia si el archivo se vuelve a guardar o se renombra,
	 * ni por las columnas automaticas (codigo, nombre, unidad). Cambia si cambia cualquier dato manual.
	 * Dos planillas con las mismas filas, en el mismo orden, tienen la misma huella.
	 */
	public static function fingerprint(array $rows): string
	{
		$lines = [];
		foreach ($rows as $cells)
		{
			if (self::isBlank($cells))
				continue;
			$cell = fn ($i) => $cells[$i] ?? null;
			$tension = self::norm($cell(self::COL_TENSION));
			$lines[] = [
				self::norm($cell(self::COL_TYPE)),
				self::parseDate($cell(self::COL_DATE)) ?? self::norm($cell(self::COL_DATE)),
				self::norm($cell(self::COL_WAREHOUSE)),
				self::norm($cell(self::COL_TO_WAREHOUSE)),
				trim(explode(' - ', trim((string)$cell(self::COL_MATERIAL)), 2)[0]),
				self::norm($cell(self::COL_STATUS)),
				$tension === '' ? 'indefinido' : $tension,
				(string)(Quantity::parse($cell(self::COL_QTY)) ?? self::norm($cell(self::COL_QTY))),
				(string)(Money::parse($cell(self::COL_COST)) ?? self::norm($cell(self::COL_COST))),
				(string)(Money::parse($cell(self::COL_SALE)) ?? self::norm($cell(self::COL_SALE))),
				trim((string)$cell(self::COL_REFERENCE)),
				trim((string)$cell(self::COL_NOTES)),
			];
		}
		return hash('sha256', json_encode($lines, JSON_UNESCAPED_UNICODE));
	}

	public static function norm($text): string
	{
		return mb_strtolower(trim(preg_replace('/\s+/', ' ', (string)$text)));
	}

	/** Una fila esta en blanco si lo estan las columnas manuales (codigo, nombre y unidad son formulas y se ignoran). */
	private static function isBlank(array $cells): bool
	{
		foreach ($cells as $i => $c)
		{
			if ($i >= self::COL_MATERIAL + 1 && $i < self::COL_STATUS)
				continue;
			if ($c !== null && trim((string)$c) !== '')
				return false;
		}
		return true;
	}

	private static function parseRow(int $row, array $c, array $warehouses, array $materials, array &$errors): ?array
	{
		$cell = fn ($i) => $c[$i] ?? null;
		$bad = function (string $msg) use ($row, &$errors) { $errors[] = ['row' => $row, 'message' => $msg]; };
		$before = count($errors);

		$type = self::TYPES[self::norm($cell(self::COL_TYPE))] ?? null;
		if ($type === null)
			$bad('Tipo no valido (use Saldo inicial, Ingreso, Egreso o Traslado).');

		$date = self::parseDate($cell(self::COL_DATE));
		if ($date === null)
			$bad('Fecha no valida (dd/mm/aaaa).');

		$warehouseId = $warehouses[self::norm($cell(self::COL_WAREHOUSE))] ?? null;
		if ($warehouseId === null)
			$bad('Almacen "' . trim((string)$cell(self::COL_WAREHOUSE)) . '" no existe.');

		$toId = null;
		if ($type === 'transfer')
		{
			$toId = $warehouses[self::norm($cell(self::COL_TO_WAREHOUSE))] ?? null;
			if ($toId === null)
				$bad('Almacen destino "' . trim((string)$cell(self::COL_TO_WAREHOUSE)) . '" no existe.');
			elseif ($toId === $warehouseId)
				$bad('El almacen destino debe ser distinto del origen.');
		}
		elseif (trim((string)$cell(self::COL_TO_WAREHOUSE)) !== '')
			$bad('Almacen destino solo se usa en traslados.');

		$materialLabel = trim((string)$cell(self::COL_MATERIAL));
		$code = trim(explode(' - ', $materialLabel, 2)[0]);
		$materialId = $materials[$code] ?? null;
		if ($materialId === null)
			$bad('Material "' . $materialLabel . '" no existe en el catalogo.');

		$statusId = self::STATUSES[self::norm($cell(self::COL_STATUS))] ?? null;
		if ($statusId === null)
			$bad('Estado no valido.');

		$tensionRaw = self::norm($cell(self::COL_TENSION));
		$tensionId = $tensionRaw === '' ? 4 : (self::TENSIONS[$tensionRaw] ?? null);
		if ($tensionId === null)
			$bad('Tension no valida.');

		$qty = Quantity::parse($cell(self::COL_QTY));
		if ($qty === null || $qty <= 0)
			$bad('Cantidad no valida (mayor que 0, maximo 2 decimales).');

		$cost = null;
		if (in_array($type, ['initial', 'entry'], true))
		{
			$cost = Money::parse($cell(self::COL_COST));
			if ($cost === null)
				$bad('Costo unitario obligatorio y no negativo (puede ser 0 en donaciones).');
		}

		$sale = null;
		if (trim((string)$cell(self::COL_SALE)) !== '')
		{
			$sale = Money::parse($cell(self::COL_SALE));
			if ($sale === null)
				$bad('Precio de venta no valido (no negativo).');
		}

		if (count($errors) > $before)
			return null;

		return [
			'row' => $row, 'type' => $type, 'date' => $date, 'warehouse_id' => $warehouseId, 'to_warehouse_id' => $toId,
			'material_id' => $materialId, 'status_id' => $statusId, 'tension_id' => $tensionId, 'qty' => $qty,
			'cost' => $cost, 'sale' => $sale,
			'reference' => trim((string)$cell(self::COL_REFERENCE)), 'notes' => trim((string)$cell(self::COL_NOTES)), 'detail' => null,
			'warehouse_name' => trim((string)$cell(self::COL_WAREHOUSE)), 'material_label' => $code,
			'status_name' => trim((string)$cell(self::COL_STATUS)), 'tension_name' => $tensionRaw === '' ? 'Indefinido' : trim((string)$cell(self::COL_TENSION)),
		];
	}

	/** Acepta DateTime, numero de serie de Excel, dd/mm/aaaa, dd-mm-aaaa o aaaa-mm-dd. Devuelve Y-m-d o null. */
	public static function parseDate($value): ?string
	{
		if ($value instanceof \DateTimeInterface)
			return $value->format('Y-m-d');
		if ($value === null || trim((string)$value) === '')
			return null;
		if (is_numeric($value))
		{
			$serial = (float)$value;
			if ($serial < 36526 || $serial > 73050) // 2000..2099
				return null;
			return (new DateTime('1899-12-30'))->modify('+' . (int)floor($serial) . ' days')->format('Y-m-d');
		}
		$text = trim((string)$value);
		// fecha con hora (2026-11-01 00:00:00 o con T): se toma solo la fecha
		if (preg_match('/^(\d{4}-\d{2}-\d{2})[T ]\d{2}:\d{2}(:\d{2})?/', $text, $mt))
			$text = $mt[1];
		foreach (['j/n/Y' => '/^\d{1,2}\/\d{1,2}\/\d{4}$/', 'j-n-Y' => '/^\d{1,2}-\d{1,2}-\d{4}$/', 'Y-m-d' => '/^\d{4}-\d{2}-\d{2}$/'] as $format => $regex)
		{
			if (preg_match($regex, $text))
				return self::strictDate($text, $format);
		}
		return null;
	}

	private static function strictDate(string $text, string $format): ?string
	{
		$d = DateTime::createFromFormat('!' . $format, $text);
		$errors = DateTime::getLastErrors();
		if (!$d || ($errors && ($errors['warning_count'] || $errors['error_count'])))
			return null;
		return $d->format('Y-m-d');
	}
}