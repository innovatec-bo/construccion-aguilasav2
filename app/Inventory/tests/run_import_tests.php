<?php
require __DIR__ . '/../../Warehouse/Quantity.php';
require __DIR__ . '/../Money.php';
require __DIR__ . '/../Ledger.php';
require __DIR__ . '/../ImportProcessor.php';
use App\Inventory\ImportProcessor as P;
use App\Inventory\Ledger;

$ok = 0; $bad = 0;
function check($name, $cond) { global $ok, $bad; if ($cond) $ok++; else { $bad++; echo "FALLO: $name\n"; } }

$wh = ['almacen 1' => 1, 'almacen 2' => 2];
$mat = ['195' => 74, '234' => 5, 'I' => 9];
$M = '195 - POSTE DE CONCRETO  8.50 MTS.';
// 15 columnas de la planilla; 5, 6 y 7 son formulas (codigo, nombre, unidad) y el importador las ignora
function row($t, $d, $w, $to, $m, $s, $te, $q, $c = '', $sale = '', $ref = '', $obs = '') { return [$t, $d, $w, $to, $m, 'ignorado', 'ignorado', 'ignorado', $s, $te, $q, $c, $sale, $ref, $obs]; }
function go($rows, $ledger = null) { global $wh, $mat; return P::run($rows, $wh, $mat, $ledger ?? new Ledger()); }

// --- flujo valido
$r = go([
	2 => row('Saldo inicial', '01/11/2026', 'ALMACEN 1', '', $M, 'Nuevo', 'Media', 10, '850'),
	3 => row('Ingreso', '05/11/2026', 'ALMACEN 2', '', $M, 'Viejo', 'Media', 4, '300', '', 'Factura 1234'),
	4 => row('Egreso', '08/11/2026', 'ALMACEN 1', '', $M, 'Nuevo', 'Media', 2),
	5 => row('Traslado', '09/11/2026', 'ALMACEN 1', 'ALMACEN 2', $M, 'Nuevo', 'Media', 3),
]);
check('flujo valido sin errores', $r['errors'] === []);
check('4 movimientos', count($r['movements']) === 4);
check('egreso valorado al promedio (850)', $r['movements'][2]['lines'][0]['unit_cost'] === 8500000);
check('referencia guardada', $r['movements'][1]['reference'] === 'Factura 1234');
check('tocados: stock', count($r['touchedStock']) === 3); // a1 nuevo, a2 viejo, a2 nuevo
check('tocados: costos', count($r['touchedCost']) === 2);

// --- orden por fecha: egreso escrito antes del ingreso pero con fecha posterior
$r = go([
	2 => row('Egreso', '10/11/2026', 'ALMACEN 1', '', $M, 'Nuevo', 'Media', 5),
	3 => row('Ingreso', '01/11/2026', 'ALMACEN 1', '', $M, 'Nuevo', 'Media', 5, '10'),
]);
check('procesa por fecha, no por orden de fila', $r['errors'] === []);

// --- saldo insuficiente
$r = go([
	2 => row('Ingreso', '01/11/2026', 'ALMACEN 1', '', $M, 'Nuevo', 'Media', 5, '10'),
	3 => row('Egreso', '02/11/2026', 'ALMACEN 1', '', $M, 'Nuevo', 'Media', 6),
]);
check('saldo insuficiente: error en fila 3', count($r['errors']) === 1 && $r['errors'][0]['row'] === 3);
check('con error no hay movimientos', $r['movements'] === []);

// --- estado distinto no sirve para el egreso
$r = go([
	2 => row('Ingreso', '01/11/2026', 'ALMACEN 1', '', $M, 'Viejo', 'Media', 5, '10'),
	3 => row('Egreso', '02/11/2026', 'ALMACEN 1', '', $M, 'Nuevo', 'Media', 1),
]);
check('egreso de otro estado rechazado', count($r['errors']) === 1);

