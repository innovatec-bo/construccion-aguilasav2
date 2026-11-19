<?php
/**
 * Pruebas de las reglas de almacen (PHP puro, sin Laravel ni base de datos):
 *   php run_tests.php
 * Las filas de stock replican el escenario de prueba del handler v5 (proyecto 4851).
 */
require __DIR__ . '/../MovementType.php';
require __DIR__ . '/../Quantity.php';
require __DIR__ . '/../StockSnapshot.php';
require __DIR__ . '/../MovementValidator.php';

use App\Warehouse\MovementType;
use App\Warehouse\MovementValidator;
use App\Warehouse\Quantity;
use App\Warehouse\StockSnapshot;

$rows = [
	// material 234 (cod 250): todo entregado, nada disponible ni pendiente
	['material_id' => 234, 'tension_id_prm' => 4, 'status_id_prm' => 1, 'quantity_in_warehouse' => '0.00', 'pending_material_in_cre' => '0.00', 'quantity_materials_delivered_to_builder' => '320.28'],
	// material 74 (cod 195, poste): pendiente 5 (proyecto+material), entregado neto Nuevo 4
	['material_id' => 74, 'tension_id_prm' => 4, 'status_id_prm' => 2, 'quantity_in_warehouse' => '3.00', 'pending_material_in_cre' => '5.00', 'quantity_materials_delivered_to_builder' => '0.00'],
	['material_id' => 74, 'tension_id_prm' => 4, 'status_id_prm' => 1, 'quantity_in_warehouse' => '1.00', 'pending_material_in_cre' => '5.00', 'quantity_materials_delivered_to_builder' => '4.00'],
	// material 53 (cod 4028): pendiente 3, disponible 2 Nuevo y 5 RBE
	['material_id' => 53, 'tension_id_prm' => 4, 'status_id_prm' => 3, 'quantity_in_warehouse' => '5.00', 'pending_material_in_cre' => '3.00', 'quantity_materials_delivered_to_builder' => '0.00'],
	['material_id' => 53, 'tension_id_prm' => 4, 'status_id_prm' => 1, 'quantity_in_warehouse' => '2.00', 'pending_material_in_cre' => '3.00', 'quantity_materials_delivered_to_builder' => '0.00'],
];
$stock = StockSnapshot::fromRows($rows);
$validator = new MovementValidator();

$passed = 0; $failed = 0;
function check(string $name, bool $ok, $detail = null) {
	global $passed, $failed;
	if ($ok) { $passed++; echo "  ok   $name\n"; }
	else { $failed++; echo "  FAIL $name\n"; if ($detail !== null) echo "       " . json_encode($detail, JSON_UNESCAPED_UNICODE) . "\n"; }
}
function header_for(int $type, array $extra = []) : array {
	$h = ['type_id' => $type, 'project_id' => 4851, 'entry_date' => '2026-11-12'];
	if ($type === MovementType::PICKED_UP_FROM_CRE || $type === MovementType::DELIVERED_TO_CRE) $h['reservation_number'] = '721410';
	if (in_array($type, [4, 14, 15, 17, 18], true)) { $h['builder_id'] = 10; $h['fiscal_id'] = 64; }
	return array_merge($h, $extra);
}
function ln(int $material, int $tension, int $status, $qty, string $code = '') : array {
	return ['material_id' => $material, 'tension' => $tension, 'status' => $status, 'quantity' => $qty, 'material_code' => $code ?: (string)$material];
}
function ok(array $errors) : bool { return count($errors) === 0; }

echo "Cantidades\n";
check('parse 1.5', Quantity::parse('1.5') === 150);
check('parse 1,250.50', Quantity::parse('1,250.50') === 125050);
check('parse vacio = 0', Quantity::parse('') === 0);
check('parse negativo invalido', Quantity::parse('-1') === null);
check('parse 3 decimales invalido', Quantity::parse('1.234') === null);
check('parse texto invalido', Quantity::parse('abc') === null);

