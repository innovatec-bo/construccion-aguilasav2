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
 * Seguimiento (tracking) de movimientos de material: una fila por material en cada documento de entrada o salida de almacen.
 * Mismo formato que MaterialPhysicalInventoryExport. Usa los mismos tipos de movimiento que el calculo de stock.
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

	public function query()
	{
		$query = DB::table('mat_materials_summary as msu')
			->join('mat_projects_materials as prm', function ($join) {
				$join->on('prm.materials_summary_id_prm', '=', 'msu.id_msu')
					->where('prm.deleted_prm', '!=', 1)
					->whereNull('prm.deleted_at');
			})
			->join('mat_materials_summary_types as mqt', 'mqt.id_mqt', '=', 'msu.summary_type_id_msu')
			->leftJoin('mat_materials as mat', 'mat.id_mat', '=', 'prm.material_id_prm')
			->leftJoin('wfl_projects as pro', 'pro.id_pro', '=', 'msu.project_id_msu')
			// estado y tension nulos equivalen a Indefinido (4)
			->leftJoin('mat_material_status as mst', function ($join) {
				$join->whereRaw('mst.id_mst = COALESCE(prm.status_id_prm, 4)');
			})
			->leftJoin('mat_material_tensions as mte', function ($join) {
				$join->whereRaw('mte.id_mte = COALESCE(prm.tension_id_prm, 4)');
			})
			// Serebo no borra en cascada las lineas de un documento borrado: el filtro de msu es imprescindible
			->where('msu.deleted_msu', '!=', 1)
			->whereNull('msu.deleted_at')
			->whereIn('msu.summary_type_id_msu', array_merge(self::IN_TYPES, self::OUT_TYPES));

		if ($this->projectId !== null)
			$query->where('msu.project_id_msu', $this->projectId);
		if ($this->materialId !== null)
			$query->where('prm.material_id_prm', $this->materialId);
		if ($this->dateFrom !== null)
			$query->whereDate('msu.entry_date_msu', '>=', $this->dateFrom);
		if ($this->dateTo !== null)
			$query->whereDate('msu.entry_date_msu', '<=', $this->dateTo);

		return $query
			->select(
				'mat.code_mat',
				'mat.description_mat',
				'mat.unit_of_measurement_mat',
				'msu.entry_date_msu',
				'pro.code_pro',
				'mqt.name_mqt',
				'msu.summary_type_id_msu as type_id',
				'msu.id_msu',
				'prm.quantity_prm',
				'mst.code_mst',
				'mte.code_mte'
			)
			// historial de cada material en orden cronologico (el orden completo es necesario para que la lectura por lotes sea estable)
			->orderBy('mat.description_mat')
			->orderBy('mat.id_mat')
			->orderBy('msu.entry_date_msu')
			->orderBy('msu.id_msu')
			->orderBy('prm.id_prm');
	}

	public function headings(): array
	{
		return [
			'Código',
			'Nombre del Material',
			'U.M.',
			'Fecha',
			'Proyecto',
			'Movimiento',
			'Tipo',
			'ID Mov.',
			'Cantidad',
			'Cantidad (+/-)',
			'Estado',
			'Tensión',
		];
	}

	public function map($row): array
	{
		$isIn = in_array((int)$row->type_id, self::IN_TYPES, true);
		$quantity = (float)$row->quantity_prm;

		return [
			$row->code_mat,
			$row->description_mat,
			$row->unit_of_measurement_mat ?? 'PZA',
			$row->entry_date_msu ? date('d/m/Y', strtotime($row->entry_date_msu)) : '',
			$row->code_pro ?? '',
			$row->name_mqt,
			$isIn ? 'Entrada' : 'Salida',
			$row->id_msu,
			$quantity,
			$isIn ? $quantity : -$quantity,
			$row->code_mst ?? '',
			strtolower((string)$row->code_mte) === 'undefined' ? 'Indefinido' : ($row->code_mte ?? ''),
		];
	}

	public function styles(Worksheet $sheet)
	{
		$lastRow = $sheet->getHighestRow();

		// Estilos para encabezados (igual que MaterialPhysicalInventoryExport)
		$sheet->getStyle('A1:L1')->applyFromArray([
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
		$sheet->getStyle("A1:L{$lastRow}")->applyFromArray([
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

		$sheet->getStyle("I2:J{$lastRow}")->getNumberFormat()->setFormatCode('#,##0.00');
		$sheet->getStyle("D2:D{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

		// Altura de fila cómoda, igual que el inventario fisico
		for ($r = 2; $r <= $lastRow; $r++) {
			$sheet->getRowDimension($r)->setRowHeight(22);
		}

		// Filtros y encabezado fijo para recorrer un historial largo
		$sheet->setAutoFilter("A1:L{$lastRow}");
		$sheet->freezePane('A2');

		return [];
	}
}