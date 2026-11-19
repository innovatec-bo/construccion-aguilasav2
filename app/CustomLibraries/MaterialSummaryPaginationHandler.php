<?php
namespace App\CustomLibraries;

use Illuminate\Support\Facades\DB;

/**
 * Resumen de materiales y almacen.
 *
 * Grano de cada fila: proyecto + material + tension (tension_id_prm) + estado (status_id_prm).
 * NULL se trata como 4 (= "Indefinido" en ambos catalogos): las listas (tipos 1 y 2) no traen
 * tension y el resto de movimientos si, y sin esa normalizacion quedarian en filas distintas.
 *
 * Las cantidades son por fila (estado y tension), con UNA excepcion:
 *  - pending_material_in_cre se calcula por proyecto + material (todos los estados y tensiones) y se
 *    repite en cada fila del par: lo retirado de CRE puede llevar un estado o tension distinto al de
 *    la lista inicial, asi que el pendiente no se puede validar por fila.
 *
 * Reglas de negocio:
 *  - Entra al almacen: retirado de CRE (3), depuracion de pendientes (19), ingreso por conciliacion 221 (9)
 *    y devoluciones del constructor (18, en el estado en que se registren).
 *  - Sale del almacen: entregado al constructor (4), prestamo (17) y devuelto a CRE (8).
 *  - "Entregado al constructor" resta solo las devoluciones en estado Nuevo (material no usado);
 *    lo retirado de obra (Viejo / Buen estado) solo entra al almacen.
 *  - Los tipos 14, 15 y 16 (solicitudes) son constancia/referencia: NO afectan el almacen. Lo que resta
 *    es la lista de entrega (4 / 17) que se crea a partir de la solicitud.
 *  - El tipo 13 (egreso por conciliacion 222) tampoco afecta el almacen por ahora.
 *
 * Una sola pasada sobre mat_projects_materials (agregacion condicional por tipo
 * de movimiento) en lugar de ~26 LEFT JOIN.
 *
 * Parametros adicionales soportados (setAdditionalParameters):
 *  - project-id                   : filtra por proyecto (vacio = todos)
 *  - reservation-number           : filtra tipos 1,2,3,8 por numero de reservacion
 *  - material-ids                 : ids de material (array, o texto separado por espacio, coma o salto de linea)
 *  - material-codes               : codigos de material (igual que material-ids)
 *  - project-status-id            : ids de estado del proyecto (array o texto separado por coma/espacio)
 *  - show-material-pending-in-cre : 1 = solo filas con pendiente en CRE
 *  - fiscal-responsible-id        : id del fiscal responsable
 * Cualquier otro parametro (p. ej. el antiguo 'grouping-criteria') se ignora: el grano es siempre
 * proyecto + material + tension + estado.
 */
class MaterialSummaryPaginationHandler extends BasePaginationHandler
{
	const TABLE_NAME = "mat_materials";
	const TABLE_ID = "project_material";
	const ATTRIB_SUFIX = "_mat";

	// mat_materials_summary_types.id_mqt
	const TYPE_INITIAL_LIST = 1;
	const TYPE_ADDITIONAL_LIST = 2;
	const TYPE_PICKED_UP_FROM_CRE = 3;
	const TYPE_DELIVERED_TO_BUILDER = 4;
	// 5, 6, 7, 10, 11 y 12 estan eliminados (deleted_mqt = 1) y no tienen documentos: ya no se usan.
	const TYPE_DELIVERED_TO_CRE = 8;
	const TYPE_ENTRY_CONCILIATION_221 = 9;
	// 13 (egreso por conciliacion 222): hoy NO afecta el almacen.
	// 14, 15 y 16 (solicitudes): constancia/referencia, NO afectan el almacen.
	const TYPE_DELIVERED_TO_BUILDER_LOAN = 17;
	const TYPE_RETURNS_GENERIC = 18;
	const TYPE_DEBUG_PENDING_CRE = 19;

	// Estado "Nuevo" (mat_material_status.id_mst = 1)
	const STATUS_NEW = 1;

	// Valor "Indefinido" tanto en el catalogo de estados como en el de tensiones (NULL se trata igual)
	const UNDEFINED_ID = 4;

	// Etiquetas solo para mostrar en el Select2.
	// Catalogos: mat_material_status (id_mst, detail_mst) y mat_material_tensions (id_mte, detail_mte).
	const STATUS_LABELS = array(1 => 'Nuevo', 2 => 'Viejo', 3 => 'Retirado en buen estado', 4 => 'Indefinido');
	const TENSION_LABELS = array(1 => 'Media', 2 => 'Baja', 3 => 'Transformador', 4 => 'Indefinido');

