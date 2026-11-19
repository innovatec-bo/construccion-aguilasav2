<?php
namespace App\Inventory;

/**
 * Bolivianos con hasta 4 decimales, como entero en diezmilesimas (12.5 -> 125000).
 * Acepta 0 (donaciones). Devuelve null si el valor esta vacio, es negativo o no es un numero.
 */
class Money
{
	public static function parse($value): ?int
	{
		if ($value === null || $value === '')
			return null;
		if (is_float($value) || is_int($value))
			$value = number_format((float)$value, 4, '.', '');
		$value = str_replace([',', ' '], '', trim((string)$value));
		if (!preg_match('/^\d+(\.\d{1,4})?$/', $value))
			return null;
		[$int, $dec] = array_pad(explode('.', $value), 2, '');
		return (int)$int * 10000 + (int)str_pad($dec, 4, '0');
	}

	/** micro-Bs (valor total exacto) -> decimal con 6 decimales */
	public static function formatMicro(int $micro): string
	{
		return sprintf('%d.%06d', intdiv($micro, 1000000), $micro % 1000000);
	}

	public static function format(int $units): string
	{
		return number_format($units / 10000, 4, '.', '');
	}
}