echo "Retiro de CRE (3): tope = pendiente por proyecto + material\n";
check('pendiente 5 repartido en Nuevo 3 + Viejo 2', ok($validator->validate(header_for(3), [ln(74,4,1,'3'), ln(74,4,2,'2')], $stock)));
check('5.01 excede', !ok($validator->validate(header_for(3), [ln(74,4,1,'3'), ln(74,4,2,'2.01')], $stock)));
check('estado y tension libres: Viejo con tension Media', ok($validator->validate(header_for(3), [ln(74,1,2,'5')], $stock)));
check('sin pendiente (234) no se puede retirar', !ok($validator->validate(header_for(3), [ln(234,4,1,'0.01')], $stock)));
check('0.10 + 0.20 contra pendiente 0.30 (centesimas exactas)', ok($validator->validate(header_for(3), [ln(53,4,1,'0.10'), ln(53,4,3,'0.20')], StockSnapshot::fromRows([['material_id'=>53,'tension_id_prm'=>4,'status_id_prm'=>1,'quantity_in_warehouse'=>0,'pending_material_in_cre'=>'0.30','quantity_materials_delivered_to_builder'=>0]]))));
check('requiere reserva', !ok($validator->validate(['type_id'=>3,'project_id'=>4851,'entry_date'=>'2026-11-12'], [ln(74,4,1,'1')], $stock)));

echo "Entrega al constructor (4): tope = disponible de la fila exacta\n";
check('Nuevo 1 de 1 disponible', ok($validator->validate(header_for(4), [ln(74,4,1,'1')], $stock)));
check('Nuevo 1.01 excede', !ok($validator->validate(header_for(4), [ln(74,4,1,'1.01')], $stock)));
check('Viejo 3 de 3 disponible', ok($validator->validate(header_for(4), [ln(74,4,2,'3')], $stock)));
check('no se puede cubrir Nuevo con stock Viejo', !ok($validator->validate(header_for(4), [ln(74,4,1,'2')], $stock)));
check('dos lineas de la misma fila se suman (0.6 + 0.5 > 1)', !ok($validator->validate(header_for(4), [ln(74,4,1,'0.6'), ln(74,4,1,'0.5')], $stock)));
check('fila sin stock (otra tension)', !ok($validator->validate(header_for(4), [ln(74,1,1,'1')], $stock)));
check('material sin movimientos', !ok($validator->validate(header_for(4), [ln(999,4,1,'1')], $stock)));
check('requiere fiscal y constructor', !ok($validator->validate(['type_id'=>4,'project_id'=>4851,'entry_date'=>'2026-11-12'], [ln(74,4,1,'1')], $stock)));

echo "Prestamo (17), devolucion a CRE (8), solicitud (14): tope = disponible de la fila\n";
check('17 dentro del disponible', ok($validator->validate(header_for(17), [ln(53,4,3,'5')], $stock)));
check('17 excede', !ok($validator->validate(header_for(17), [ln(53,4,3,'5.01')], $stock)));
check('8 dentro del disponible', ok($validator->validate(header_for(8), [ln(53,4,1,'2')], $stock)));
check('8 excede', !ok($validator->validate(header_for(8), [ln(53,4,1,'2.5')], $stock)));
check('14 dentro del disponible', ok($validator->validate(header_for(14), [ln(53,4,1,'2')], $stock)));
check('14 excede', !ok($validator->validate(header_for(14), [ln(53,4,1,'3')], $stock)));

echo "Solicitud de prestamo (15): tope = pendiente en CRE\n";
check('15 dentro del pendiente', ok($validator->validate(header_for(15), [ln(53,4,1,'3')], $stock)));
check('15 excede', !ok($validator->validate(header_for(15), [ln(53,4,1,'3.01')], $stock)));

