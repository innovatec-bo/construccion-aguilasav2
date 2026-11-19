<?php

namespace App\Warehouse;

use DateTime;

/**
 * Reglas de negocio del formulario de movimientos de almacen. PHP puro (sin Eloquent ni DB): recibe los
 * datos del formulario y una StockSnapshot, y devuelve la lista de errores. La misma validacion corre en
 * el componente Livewire (al guardar) y en la Action de guardado, dentro de la transaccion.
 *
 * Topes por tipo (ver el manual tecnico, "Matriz de reglas"):
 *  - 3  Retiro de CRE            : suma por material <= pendiente en CRE (proyecto + material). Estado y tension libres.
 *  - 4  Entrega al constructor   : por fila exacta (material + tension + estado) <= disponible.
 *  - 17 Entrega en prestamo      : por fila exacta <= disponible.
 *  - 8  Devolucion a CRE         : por fila exacta <= disponible.
 *  - 14 Solicitud de materiales  : por fila exacta <= disponible. (No resta del almacen: es constancia.)
 *  - 15 Solicitud de prestamo    : suma por material <= pendiente en CRE.
 *  - 18 Devolucion del constructor: en estado Nuevo, suma por material <= entregado neto (4 + 17 - devuelto Nuevo);
 *                                   en Viejo / Buen estado / Indefinido no hay tope (material retirado de obra).
 * Si la entrega nace de una solicitud (4 <- 14, 17 <- 15): misma obra, tipo correcto y, para las filas que
 * vienen en la solicitud, cantidad <= lo solicitado. Las filas que no estaban en la solicitud no se topan.
 */
final class MovementValidator
{
	private const VALID_IDS = [1, 2, 3, 4];

	/**
	 * @param array{type_id:int,project_id:int,builder_id?:?int,fiscal_id?:?int,reservation_number?:?string,entry_date?:?string,allow_empty?:bool} $header
	 *        entry_date en formato Y-m-d.
	 * @param array<int,array{material_id:int,tension:int,status:int,quantity:mixed,material_code?:string}> $lines
	 * @param array{id:int,project_id:int,type_id:int,lines:array<int,array{material_id:int,tension:int,status:int,quantity:mixed}>}|null $request
	 *        solicitud que respalda la entrega (parent_summary_id), ya cargada y no eliminada.
	 * @return array<int,array{field:string,message:string,lines:int[]}>
	 */
	public function validate(array $header, array $lines, StockSnapshot $stock, ?array $request = null) : array
	{
		$errors = [];
		$typeId = (int)($header['type_id'] ?? 0);

		if (!MovementType::isEnabled($typeId))
			return [self::error('type_id', 'Tipo de movimiento no habilitado.')];

		// ---------- Cabecera ----------
		if (empty($header['project_id']))
			$errors[] = self::error('project_id', 'Debe especificar un proyecto.');

		if (MovementType::requiresBuilderAndFiscal($typeId))
		{
			if (empty($header['builder_id']))
				$errors[] = self::error('builder_id', 'Debe seleccionar el constructor.');
			if (empty($header['fiscal_id']))
				$errors[] = self::error('fiscal_id', 'Debe seleccionar el fiscal.');
		}

		if (MovementType::requiresReservation($typeId) && trim((string)($header['reservation_number'] ?? '')) === '')
			$errors[] = self::error('reservation_number', 'Seleccione un Nro. de reserva.');

		$date = DateTime::createFromFormat('Y-m-d', (string)($header['entry_date'] ?? ''));
		if (!$date || $date->format('Y-m-d') !== (string)$header['entry_date'])
			$errors[] = self::error('entry_date', 'La fecha no es valida.');

		// ---------- Lineas: normalizar y agrupar ----------
		$perRow = [];      // material|tension|status => ['cents','lines','material']
		$perMaterial = []; // material => ['cents','lines']
		$newPerMaterial = []; // material (solo estado Nuevo) => ['cents','lines']
		foreach ($lines as $index => $line)
		{
			$material = (int)($line['material_id'] ?? 0);
			$tension = (int)($line['tension'] ?? 0);
			$status = (int)($line['status'] ?? 0);
			$label = (string)($line['material_code'] ?? $material);

			if ($material <= 0)
			{
				$errors[] = self::error("lines.$index.material_id", 'Material no valido.', [$index]);
				continue;
			}
			if (!in_array($tension, self::VALID_IDS, true) || !in_array($status, self::VALID_IDS, true))
			{
				$errors[] = self::error("lines.$index.tension", "Material $label: tension o estado no validos.", [$index]);
				continue;
			}
			$cents = Quantity::parse($line['quantity'] ?? 0);
			if ($cents === null)
			{
				$errors[] = self::error("lines.$index.quantity", "Material $label: cantidad no valida (use numeros positivos con hasta 2 decimales).", [$index]);
				continue;
			}
			if ($cents === 0)
				continue; // como Serebo: las lineas en cero no se guardan

			$key = StockSnapshot::key($material, $tension, $status);
			$perRow[$key] = self::add($perRow[$key] ?? null, $cents, $index, $material, $label, $tension, $status);
			$perMaterial[$material] = self::add($perMaterial[$material] ?? null, $cents, $index, $material, $label);
			if ($status === 1)
				$newPerMaterial[$material] = self::add($newPerMaterial[$material] ?? null, $cents, $index, $material, $label);
		}

		if (count($perRow) === 0 && empty($header['allow_empty']))
			$errors[] = self::error('lines', 'Ingrese al menos una linea con cantidad mayor a cero (o registre un movimiento en cero).');

		// ---------- Topes por tipo ----------
		switch ($typeId)
		{
			case MovementType::PICKED_UP_FROM_CRE:
			case MovementType::REQUEST_LOAN:
				foreach ($perMaterial as $material => $group)
				{
					$cap = max(0, $stock->pending($material));
					if ($group['cents'] > $cap)
						$errors[] = self::error('lines', "Material {$group['label']}: " . Quantity::format($group['cents'])
							. " excede el pendiente en CRE (" . Quantity::format($cap) . ").", $group['lines']);
				}
				break;

			case MovementType::DELIVERED_TO_BUILDER:
			case MovementType::DELIVERED_TO_BUILDER_LOAN:
			case MovementType::DELIVERED_TO_CRE:
			case MovementType::REQUEST_MATERIALS:
				foreach ($perRow as $group)
				{
					$cap = max(0, $stock->available($group['material'], $group['tension'], $group['status']));
					if ($group['cents'] > $cap)
						$errors[] = self::error('lines', "Material {$group['label']} (tension {$group['tension']}, estado {$group['status']}): "
							. Quantity::format($group['cents']) . " excede el disponible en almacen (" . Quantity::format($cap) . ").", $group['lines']);
				}
				break;

			case MovementType::BUILDER_RETURNS:
				// Solo lo devuelto como Nuevo se topa: es material no usado que salio del almacen.
				// Lo retirado de obra (Viejo / Buen estado) no paso por el almacen y entra sin tope.
				foreach ($newPerMaterial as $material => $group)
				{
					$cap = max(0, $stock->deliveredNewNet($material));
					if ($group['cents'] > $cap)
						$errors[] = self::error('lines', "Material {$group['label']}: " . Quantity::format($group['cents'])
							. " como Nuevo excede lo entregado al constructor (" . Quantity::format($cap)
							. "). Registre el excedente como material viejo o en buen estado.", $group['lines']);
				}
				break;
		}

		// ---------- Solicitud que respalda la entrega ----------
		$errors = array_merge($errors, $this->validateRequestLink($typeId, $header, $request, $perRow));

		return $errors;
	}