	/**
	 * Master detail table.
	 * @return string
	 */
	protected function _coreQuery() : string
	{
		// ---------- Filtros ----------
		// Material: se aplica dentro de la agregacion (reduce el escaneo)
		$movFilter = "";
		$materialIds = $this->_materialIds();
		if (count($materialIds) > 0)
			$movFilter .= " AND prm.material_id_prm IN (" . implode(',', $materialIds) . ") ";

		// Proyecto: el grano ya incluye el proyecto, asi que el filtro va dentro de la agregacion
		$projectId = $this->_param('project-id');
		if (is_numeric($projectId))
			$movFilter .= " AND msu.project_id_msu = " . (int)$projectId . " ";

		// Reservacion:
		//  1) solo se muestran los pares proyecto+material que tengan alguna linea con esa reservacion
		//  2) y solo los tipos 1,2,3,8 se suman filtrados por esa reservacion
		$reservation = trim((string)$this->_param('reservation-number'));
		$reservationSql = $reservation !== "" ? $this->_quote($reservation) : "";
		$reservationCond = $reservationSql !== "" ? " AND msu.reservation_number_msu = {$reservationSql} " : "";
		if ($reservationSql !== "")
		{
			$movFilter .= "
				  AND (msu.project_id_msu, prm.material_id_prm) IN (
						SELECT msu2.project_id_msu, prm2.material_id_prm
						FROM mat_projects_materials prm2
						JOIN mat_materials_summary msu2 ON msu2.id_msu = prm2.materials_summary_id_prm
						WHERE prm2.deleted_prm != 1
						  AND msu2.deleted_msu != 1
						  AND msu2.reservation_number_msu = {$reservationSql}
				  ) ";
		}

		// ---------- Agregacion condicional por tipo ----------
		$reservationTypes = $reservationCond;
		$sums = array(
			$this->_sum(array(self::TYPE_INITIAL_LIST, self::TYPE_ADDITIONAL_LIST), 'q_assigned', $reservationTypes),
			$this->_sum(array(self::TYPE_ADDITIONAL_LIST), 'q_additional', $reservationTypes),
			$this->_sum(array(self::TYPE_PICKED_UP_FROM_CRE), 'q_picked_up_cre', $reservationTypes),
			$this->_sum(array(self::TYPE_DELIVERED_TO_BUILDER), 'q_delivered_builder'),
			$this->_sum(array(self::TYPE_DELIVERED_TO_CRE), 'q_delivered_cre', $reservationTypes),
			$this->_sum(array(self::TYPE_ENTRY_CONCILIATION_221), 'q_conciliation_221'),
			$this->_sum(array(self::TYPE_DELIVERED_TO_BUILDER_LOAN), 'q_delivered_builder_loan'),
			$this->_sum(array(self::TYPE_RETURNS_GENERIC), 'q_ret_generic'),
			// devoluciones en estado Nuevo (material no usado): son las unicas que restan de "entregado"
			$this->_sum(array(self::TYPE_RETURNS_GENERIC), 'q_ret_new', " AND IFNULL(prm.status_id_prm, " . self::UNDEFINED_ID . ") = " . self::STATUS_NEW . " "),
			$this->_sum(array(self::TYPE_DEBUG_PENDING_CRE), 'q_debug_pending_cre')
		);
		$sumsSql = implode(",\n\t\t\t\t", $sums);

		$undef = self::UNDEFINED_ID;
		$mov = "
				SELECT
					msu.project_id_msu AS project_id,
					prm.material_id_prm AS material_id,
					IFNULL(prm.tension_id_prm, {$undef}) AS tension_id_prm,
					IFNULL(prm.status_id_prm, {$undef}) AS status_id_prm,
					{$sumsSql}
				FROM mat_projects_materials prm
				JOIN mat_materials_summary msu ON msu.id_msu = prm.materials_summary_id_prm
				WHERE prm.deleted_prm != 1
				  AND msu.deleted_msu != 1
				  {$movFilter}
				GROUP BY msu.project_id_msu, prm.material_id_prm,
						 IFNULL(prm.tension_id_prm, {$undef}), IFNULL(prm.status_id_prm, {$undef})
		";

		// ---------- Fiscales (rol 8) del ultimo log con estado 21, sin duplicados ----------
		$fiscal = "
				SELECT
					ll.project_id_psl AS project_id,
					GROUP_CONCAT(DISTINCT u.id_usr ORDER BY u.id_usr) AS fiscal_responsible_id,
					GROUP_CONCAT(DISTINCT CONCAT(u.firstname_usr, ' ', u.lastname_usr) SEPARATOR ', ') AS fiscal_responsible
				FROM (
					SELECT x.id_psl, x.project_id_psl
					FROM (
						SELECT
							psl.id_psl,
							psl.project_id_psl,
							ROW_NUMBER() OVER (PARTITION BY psl.project_id_psl
											   ORDER BY psl.manual_entry_date_psl DESC, psl.id_psl DESC) AS rn
						FROM wfl_project_status_log psl
						JOIN wfl_projects pr ON pr.id_pro = psl.project_id_psl AND pr.deleted_pro != 1
						WHERE psl.status_id_psl = 21
						  AND psl.deleted_psl != 1
					) x
					WHERE x.rn = 1
				) ll
				JOIN wfl_status_log_responsibles slr ON slr.status_log_id_slr = ll.id_psl AND slr.deleted_slr != 1
				JOIN wfl_status_responsibles sre ON sre.id_sre = slr.responsible_id_slr
				JOIN sec_users u ON u.id_usr = sre.user_id_sre
				JOIN sec_userroles ur ON ur.userid_uro = u.id_usr AND ur.roleid_uro = 8 AND ur.deleted_uro != 1
				GROUP BY ll.project_id_psl
		";

		// ---------- Consulta final ----------
		return "
		(
				SELECT
					CONCAT(IFNULL(m.project_id,0),'-',mat.code_mat,'-',
						IF(m.tension_id_prm = {$undef},'indefinido',m.tension_id_prm),'-',
						IF(m.status_id_prm = {$undef},'indefinido',m.status_id_prm)) AS project_material,
					m.project_id,
					pro.code_pro AS project_code,
					ps.id_pst AS project_status_id,
					ps.status_name_pst AS project_status_name,
					m.material_id,
					mat.code_mat AS material_code,
					mat.description_mat AS material_description,
					m.tension_id_prm,
					m.status_id_prm,

					m.q_assigned AS quantity_assigned_materials,
					m.q_additional AS quantity_additional_materials,
					m.q_picked_up_cre AS quantity_picked_up_from_cre,
					m.q_debug_pending_cre AS quantity_debug_pending_in_cre,
					-- pendiente por proyecto + material (suma de todos los estados y tensiones)
					SUM(m.q_assigned - m.q_picked_up_cre - m.q_debug_pending_cre)
						OVER (PARTITION BY m.project_id, m.material_id) AS pending_material_in_cre,
					-- entregado al constructor, neto solo de lo devuelto como Nuevo (tipo 18, estado 1)
					(m.q_delivered_builder + m.q_delivered_builder_loan) - m.q_ret_new AS quantity_materials_delivered_to_builder,
					m.q_delivered_cre AS quantity_materials_delivered_to_cre,
					m.q_ret_new AS quantity_new_materials_returned_by_builder,
					m.q_ret_generic AS quantity_materials_returned_by_builder,
					m.q_conciliation_221 AS quantity_entry_by_conciliation_221,
					-- DEPRECADA: las solicitudes (tipo 14) no afectan el almacen. Se mantiene en 0 solo por
					-- compatibilidad con pantallas que todavia la leen.
					0 AS request_materials_quantity,

					(m.q_picked_up_cre + m.q_debug_pending_cre + m.q_conciliation_221 + m.q_ret_generic)
					- (m.q_delivered_builder + m.q_delivered_builder_loan + m.q_delivered_cre) AS quantity_in_warehouse,

					f.fiscal_responsible_id,
					f.fiscal_responsible
				FROM ({$mov}) m
				JOIN mat_materials mat ON mat.id_mat = m.material_id
				LEFT JOIN wfl_projects pro ON pro.id_pro = m.project_id
				LEFT JOIN wfl_project_status ps ON ps.id_pst = pro.status_pro
				LEFT JOIN ({$fiscal}) f ON f.project_id = m.project_id
		) " . static::TABLE_NAME . "_master_detail
		";
	}

