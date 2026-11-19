<?php

namespace App\Warehouse;

/**
 * Cantidades como centesimas enteras: quantity_prm es decimal(10,2) y comparar flotantes
 * (0.1 + 0.2 vs 0.3) produce falsos rechazos.
 */
final class Quantity
{
	/**
	 * Convierte lo que llega del formulario a centesimas. null si no es una cantidad valida
	 * (no numerica, negativa o con mas de 2 decimales). Acepta "1,250.50" como Serebo (quita comas).
	 *
	 * @param mixed $value
	 */
	public static function parse($value): ?int
	{
		if ($value === null || $value === '')
			return 0;
		if (is_int($value))
			return $value >= 0 ? $value * 100 : null;
		if (is_float($value))
			$value = number_format($value, 2, '.', '');

		$value = str_replace(',', '', trim((string)$value));
		if (!preg_match('/^\d+(\.\d{1,2})?$/', $value))
			return null;

		[$int, $dec] = array_pad(explode('.', $value, 2), 2, '0');
		return ((int)$int) * 100 + (int)str_pad($dec, 2, '0');
	}

	/** Valor de la base o del reporte (string "5.00", int, float) a centesimas, sin validar. */
	public static function fromDb($value): int
	{
		return (int)round(((float)$value) * 100);
	}

	public static function format(int $cents): string
	{
		return number_format($cents / 100, 2, '.', '');
	}
}