<?php
require __DIR__ . '/../Money.php';
require __DIR__ . '/../Ledger.php';
use App\Inventory\Ledger;
use App\Inventory\Money;

$ok = 0; $bad = 0;
function check($name, $cond) { global $ok, $bad; if ($cond) $ok++; else { $bad++; echo "FALLO: $name\n"; } }
function throws(callable $f) { try { $f(); } catch (InvalidArgumentException $e) { return true; } return false; }

// dinero
check('money 12.5', Money::parse('12.5') === 125000);
check('money 0 (donacion)', Money::parse('0') === 0);
check('money coma de miles', Money::parse('1,250.75') === 12507500);
check('money negativo', Money::parse('-1') === null);
check('money texto', Money::parse('abc') === null);
check('money 5 decimales', Money::parse('1.23456') === null);
check('money vacio', Money::parse('') === null);
check('money float', Money::parse(3.1) === 31000);

$k = Ledger::key(10, 1, 1); // material 10, Nuevo, Media
$L = new Ledger();
$L->entry(1, $k, 1000, Money::parse('10'));          // 10 u a 10 Bs en almacen 1
check('avg inicial', $L->avgCost($k) === 100000);
$L->entry(2, $k, 3000, Money::parse('20'));          // 30 u a 20 Bs en almacen 2 -> global
check('avg ponderado global (10*10+30*20)/40=17.5', $L->avgCost($k) === 175000);
check('total global', $L->totalQty($k) === 4000);
check('saldo almacen 1', $L->balance(1, $k) === 1000);
check('saldo almacen 2', $L->balance(2, $k) === 3000);

$out = $L->exit(2, $k, 1000);                        // sale 10 u al promedio
check('valor de salida 10*17.5=175 Bs', $out === 175 * 1000000);
check('avg no cambia con egreso', $L->avgCost($k) === 175000);
check('egreso no puede dejar negativo', throws(fn() => $L->exit(1, $k, 1001)));
check('egreso sin saldo en ese almacen aunque haya global', throws(fn() => $L->exit(1, $k, 1500)));

$L->transfer(2, 1, $k, 500);
check('traslado: almacen origen', $L->balance(2, $k) === 1500);
check('traslado: almacen destino', $L->balance(1, $k) === 1500);
check('traslado no cambia avg', $L->avgCost($k) === 175000);
check('traslado no cambia total', $L->totalQty($k) === 3000);
check('traslado sin saldo', throws(fn() => $L->transfer(2, 1, $k, 1501)));
check('traslado mismo almacen', throws(fn() => $L->transfer(1, 1, $k, 100)));

// donacion baja el promedio
$k2 = Ledger::key(11, 1, 4);
$L->entry(1, $k2, 1000, Money::parse('10'));
$L->entry(1, $k2, 1000, Money::parse('0'));
check('donacion baja promedio a 5', $L->avgCost($k2) === 50000);

// vaciar y volver a ingresar: sin residuos, se conserva el ultimo costo mientras esta en cero
$k3 = Ledger::key(12, 2, 2);
$L->entry(1, $k3, 333, Money::parse('7.1234'));
$L->exit(1, $k3, 100); $L->exit(1, $k3, 233);
check('en cero, qty 0', $L->totalQty($k3) === 0);
check('en cero, valor 0 exacto', $L->cost[$k3]['value'] === 0);
check('en cero, conserva ultimo avg', $L->avgCost($k3) === 71234);
$L->entry(1, $k3, 100, Money::parse('5'));
check('tras reingreso, avg = nuevo costo', $L->avgCost($k3) === 50000);

// estados distintos no se mezclan
$kNew = Ledger::key(20, 1, 4); $kOld = Ledger::key(20, 2, 4);
$L->entry(1, $kNew, 100, Money::parse('100')); $L->entry(1, $kOld, 100, Money::parse('30'));
check('nuevo y viejo con costos separados', $L->avgCost($kNew) === 1000000 && $L->avgCost($kOld) === 300000);

check('cantidad cero', throws(fn() => $L->entry(1, $k, 0, 100)));
echo "$ok ok, $bad fallos\n";
exit($bad ? 1 : 0);