echo "Devolucion del constructor (18): solo lo Nuevo se topa\n";
check('Nuevo 4 de 4 entregados netos', ok($validator->validate(header_for(18), [ln(74,4,1,'4')], $stock)));
check('Nuevo 4.01 excede', !ok($validator->validate(header_for(18), [ln(74,4,1,'4.01')], $stock)));
check('Viejo (retirado de obra) sin tope', ok($validator->validate(header_for(18), [ln(74,4,2,'1000')], $stock)));
check('Buen estado sin tope', ok($validator->validate(header_for(18), [ln(74,4,3,'50')], $stock)));
check('mixto: Nuevo 4 + poste Viejo 10', ok($validator->validate(header_for(18), [ln(74,4,1,'4'), ln(74,4,2,'10')], $stock)));
check('material que nunca se entrego: Nuevo no, Viejo si', !ok($validator->validate(header_for(18), [ln(999,4,1,'1')], $stock)) && ok($validator->validate(header_for(18), [ln(999,4,2,'1')], $stock)));
check('Nuevo repartido en 2 lineas se suma (2.5 + 2.5 > 4)', !ok($validator->validate(header_for(18), [ln(74,4,1,'2.5'), ln(74,1,1,'2.5')], $stock)));

echo "Entrega a partir de una solicitud\n";
$request14 = ['id' => 700, 'project_id' => 4851, 'type_id' => 14, 'lines' => [['material_id'=>53,'tension'=>4,'status'=>1,'quantity'=>'1']]];
$request15 = ['id' => 701, 'project_id' => 4851, 'type_id' => 15, 'lines' => [['material_id'=>53,'tension'=>4,'status'=>1,'quantity'=>'1']]];
check('4 <- 14: dentro de lo solicitado', ok($validator->validate(header_for(4), [ln(53,4,1,'1')], $stock, $request14)));
check('4 <- 14: excede lo solicitado aunque haya stock', !ok($validator->validate(header_for(4), [ln(53,4,1,'2')], $stock, $request14)));
check('4 <- 14: fila que no estaba en la solicitud no se topa (usa stock)', ok($validator->validate(header_for(4), [ln(53,4,3,'1')], $stock, $request14)));
check('4 <- 15 es incorrecto (corresponde 17)', !ok($validator->validate(header_for(4), [ln(53,4,1,'1')], $stock, $request15)));
check('17 <- 15 correcto', ok($validator->validate(header_for(17), [ln(53,4,1,'1')], $stock, $request15)));
check('solicitud de otro proyecto', !ok($validator->validate(header_for(4), [ln(53,4,1,'1')], $stock, array_merge($request14, ['project_id' => 1]))));
check('retiro de CRE no admite solicitud', !ok($validator->validate(header_for(3), [ln(53,4,1,'1')], $stock, $request14)));

echo "Lineas y cabecera\n";
check('lineas en cero se ignoran', ok($validator->validate(header_for(4), [ln(74,4,1,'1'), ln(74,4,2,'0')], $stock)));
check('todo en cero sin movimiento en cero: error', !ok($validator->validate(header_for(4), [ln(74,4,1,'0')], $stock)));
check('movimiento en cero explicito: ok', ok($validator->validate(header_for(8, ['allow_empty' => true]), [ln(74,4,1,'0')], $stock)));
check('cantidad invalida', !ok($validator->validate(header_for(4), [ln(74,4,1,'abc')], $stock)));
check('cantidad negativa', !ok($validator->validate(header_for(4), [ln(74,4,1,'-1')], $stock)));
check('tension invalida', !ok($validator->validate(header_for(4), [ln(74,9,1,'1')], $stock)));
check('estado invalido', !ok($validator->validate(header_for(4), [ln(74,4,9,'1')], $stock)));
check('fecha invalida', !ok($validator->validate(header_for(4, ['entry_date' => '31-02-2026']), [ln(74,4,1,'1')], $stock)));
check('tipo 13 no habilitado', !ok($validator->validate(['type_id'=>13,'project_id'=>4851,'entry_date'=>'2026-11-12'], [ln(74,4,1,'1')], $stock)));
check('tipo 2 (adicionales) aun no habilitado', !MovementType::isEnabled(2));

$errs = $validator->validate(header_for(4), [ln(74,4,1,'2', '195')], $stock);
check('mensaje util', count($errs) === 1 && strpos($errs[0]['message'], '195') !== false && $errs[0]['lines'] === [0], $errs);

echo "\n$passed ok, $failed fallos\n";
exit($failed > 0 ? 1 : 0);