// --- validaciones de fila
check('tipo invalido', count(go([2 => row('Compra', '01/11/2026', 'ALMACEN 1', '', $M, 'Nuevo', 'Media', 1, '1')])['errors']) === 1);
check('fecha inexistente 31/02', count(go([2 => row('Ingreso', '31/02/2026', 'ALMACEN 1', '', $M, 'Nuevo', 'Media', 1, '1')])['errors']) === 1);
check('almacen inexistente', count(go([2 => row('Ingreso', '01/11/2026', 'ALMACEN 9', '', $M, 'Nuevo', 'Media', 1, '1')])['errors']) === 1);
check('material inexistente', count(go([2 => row('Ingreso', '01/11/2026', 'ALMACEN 1', '', '999 - X', 'Nuevo', 'Media', 1, '1')])['errors']) === 1);
check('estado invalido', count(go([2 => row('Ingreso', '01/11/2026', 'ALMACEN 1', '', $M, 'Usado', 'Media', 1, '1')])['errors']) === 1);
check('cantidad cero', count(go([2 => row('Ingreso', '01/11/2026', 'ALMACEN 1', '', $M, 'Nuevo', 'Media', 0, '1')])['errors']) === 1);
check('cantidad con 3 decimales', count(go([2 => row('Ingreso', '01/11/2026', 'ALMACEN 1', '', $M, 'Nuevo', 'Media', '1.234', '1')])['errors']) === 1);
check('ingreso sin costo', count(go([2 => row('Ingreso', '01/11/2026', 'ALMACEN 1', '', $M, 'Nuevo', 'Media', 1, '')])['errors']) === 1);
check('costo negativo', count(go([2 => row('Ingreso', '01/11/2026', 'ALMACEN 1', '', $M, 'Nuevo', 'Media', 1, '-5')])['errors']) === 1);
check('costo 0 (donacion) valido', go([2 => row('Ingreso', '01/11/2026', 'ALMACEN 1', '', $M, 'Nuevo', 'Media', 1, '0')])['errors'] === []);
check('precio venta negativo', count(go([2 => row('Ingreso', '01/11/2026', 'ALMACEN 1', '', $M, 'Nuevo', 'Media', 1, '1', '-2')])['errors']) === 1);
check('traslado sin destino', count(go([2 => row('Traslado', '01/11/2026', 'ALMACEN 1', '', $M, 'Nuevo', 'Media', 1)])['errors']) === 1);
check('traslado a si mismo', count(go([2 => row('Traslado', '01/11/2026', 'ALMACEN 1', 'ALMACEN 1', $M, 'Nuevo', 'Media', 1)])['errors']) === 1);
check('destino en ingreso rechazado', count(go([2 => row('Ingreso', '01/11/2026', 'ALMACEN 1', 'ALMACEN 2', $M, 'Nuevo', 'Media', 1, '1')])['errors']) === 1);
check('tension vacia = indefinido', go([2 => row('Ingreso', '01/11/2026', 'ALMACEN 1', '', $M, 'Nuevo', '', 1, '1')])['movements'][0]['lines'][0]['tension_id'] === 4);
check('codigo no numerico (I)', go([2 => row('Ingreso', '01/11/2026', 'ALMACEN 1', '', 'I - VE1-BT', 'Nuevo', 'Media', 1, '1')])['errors'] === []);
check('codigo escrito como numero', go([2 => row('Ingreso', '01/11/2026', 'ALMACEN 1', '', 195, 'Nuevo', 'Media', 1, '1')])['errors'] === []);
check('todos los errores a la vez', count(go([
	2 => row('Compra', '01/11/2026', 'ALMACEN 1', '', $M, 'Nuevo', 'Media', 1, '1'),
	3 => row('Ingreso', 'x', 'ALMACEN 1', '', $M, 'Nuevo', 'Media', 1, '1'),
])['errors']) === 2);
check('filas vacias se ignoran', go([2 => row('', '', '', '', '', '', '', ''), 3 => row('Ingreso', '01/11/2026', 'ALMACEN 1', '', $M, 'Nuevo', 'Media', 1, '1')])['errors'] === []);
check('archivo vacio', count(go([2 => row('', '', '', '', '', '', '', '')])['errors']) === 1);

// --- fechas
check('fecha serie Excel 46327 = 2026-11-01', P::parseDate(46327) === '2026-11-01');
check('fecha Y-m-d', P::parseDate('2026-11-01') === '2026-11-01');
check('fecha d/m/Y sin ceros', P::parseDate('1/9/2026') === '2026-09-01');
check('fecha d-m-Y', P::parseDate('15-11-2026') === '2026-11-15');
check('fecha basura', P::parseDate('mañana') === null);
check('fecha DateTime', P::parseDate(new DateTime('2026-11-02')) === '2026-11-02');

// --- sobre saldos existentes
$L = new Ledger();
$L->load([['warehouse_id' => 1, 'key' => Ledger::key(74, 1, 1), 'qty' => 500]], [['key' => Ledger::key(74, 1, 1), 'qty' => 500, 'value' => 500 * 100000, 'avg' => 100000, 'sale' => null]]);
$r = go([2 => row('Egreso', '01/11/2026', 'ALMACEN 1', '', $M, 'Nuevo', 'Media', 5)], $L);
check('egreso contra saldo cargado', $r['errors'] === [] && $r['movements'][0]['lines'][0]['unit_cost'] === 100000);

echo "$ok ok, $bad fallos\n";
exit($bad ? 1 : 0);