	/**
	 * @return string
	 */
	protected function _dataTableColumns() : string
	{
		return static::TABLE_NAME . "_master_detail.*";
	}

	/**
	 * Filtros que se aplican sobre las columnas calculadas.
	 * Ninguno altera el calculo del pendiente: project_status_id y material_code son constantes por
	 * proyecto / material, y el pendiente es por proyecto + material.
	 * @return string
	 */
	protected function _additionalParameters() : string
	{
		$sql = "";
		foreach ($this->_additionalParameters as $parameter => $value)
		{
			switch ($parameter)
			{
				case "show-material-pending-in-cre":
					if ($value == 1)
						$sql .= " and pending_material_in_cre > 0 ";
					break;
				case "fiscal-responsible-id":
					// fiscal_responsible_id es un GROUP_CONCAT ("5,8"): comparar con FIND_IN_SET
					if (is_numeric($value))
						$sql .= " and FIND_IN_SET(" . (int)$value . ", fiscal_responsible_id) ";
					break;
				case "project-status-id":
					$statusIds = $this->_intList('project-status-id');
					if (count($statusIds) > 0)
						$sql .= " and project_status_id IN (" . implode(',', $statusIds) . ") ";
					break;
				case "material-codes":
					$codes = array();
					foreach ($this->_list('material-codes') as $code)
						$codes[] = $this->_quote($code);
					if (count($codes) > 0)
						$sql .= " and material_code IN (" . implode(',', $codes) . ") ";
					break;
			}
		}
		return $sql;
	}

