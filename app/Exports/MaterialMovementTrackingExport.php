<?php
namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Kardex de materiales: cada movimiento de entrada o salida de almacen con el saldo acumulado.
 *
 * - El saldo es el stock del almacen (todos los proyectos juntos) por material y estado; la tension no se toma en cuenta.
 * - Orden: codigo de material (numerico), estado, fecha, entradas antes que salidas el mismo dia, ID del movimiento.
 * - El saldo se calcula sobre TODO el historial; los filtros (proyecto, fechas) solo recortan las filas que se muestran,
 *   asi el saldo de cada fila sigue siendo el real del almacen en ese momento.
 * Mismo formato que MaterialPhysicalInventoryExport.
 */
class MaterialMovementTrackingExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
	/** Tipos que suman al almacen: 3 CRE, 9 conciliacion 221, 18 devolucion del constructor, 19 depuracion pendiente en CRE */
	const IN_TYPES = [3, 9, 18, 19];
	/** Tipos que restan: 4 entrega al constructor, 8 entrega a CRE, 17 entrega al constructor (prestamo) */
	const OUT_TYPES = [4, 8, 17];

	private ?int $projectId;
	private ?int $materialId;
	private ?string $dateFrom;
	private ?string $dateTo;

	// seguimiento de filas para resaltar el inicio de cada grupo material + estado (map() se llama fila por fila, en orden)
	private int $rowNumber = 1; // la fila 1 es el encabezado
	private ?string $previousGroup = null;
	private array $groupStartRows = [];

	/**
	 * Todos los filtros son opcionales. Fechas en Y-m-d. Sin filtros: todos los proyectos y materiales.
	 */
	public function __construct(?int $projectId = null, ?int $materialId = null, ?string $dateFrom = null, ?string $dateTo = null)
	{
		$this->projectId = $projectId;
		$this->materialId = $materialId;
		$this->dateFrom = $dateFrom;
		$this->dateTo = $dateTo;
	}

	/**
	 * SQL completo y sus parametros (se puede ejecutar en phpMyAdmin cambiando los ? por los valores). Requiere MariaDB 10.2+ (funciones de ventana).
	 * @return array{0:string,1:array}
	 */
	public function sql(): array
	{
		$in = implode(',', array_map('intval', self::IN_TYPES));
		$all = implode(',', array_map('intval', array_merge(self::IN_TYPES, self::OUT_TYPES)));

		$innerBindings = [];
		$innerWhere = '';
		if ($this->materialId !== null)
		{
			// el material se puede filtrar adentro: el saldo se calcula por material, no se altera
			$innerWhere = ' AND prm.material_id_prm = ?';
			$innerBindings[] = $this->materialId;
		}

		// Proyecto, tipo, estado y tension salen de subconsultas de una sola fila: si una tabla maestra tuviera ids repetidos
		// no se multiplican las lineas. Estado nulo equivale a Indefinido (4).
		// Serebo no borra en cascada las lineas de un documento borrado: el filtro de msu es imprescindible.
		$inner = "
			SELECT
				mat.code_mat, mat.description_mat, mat.unit_of_measurement_mat,
				(SELECT mst.code_mst FROM mat_material_status mst WHERE mst.id_mst = COALESCE(prm.status_id_prm, 4) LIMIT 1) AS code_mst,
				DATE(msu.entry_date_msu) AS entry_day,
				msu.project_id_msu AS project_id,
				(SELECT pro.code_pro FROM wfl_projects pro WHERE pro.id_pro = msu.project_id_msu LIMIT 1) AS code_pro,
				msu.id_msu, prm.id_prm,
				(SELECT mqt.name_mqt FROM mat_materials_summary_types mqt WHERE mqt.id_mqt = msu.summary_type_id_msu LIMIT 1) AS name_mqt,
				CASE WHEN msu.summary_type_id_msu IN ($in) THEN 1 ELSE 0 END AS is_in,
				CASE WHEN msu.summary_type_id_msu IN ($in) THEN prm.quantity_prm ELSE -prm.quantity_prm END AS signed_qty,
				SUM(CASE WHEN msu.summary_type_id_msu IN ($in) THEN prm.quantity_prm ELSE -prm.quantity_prm END) OVER (
					PARTITION BY prm.material_id_prm, COALESCE(prm.status_id_prm, 4)
					ORDER BY DATE(msu.entry_date_msu), CASE WHEN msu.summary_type_id_msu IN ($in) THEN 0 ELSE 1 END, msu.id_msu, prm.id_prm
					ROWS BETWEEN UNBOUNDED PRECEDING AND CURRENT ROW
				) AS saldo
			FROM mat_materials_summary msu
			JOIN mat_projects_materials prm
				ON prm.materials_summary_id_prm = msu.id_msu
				AND prm.deleted_prm != 1 AND prm.deleted_at IS NULL
			LEFT JOIN mat_materials mat ON mat.id_mat = prm.material_id_prm
			WHERE msu.deleted_msu != 1 AND msu.deleted_at IS NULL
				AND msu.summary_type_id_msu IN ($all)
				$innerWhere";

		// Los filtros de proyecto y fechas van AFUERA del calculo del saldo
		$outerBindings = [];
		$outerWhere = '';
		if ($this->projectId !== null)
		{
			$outerWhere .= ' AND k.project_id = ?';
			$outerBindings[] = $this->projectId;
		}
		if ($this->dateFrom !== null)
		{
			$outerWhere .= ' AND k.entry_day >= ?';
			$outerBindings[] = $this->dateFrom;
		}
		if ($this->dateTo !== null)
		{
			$outerWhere .= ' AND k.entry_day <= ?';
			$outerBindings[] = $this->dateTo;
		}

		$sql = "
			SELECT k.*,
				ROW_NUMBER() OVER (ORDER BY CAST(k.code_mat AS UNSIGNED), k.code_mat, k.code_mst, k.entry_day, k.is_in DESC, k.id_msu, k.id_prm) AS rn
			FROM ($inner) k
			WHERE 1 = 1 $outerWhere";

		return [$sql, array_merge($innerBindings, $outerBindings)];
	}

	public function query()
	{
		[$sql, $bindings] = $this->sql();

		return DB::query()
			->fromRaw("($sql) as t", $bindings)
			->select('t.*')
			->orderBy('t.rn');
	}

	public function headings(): array
	{
		return [
			'Código',
			'Nombre del Material',
			'U.M.',
			'Estado',
			'Fecha',
			'Proyecto',
			'ID Mov.',
			'Movimiento',
			'Tipo',
			'Cantidad',
			'Saldo',
		];
	}

	public function map($row): array
	{
		$this->rowNumber++;
		$group = $row->code_mat . '|' . $row->code_mst;
		if ($group !== $this->previousGroup)
		{
			$this->groupStartRows[] = $this->rowNumber;
			$this->previousGroup = $group;
		}

		return [
			$row->code_mat,
			$row->description_mat,
			$row->unit_of_measurement_mat ?? 'PZA',
			$row->code_mst ?? '',
			$row->entry_day ? date('d/m/Y', strtotime($row->entry_day)) : '',
			$row->code_pro ?? '',
			$row->id_msu,
			$row->name_mqt,
			$row->is_in ? 'Entrada' : 'Salida',
			(float)$row->signed_qty,   // entradas en positivo, salidas en negativo
			(float)$row->saldo,        // se muestra sin signo negativo (ver formato en styles)
		];
	}

	public function styles(Worksheet $sheet)
	{
		$lastRow = $sheet->getHighestRow();

		// Estilos para encabezados (igual que MaterialPhysicalInventoryExport)
		$sheet->getStyle('A1:K1')->applyFromArray([
			'font' => [
				'bold' => true,
				'color' => ['rgb' => 'FFFFFF'],
				'size' => 11,
			],
			'fill' => [
				'fillType' => Fill::FILL_SOLID,
				'startColor' => ['rgb' => '1F4E78'],
			],
			'alignment' => [
				'horizontal' => Alignment::HORIZONTAL_CENTER,
				'vertical' => Alignment::VERTICAL_CENTER,
				'wrapText' => true,
			],
		]);

		$sheet->getRowDimension(1)->setRowHeight(28);

		// Bordes completos para facilitar la lectura
		$sheet->getStyle("A1:K{$lastRow}")->applyFromArray([
			'borders' => [
				'allBorders' => [
					'borderStyle' => Border::BORDER_THIN,
					'color' => ['rgb' => 'B0B0B0'],
				],
			],
			'alignment' => [
				'vertical' => Alignment::VERTICAL_CENTER,
			],
		]);

		// Resalta la primera fila de cada grupo material + estado (donde el saldo vuelve a empezar), como en el modelo
		foreach ($this->groupStartRows as $r) {
			$sheet->getStyle("A{$r}:K{$r}")->applyFromArray([
				'fill' => [
					'fillType' => Fill::FILL_SOLID,
					'startColor' => ['rgb' => 'DCE6F1'],
				],
			]);
		}

		// Columnas centradas como en el modelo: Código, U.M., Estado, Fecha, Proyecto, ID Mov., Tipo
		foreach (['A', 'C', 'D', 'E', 'F', 'G', 'I'] as $col) {
			$sheet->getStyle("{$col}2:{$col}{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		}

		// Cantidad con signo. Saldo sin signo negativo: formato de tres secciones (positivo; negativo sin "-"; cero como 0.00)
		$sheet->getStyle("J2:J{$lastRow}")->getNumberFormat()->setFormatCode('#,##0.00');
		$sheet->getStyle("K2:K{$lastRow}")->getNumberFormat()->setFormatCode('#,##0.00;#,##0.00;0.00');

		// Altura de fila cómoda, igual que el inventario fisico
		for ($r = 2; $r <= $lastRow; $r++) {
			$sheet->getRowDimension($r)->setRowHeight(22);
		}

		// Filtro automático en el encabezado
		$sheet->setAutoFilter("A1:K{$lastRow}");

		return [];
	}
}