	/**
	 * @param array<string,array> $perRow
	 * @return array<int,array{field:string,message:string,lines:int[]}>
	 */
	private function validateRequestLink(int $typeId, array $header, ?array $request, array $perRow) : array
	{
		if ($request === null)
			return [];

		$expected = MovementType::requestTypeFor($typeId);
		if ($expected === null)
			return [self::error('request_id', 'Este tipo de movimiento no admite una solicitud de origen.')];

		if ((int)$request['type_id'] !== $expected)
			return [self::error('request_id', 'La solicitud no corresponde a este tipo de movimiento.')];

		if ((int)$request['project_id'] !== (int)($header['project_id'] ?? 0))
			return [self::error('request_id', 'La solicitud pertenece a otro proyecto.')];

		// topes por fila exacta, solo para las filas que vienen en la solicitud
		$requested = [];
		foreach ($request['lines'] as $line)
		{
			$key = StockSnapshot::key((int)$line['material_id'], (int)$line['tension'], (int)$line['status']);
			$requested[$key] = ($requested[$key] ?? 0) + (Quantity::parse($line['quantity']) ?? 0);
		}

		$errors = [];
		foreach ($perRow as $key => $group)
		{
			if (isset($requested[$key]) && $group['cents'] > $requested[$key])
				$errors[] = self::error('lines', "Material {$group['label']}: " . Quantity::format($group['cents'])
					. " excede lo solicitado (" . Quantity::format($requested[$key]) . ").", $group['lines']);
		}
		return $errors;
	}

	/**
	 * @param array|null $group
	 * @return array
	 */
	private static function add(?array $group, int $cents, int $index, int $material, string $label, ?int $tension = null, ?int $status = null) : array
	{
		$group = $group ?? ['cents' => 0, 'lines' => [], 'material' => $material, 'label' => $label, 'tension' => $tension, 'status' => $status];
		$group['cents'] += $cents;
		$group['lines'][] = $index;
		return $group;
	}

	/**
	 * @param int[] $lines
	 * @return array{field:string,message:string,lines:int[]}
	 */
	private static function error(string $field, string $message, array $lines = []) : array
	{
		return ['field' => $field, 'message' => $message, 'lines' => $lines];
	}
}