	/**
	 * Return the single data to draw the Select2 component
	 * @param int $page
	 * @return array
	 */
	public function getResponseForSelect2(int $page) : array
	{
		$objects = $this->search();
		$recordsFiltered = $this->searchTotalCount();
		$resultArray = array();
		$list = array();

		foreach ($objects as $row)
		{
			$row = (object)$row;
			$list[] = array(
				"id" => $row->project_material,
				"text" => "($row->material_code) " . $row->material_description
					. " [" . (self::STATUS_LABELS[(int)$row->status_id_prm] ?? $row->status_id_prm)
					. " · " . (self::TENSION_LABELS[(int)$row->tension_id_prm] ?? $row->tension_id_prm) . "]",
				"status_id_prm" => $row->status_id_prm,
				"tension_id_prm" => $row->tension_id_prm,
				"material_id" => $row->material_id,
				"material_code" => $row->material_code,
				"project_code" => $row->project_code,
				"quantity_assigned" => $row->quantity_assigned_materials,
				'quantity_additional' => $row->quantity_additional_materials,
				"material_description" => $row->material_description,
				"quantity_picked_up_from_cre" => $row->quantity_picked_up_from_cre,
				"request_materials_quantity" => $row->request_materials_quantity,
				"pending_material_in_cre" => $row->pending_material_in_cre,
				"quantity_materials_delivered_to_builder" => $row->quantity_materials_delivered_to_builder,
				"quantity_materials_delivered_to_cre" => $row->quantity_materials_delivered_to_cre,
				"quantity_materials_returned_by_builder" => $row->quantity_materials_returned_by_builder,
				"quantity_in_warehouse" => $row->quantity_in_warehouse
			);
		}

		$moreResults = ($page * $this->_limit) < $recordsFiltered;
		$resultArray['list'] = $list;
		$resultArray['pagination'] = array("more" => $moreResults);
		return $resultArray;
	}

	/**
	 * SUM condicional por tipo(s) de movimiento.
	 */
	private function _sum(array $types, string $alias, string $extraCondition = "") : string
	{
		return "SUM(CASE WHEN msu.summary_type_id_msu IN (" . implode(',', $types) . ") {$extraCondition} THEN prm.quantity_prm ELSE 0 END) AS {$alias}";
	}

	/**
	 * Escapa un valor para usarlo como literal dentro del SQL.
	 */
	private function _quote($value) : string
	{
		return (string)DB::getPdo()->quote((string)$value);
	}

	/**
	 * @param string $key
	 * @return mixed
	 */
	private function _param(string $key)
	{
		return $this->_additionalParameters[$key] ?? "";
	}

	/**
	 * Parametro tipo lista (array, o texto separado por espacios, comas o saltos de linea) como array de strings.
	 * @param string $key
	 * @return string[]
	 */
	private function _list(string $key) : array
	{
		$raw = $this->_param($key);
		if ($raw === "" || $raw === null)
			return array();

		$items = is_array($raw) ? array_map('strval', $raw) : preg_split('/[\s,]+/', (string)$raw, -1, PREG_SPLIT_NO_EMPTY);
		$items = array_map('trim', $items);
		return array_values(array_unique(array_filter($items, function ($item) {
			return $item !== "";
		})));
	}

	/**
	 * Parametro tipo lista como enteros validos (descarta todo lo que no sea numerico).
	 * @param string $key
	 * @return int[]
	 */
	private function _intList(string $key) : array
	{
		$ids = array_filter($this->_list($key), function ($id) {
			return ctype_digit($id);
		});
		return array_values(array_unique(array_map('intval', $ids)));
	}

	/**
	 * Ids de material validos (solo enteros).
	 * @return int[]
	 */
	private function _materialIds() : array
	{
		return $this->_intList('material-ids');
	}
}