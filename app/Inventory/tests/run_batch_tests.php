<?php
require __DIR__ . '/../../Warehouse/Quantity.php';
require __DIR__ . '/../Money.php';
require __DIR__ . '/../Ledger.php';
require __DIR__ . '/../ImportProcessor.php';
require __DIR__ . '/../Replayer.php';
use App\Inventory\{ImportProcessor as P, Ledger, Replayer};

$ok = 0; $bad = 0;
function check($name, $cond) { global $ok, $bad; if ($cond) $ok++; else { $bad++; echo "FALLO: $name\n"; } }
function row($t, $d, $w, $to, $m, $s, $te, $q, $c = '', $sale = '', $ref = '', $obs = '') { return [$t, $d, $w, $to, $m, 'f1', 'f2', 'f3', $s, $te, $q, $c, $sale, $ref, $obs]; }
$M = '195 - POSTE';

// ---------- huella del contenido
$a = [2 => row('Ingreso', '05/11/2026', 'ALMACEN 1', '', $M, 'Nuevo', 'Media', 10, '850', '', 'F-1')];
check('misma huella para el mismo contenido', P::fingerprint($a) === P::fingerprint($a));
$b = $a; $b[2][5] = 'otro'; $b[2][6] = 'otro'; $b[2][7] = 'otro';
check('columnas automaticas no cambian la huella', P::fingerprint($a) === P::fingerprint($b));
$b = $a; $b[2][10] = 11;
check('otra cantidad cambia la huella', P::fingerprint($a) !== P::fingerprint($b));
$b = $a; $b[2][1] = 46331; // serie Excel de 05/11/2026
check('fecha como serie de Excel = fecha en texto', P::parseDate(46331) === '2026-11-05' && P::fingerprint($a) === P::fingerprint($b));
$b = $a; $b[2][2] = '  almacen   1 '; $b[2][11] = '850.0000'; $b[2][4] = '195 - POSTE (nombre editado)';
check('espacios, mayusculas, decimales y nombre no cambian la huella', P::fingerprint($a) === P::fingerprint($b));
$b = $a; $b[2][13] = 'F-2';
check('otro documento cambia la huella', P::fingerprint($a) !== P::fingerprint($b));
$b = $a; $b[3] = ['', '', '', '', '', '', '', '', '', '', '', '', '', '', ''];
check('filas en blanco no cambian la huella', P::fingerprint($a) === P::fingerprint($b));
$b = $a; $b[3] = row('Ingreso', '05/11/2026', 'ALMACEN 1', '', $M, 'Nuevo', 'Media', 10, '850', '', 'F-1');
check('una fila repetida cambia la huella', P::fingerprint($a) !== P::fingerprint($b));

// ---------- reproduccion
$k = fn () => 0;
function L($id, $mov, $type, $wh, $to, $qty, $cost, $ref = 'r', $batch = 'B') {
	return ['line_id' => $id, 'movement_id' => $mov, 'type' => $type, 'warehouse_id' => $wh, 'to_warehouse_id' => $to,
		'material_id' => 74, 'status_id' => 1, 'tension_id' => 1, 'qty' => $qty, 'unit_cost' => $cost, 'sale' => null, 'reference' => $ref, 'batch' => $batch];
}
$key = Ledger::key(74, 1, 1);

// lote1: ingreso 10 a 10 | lote2: ingreso 10 a 20 | lote3: egreso 5 (aplicado 15)
$all = [L(1, 1, 'entry', 1, null, 1000, 100000, 'f1', 'B1'), L(2, 2, 'entry', 1, null, 1000, 200000, 'f2', 'B2'), L(3, 3, 'exit', 1, null, 500, 150000, 'e1', 'B3')];
$ledger = new Ledger(); $r = Replayer::run($ledger, $all);
check('replay completo sin errores ni cambios', $r['errors'] === [] && $r['costUpdates'] === []);
check('replay completo: saldo 15 y promedio 15', $ledger->balance(1, $key) === 1500 && $ledger->avgCost($key) === 150000);

