<?php
namespace App\Inventory;

use InvalidArgumentException;

/**
 * Libro de inventario en memoria: saldos por almacen y costo promedio ponderado GLOBAL por
 * material+estado+tension. Cantidades en centesimas (int), costos en diezmilesimas de Bs (int).
 *
 * - Ingreso: recalcula el costo promedio (valor total / cantidad total entre todos los almacenes).
 * - Egreso: sale al costo promedio vigente; no puede dejar el saldo del almacen en negativo.
 * - Traslado: mueve cantidad entre almacenes; el costo global no cambia.
 * El valor total se guarda exacto (micro-Bs) para que al llegar a cero no queden residuos.
 */
class Ledger
{
	/** @var array<int, array<string,int>> almacen => [clave => cantidad] */
	public array $stock = [];
	/** @var array<string, array{qty:int,value:int,avg:int,sale:?int}> */
	public array $cost = [];

	/**
	 * Carga el estado guardado (para importar sobre saldos existentes).
	 * @param array $stockRows [['warehouse_id','key','qty']]   qty en centesimas
	 * @param array $costRows  [['key','qty','value','avg','sale']] value en micro-Bs, avg en diezmilesimas
	 */
	public function load(array $stockRows, array $costRows): void
	{
		foreach ($stockRows as $r)
			$this->stock[(int)$r['warehouse_id']][$r['key']] = (int)$r['qty'];
		foreach ($costRows as $r)
			$this->cost[$r['key']] = ['qty' => (int)$r['qty'], 'value' => (int)$r['value'], 'avg' => (int)$r['avg'], 'sale' => $r['sale'] === null ? null : (int)$r['sale']];
	}

	public static function key(int $material, int $status, int $tension): string
	{
		return $material . '|' . $status . '|' . $tension;
	}

	public function balance(int $warehouse, string $key): int
	{
		return $this->stock[$warehouse][$key] ?? 0;
	}

	public function totalQty(string $key): int
	{
		return $this->cost[$key]['qty'] ?? 0;
	}

	public function avgCost(string $key): int
	{
		return $this->cost[$key]['avg'] ?? 0;
	}

	public function entry(int $warehouse, string $key, int $qty, int $unitCost, ?int $salePrice = null): void
	{
		$this->assertPositive($qty);
		$c = $this->cost[$key] ?? ['qty' => 0, 'value' => 0, 'avg' => 0, 'sale' => null];
		$c['qty'] += $qty;
		$c['value'] += $qty * $unitCost;
		$c['avg'] = (int)round($c['value'] / $c['qty']);
		if ($salePrice !== null)
			$c['sale'] = $salePrice;
		$this->cost[$key] = $c;
		$this->stock[$warehouse][$key] = $this->balance($warehouse, $key) + $qty;
	}

	/** @return int valor total que sale (micro-Bs) */
	public function exit(int $warehouse, string $key, int $qty): int
	{
		$this->assertPositive($qty);
		if ($this->balance($warehouse, $key) < $qty)
			throw new InvalidArgumentException('saldo insuficiente');
		$c = $this->cost[$key];
		$out = ($qty === $c['qty']) ? $c['value'] : (int)round($c['value'] * $qty / $c['qty']);
		$c['qty'] -= $qty;
		$c['value'] -= $out;
		// con saldo en cero se conserva el ultimo costo promedio
		if ($c['qty'] > 0)
			$c['avg'] = (int)round($c['value'] / $c['qty']);
		$this->cost[$key] = $c;
		$this->stock[$warehouse][$key] = $this->balance($warehouse, $key) - $qty;
		return $out;
	}

	public function transfer(int $from, int $to, string $key, int $qty): void
	{
		$this->assertPositive($qty);
		if ($from === $to)
			throw new InvalidArgumentException('origen y destino iguales');
		if ($this->balance($from, $key) < $qty)
			throw new InvalidArgumentException('saldo insuficiente');
		$this->stock[$from][$key] -= $qty;
		$this->stock[$to][$key] = $this->balance($to, $key) + $qty;
	}

	private function assertPositive(int $qty): void
	{
		if ($qty <= 0)
			throw new InvalidArgumentException('cantidad invalida');
	}
}