// anular lote2: queda ingreso 10@10 y egreso 5 -> el egreso se revalora a 10
$sin2 = [$all[0], $all[2]];
$ledger = new Ledger(); $r = Replayer::run($ledger, $sin2);
check('anular lote2: sin errores', $r['errors'] === []);
check('anular lote2: el egreso se revalora al nuevo promedio (10)', $r['costUpdates'] === [3 => 100000]);
check('anular lote2: saldo 5, promedio 10', $ledger->balance(1, $key) === 500 && $ledger->avgCost($key) === 100000);

// anular lote1 con lote2 y lote3: queda ingreso 10@20 y egreso 5 -> valida
$sin1 = [$all[1], $all[2]];
$ledger = new Ledger(); $r = Replayer::run($ledger, $sin1);
check('anular lote1: valido, egreso a 20', $r['errors'] === [] && $r['costUpdates'] === [3 => 200000]);

// dependencia: ingreso 10 (lote1), egreso 8 (lote2); anular lote1 -> el egreso se queda sin saldo
$dep = [L(2, 2, 'exit', 1, null, 800, 100000, 'e2', 'B2')];
$ledger = new Ledger(); $r = Replayer::run($ledger, $dep);
check('dependencia: error informado', count($r['errors']) === 1 && $r['errors'][0]['movement_id'] === 2 && $r['errors'][0]['batch'] === 'B2');

// traslado y saldo por almacen
$tr = [L(1, 1, 'entry', 1, null, 1000, 100000), L(2, 2, 'transfer', 1, 2, 400, 100000)];
$ledger = new Ledger(); $r = Replayer::run($ledger, $tr);
check('traslado reproducido', $r['errors'] === [] && $ledger->balance(1, $key) === 600 && $ledger->balance(2, $key) === 400);

// el replay coincide con lo que dejo la importacion
$wh = ['almacen 1' => 1, 'almacen 2' => 2]; $mat = ['195' => 74];
$rows = [
	2 => row('Saldo inicial', '01/11/2026', 'ALMACEN 1', '', $M, 'Nuevo', 'Media', 10, '850'),
	3 => row('Ingreso', '06/11/2026', 'ALMACEN 2', '', $M, 'Nuevo', 'Media', 10, '950'),
	4 => row('Egreso', '08/11/2026', 'ALMACEN 1', '', $M, 'Nuevo', 'Media', 2),
	5 => row('Traslado', '09/11/2026', 'ALMACEN 1', 'ALMACEN 2', $M, 'Nuevo', 'Media', 3),
];
$imported = new Ledger(); $res = P::run($rows, $wh, $mat, $imported);
$lines = []; $id = 0;
foreach ($res['movements'] as $mi => $mv)
	foreach ($mv['lines'] as $ln)
		$lines[] = ['line_id' => ++$id, 'movement_id' => $mi + 1, 'type' => $mv['type'], 'warehouse_id' => $mv['warehouse_id'], 'to_warehouse_id' => $mv['to_warehouse_id'],
			'material_id' => $ln['material_id'], 'status_id' => $ln['status_id'], 'tension_id' => $ln['tension_id'], 'qty' => $ln['qty'],
			'unit_cost' => $ln['unit_cost'], 'sale' => $ln['sale'], 'reference' => $mv['reference'], 'batch' => 'B'];
$replayed = new Ledger(); $r = Replayer::run($replayed, $lines);
check('replay de lo importado: sin errores ni cambios de costo', $r['errors'] === [] && $r['costUpdates'] === []);
check('replay de lo importado: mismos saldos', $replayed->stock === $imported->stock);
check('replay de lo importado: mismos costos', $replayed->cost === $imported->cost);

echo "$ok ok, $bad fallos\n";
exit($bad ? 1 : 0);
