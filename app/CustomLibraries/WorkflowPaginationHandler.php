<?php
namespace App\CustomLibraries;

use App\Models\Project;
use Illuminate\Support\Facades\DB;

class WorkflowPaginationHandler extends BasePaginationHandler
{
	const TABLE_NAME = "workflow";
	const TABLE_ID = "id_pro";
	const ATTRIB_SUFIX = "_pro";

	private array $_columnsToShow;
	private array $_columnsAndDependencies;
	private array $_queryDependencies;

	public function __construct(int $limit = 100, int $offset = 0, string $orderBy = "", string $orderType = 'asc', string $textToSearch = "", array $colsArray = array())
	{
		parent::__construct($limit, $offset, $orderBy, $orderType, $textToSearch, $colsArray);
		$this->_setColumnsAndDependencies();
		$this->_setQueryDependencies();
		$this->_columnsToShow = [];
	}

	public function setColumnsToShow(array $columnList) : void
	{
		$this->_columnsToShow = $columnList;
	}

	/**
	 * This method return the master detail table
	 * @return string
	 */
	protected function _coreQuery() : string
	{
		$buildQuery = $this->_buildQuery();
		$core = "
			(
			SELECT
				id_pro,
				IF(energized_pro = 1, 'Si', 'No') energized_pro,
				work_area_pro,
				status_pro project_status_id,
				project_percentage_pro,
				code_pro,
				secondary_code_pro,
				detail_pro,
				budgetary_position_pro,
				entry_date_pro,
				folder_date_pro,
				minor_enlargement,
				end_contract_pro,
				CASE
					WHEN system_pro = 1 then 'Sistema Santa Cruz'
					WHEN system_pro = 2 then 'Sistema Velasco'
					WHEN system_pro = 3 then 'Sistema Misiones'
					WHEN system_pro = 4 then 'Sistema Camiri'
					WHEN system_pro = 5 then 'Sistema German bush'
					WHEN system_pro = 6 then 'Sistema Robore'
					WHEN system_pro = 7 then 'Sistema Valles'
				END system_pro,
				CASE
					WHEN management_by_pro = 1 then 'Sistema Santa Cruz'
					WHEN management_by_pro = 2 then 'Sistema Velasco'
					WHEN management_by_pro = 3 then 'Sistema Misiones'
					WHEN management_by_pro = 4 then 'Sistema Camiri'
					WHEN management_by_pro = 5 then 'Sistema German bush'
					WHEN management_by_pro = 6 then 'Sistema Robore'
					WHEN management_by_pro = 7 then 'Sistema Valles'
				END management_by_pro,
				address_pro,
				points_pro,
				distance_pro,
				quality_level_pro,
				latitude_pro project_latitude,
				longitude_pro project_longitude,
				cre_design_completion_date_pro,
				cre_building_completion_date_pro,
				project_start_pro schedule_start,
				project_end_pro schedule_end,
				{$buildQuery['columns']}
				'' as record_building_materials_date,
				'' as get_materials_date,
				'' as deliver_materials_date,
				'' as materials_reception_date
			FROM
				wfl_projects
			{$buildQuery['dependencies']}
			WHERE
				deleted_pro != 1
			{code-list}
			{id-list}
			) ".static::TABLE_NAME."
		";
		return $this->_applyNestedFilters($core);
	}

	/**
	 * This method define the columns that will be used from _coreQuery
	 * @return string
	 */
	protected function _dataTableColumns() : string
	{
		return static::TABLE_NAME.".*";
	}

	/**
	 * Handle the additional parameters.
	 * @return string
	 */
	protected function _additionalParameters() : string
	{
		$filters = $this->_additionalParameters;
		$keywordDateRange = isset($filters["keyword"]) && $filters["keyword"] != "" ? $filters["keyword"] : "";
		$year             = isset($filters["year"])    && $filters["year"]    != "" ? $filters["year"]    : "";
		$rowKey           = isset($filters["rowKey"])  && $filters["rowKey"]  != "" ? $filters["rowKey"]  : "";
		$month            = isset($filters["month"])   && $filters["month"]   != "" ? $filters["month"]   : "";
		$startMonth       = $month !== "" ? $month : "01";
		$endMonth         = $month !== "" ? $month : "12";

		$sql = "";

		// ── Filtro por rango de fecha según keyword de estado ─────────────
		switch ($keywordDateRange)
		{
			case 'project_has_been_created':
				$sql = " and entry_date_pro BETWEEN '{$year}-{$startMonth}-01 00:00:00' and '{$year}-{$endMonth}-31 23:59:59' ";
				break;
			case 'already_sent':
				$sql = " and already_sent.entry_date BETWEEN '{$year}-{$startMonth}-01 00:00:00' and '{$year}-{$endMonth}-31 23:59:59' ";
				break;
			case 'approved':
				$sql = " and approved.entry_date BETWEEN '{$year}-{$startMonth}-01 00:00:00' and '{$year}-{$endMonth}-31 23:59:59' ";
				break;
			case 'completed':
				$sql = " and completed.entry_date BETWEEN '{$year}-{$startMonth}-01 00:00:00' and '{$year}-{$endMonth}-31 23:59:59' ";
				break;
			case 'as_built':
				$sql = " and as_built.entry_date BETWEEN '{$year}-{$startMonth}-01 00:00:00' and '{$year}-{$endMonth}-31 23:59:59' ";
				break;
			case 'conciliation_shipment':
				$sql = " and conciliation_shipment.entry_date BETWEEN '{$year}-{$startMonth}-01 00:00:00' and '{$year}-{$endMonth}-31 23:59:59' ";
				break;
			case 'project_real_budget_confirmation':
				$sql = " and payment_order_registered.entry_date BETWEEN '{$year}-{$startMonth}-01 00:00:00' and '{$year}-{$endMonth}-31 23:59:59' ";
				break;
		}

		// ── Filtro por rowKey (conteos especiales del dashboard) ──────────
		switch ($rowKey)
		{
			case "countId":
				break;
			case "countDigitizationPoints":
				$sql .= " and digitization.points_quantity_prp is not null and digitization.distance_prp is not null ";
				break;
			case "countWithoutDigitizationPoints":
				$sql .= " and digitization.points_quantity_prp is null and digitization.distance_prp is null ";
				break;
			case "countAsBuiltPoints":
				$sql .= " and as_built.points_quantity_prp is not null and as_built.distance_prp is not null ";
				break;
			case "countWithoutAsBuiltPoints":
				$sql .= " and as_built.points_quantity_prp is null and as_built.distance_prp is null ";
				break;
			case "countBudgets":
				$sql .= " and approved.total_budget is not null ";
				break;
			case "countWithoutBudgets":
				$sql .= " and approved.total_budget is null ";
				break;
			case "countRealBudgets":
				$sql .= " and conciliation_reception.total_real_budget is not null ";
				break;
			case "countWithoutRealBudgets":
				$sql .= " and conciliation_reception.total_real_budget is null ";
				break;
		}

		// ── Filtro por lista de códigos ───────────────────────────────────
		if (isset($filters["code-list"]) && $filters["code-list"] != "")
		{
			$codeList = $this->_parseList($filters["code-list"]);
			if (!empty($codeList))
			{
				$escaped = implode(", ", array_map(fn($v) => DB::getPdo()->quote($v), $codeList));
				$sql .= " and code_pro in ({$escaped}) ";
			}
		}

		// ── Filtro por lista de IDs ───────────────────────────────────────
		if (isset($filters["id-list"]) && $filters["id-list"] != "")
		{
			$idList = $this->_parseList($filters["id-list"]);
			if (!empty($idList))
			{
				$escaped = implode(", ", array_map('intval', $idList));
				$sql .= " and id_pro in ({$escaped}) ";
			}
		}

		// ── Filtro por keyword de estado ─────────────────────────────────
		if (isset($filters["status-keyword"]) && $filters["status-keyword"] != "")
		{
			$statusList = array_map(
				fn($s) => DB::getPdo()->quote(trim($s)),
				explode(",", $filters["status-keyword"])
			);
			$sql .= " and keyword_pst in( " . implode(", ", $statusList) . " )";
		}

		// ── Filtro por ID de estado ───────────────────────────────────────
		if (isset($filters["status"]) && $filters["status"] != "")
		{
			$statusList = array_map('intval', explode(",", $filters["status"]));
			$sql .= " and project_status_id in ( " . implode(", ", $statusList) . " )";
		}

		// ── Filtro por contrato ───────────────────────────────────────────
		if (isset($filters["contract-id"]) && $filters["contract-id"] != "")
		{
			$sql .= " and end_contract_pro = " . intval($filters["contract-id"]) . " ";
		}

		// ── Filtro por sistema ────────────────────────────────────────────
		if (isset($filters["system"]) && $filters["system"] != "")
		{
			$sql .= " and system_pro = " . DB::getPdo()->quote($filters["system"]) . " ";
		}

		// ── Filtro por gestión ────────────────────────────────────────────
		if (isset($filters["management-by"]) && $filters["management-by"] != "")
		{
			$sql .= " and management_by_pro = " . DB::getPdo()->quote($filters["management-by"]) . " ";
		}

		// ── Filtro por área de trabajo ────────────────────────────────────
		if (isset($filters["work-area"]) && $filters["work-area"] != "")
		{
			$sql .= " and work_area_pro = " . DB::getPdo()->quote($filters["work-area"]) . " ";
		}

		// ── Filtro por fiscal responsable ─────────────────────────────────
		if (isset($filters["fiscal-responsible-id"]) && $filters["fiscal-responsible-id"] != "")
		{
			$sql .= " and fiscal_responsible_id = " . intval($filters["fiscal-responsible-id"]) . " ";
		}

		// ── Filtro por constructor responsable ────────────────────────────
		if (isset($filters["builder-responsible-id"]) && $filters["builder-responsible-id"] != "")
		{
			$sql .= " and builder_responsible_id = " . intval($filters["builder-responsible-id"]) . " ";
		}

		// ── Filtro por mano de obra subida ────────────────────────────────
		if (isset($filters["manpower-uploaded"]) && $filters["manpower-uploaded"] !== "")
		{
			if ($filters["manpower-uploaded"] == 1)
				$sql .= " and manpower_file_id is not null ";
			elseif ($filters["manpower-uploaded"] == 0)
				$sql .= " and manpower_file_id is null ";
		}

		// ── Filtro por poda de árboles ────────────────────────────────────
		if (isset($filters["trim-tree"]) && $filters["trim-tree"] !== "")
		{
			if ($filters["trim-tree"] == 1)
				$sql .= " and trim_tree = 1 ";
			elseif ($filters["trim-tree"] == 0)
				$sql .= " and (trim_tree is null or trim_tree = 0) ";
		}

		// ── Filtro por ubicación ──────────────────────────────────────────
		if (isset($filters["has-location"]) && $filters["has-location"] !== "")
		{
			if ($filters["has-location"] == 1)
				$sql .= " and project_latitude is not null and project_latitude != '' and project_latitude != '0' ";
			elseif ($filters["has-location"] == 0)
				$sql .= " and (project_latitude is null or project_latitude = '') ";
		}

		// ── Filtro por materiales retirados de CRE ────────────────────────
		if (isset($filters["quantity-picked-up-from-cre"]) && $filters["quantity-picked-up-from-cre"] != "")
		{
			$sql .= " and quantity_picked_up_from_cre = " . floatval($filters["quantity-picked-up-from-cre"]) . " ";
		}

		// ── Filtro por materiales pendientes en CRE ───────────────────────
		if (isset($filters["quantity-pending-in-cre"]) && $filters["quantity-pending-in-cre"] != "")
		{
			$sql .= " and pending_material_in_cre = " . floatval($filters["quantity-pending-in-cre"]) . " ";
		}

		// ── Filtro: todos los materiales retirados ────────────────────────
		if (isset($filters["all-materials-picked-up-from-cre"]) && $filters["all-materials-picked-up-from-cre"] != "")
		{
			$sql .= " and pending_material_in_cre <= 0 and quantity_materials_assigned > 0 ";
		}

		// ── Filtro: ningún material retirado ──────────────────────────────
		if (isset($filters["none-materials-picked-up-from-cre"]) && $filters["none-materials-picked-up-from-cre"] != "")
		{
			$sql .= " and pending_material_in_cre = quantity_materials_assigned and quantity_materials_assigned > 0 ";
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
		$objects         = $this->search();
		$recordsFiltered = $this->searchTotalCount();
		$list            = [];

		foreach ($objects as $row)
		{
			$result = [
				"id"   => $row->id_pro,
				"text" => $row->code_pro,
			];

			foreach ($this->_columnsToShow as $column)
			{
				if ($column != "")
				{
					$result[$column] = $row->$column;
				}
			}

			$list[] = $result;
		}

		return [
			'list'       => $list,
			'pagination' => ['more' => ($page * $this->_limit) < $recordsFiltered],
		];
	}

	// ─────────────────────────────────────────────────────────────────────────
	// COLUMNAS Y DEPENDENCIAS
	// ─────────────────────────────────────────────────────────────────────────

	private function _setColumnsAndDependencies() : void
	{
		$this->_columnsAndDependencies = [

			// Stakes (status 2)
			'stake_date'                 => ['column' => 'stakes.entry_date stake_date',                        'dependencies' => ['stakes']],
			'stake_responsible_user_id'  => ['column' => 'stakes.responsible_user_id stake_responsible_user_id','dependencies' => ['stakes']],
			'stake_responsible'          => ['column' => 'stakes.responsible stake_responsible',                 'dependencies' => ['stakes']],

			// RD Digitization (status 16)
			'rd_digitization_points_quantity' => ['column' => 'rd_digitization.points_quantity_prp rd_digitization_points_quantity', 'dependencies' => ['rd_digitization']],
			'rd_digitization_distance'        => ['column' => 'rd_digitization.distance_prp rd_digitization_distance',               'dependencies' => ['rd_digitization']],

			// Returned (status 20)
			'returned_date' => ['column' => 'returned.entry_date returned_date', 'dependencies' => ['returned']],

			// Digitization (status 3)
			'digitization_points_quantity' => ['column' => 'digitization.points_quantity_prp digitization_points_quantity', 'dependencies' => ['digitization']],
			'digitization_distance'        => ['column' => 'digitization.distance_prp digitization_distance',               'dependencies' => ['digitization']],
			'digitization_date'            => ['column' => 'digitization.entry_date digitization_date',                     'dependencies' => ['digitization']],

			// Drawing (status 5)
			'drawing_date' => ['column' => 'drawing.entry_date drawing_date', 'dependencies' => ['drawing']],

			// Schedule (status 6)
			'schedule_date'                => ['column' => 'schedulee.entry_date schedule_date',                              'dependencies' => ['schedulee']],
			'trim_tree'                    => ['column' => 'schedulee.trim_tree_prb trim_tree',                               'dependencies' => ['schedulee']],
			'schedule_design_budget'       => ['column' => 'schedulee.design_prb schedule_design_budget',                    'dependencies' => ['schedulee']],
			'schedulee_tentative_total_budget' => ['column' => 'schedulee.tentative_total_budget_prb schedulee_tentative_total_budget', 'dependencies' => ['schedulee']],

			// Presupuesto actual calculado — FIX: agregado 'wfl_project_status' a las dependencias
			'project_current_budget' => ['column' => "
				CASE
					WHEN keyword_pst in('project_has_been_created','drawing','stakes','digitization','returned')
						then initial_design_budget_pro + initial_building_budget_pro
					WHEN keyword_pst in('schedule','ready_to_send','already_sent','rectify_design','rectify_illustration','rd_stakes','rd_digitization','rd_drawing','ri_digitization','ri_drawing')
						then if(schedulee.tentative_total_budget_prb is not null && schedulee.tentative_total_budget_prb > 0, schedulee.tentative_total_budget_prb, schedulee.design_prb)
					WHEN keyword_pst in('canceled')
						then canceled.design_prb
					WHEN keyword_pst in('approved','assign_to','in_progress','paused','stopped','completed','project_energized','as_built')
						then approved.total_budget
					WHEN keyword_pst in('conciliation_reception','conciliation_shipment','cre_return_order','project_return_materials','project_real_budget_confirmation')
						then if(payment_order_registered.order_number_pao != '', payment_order_registered.total_real_budget, conciliation_reception.total_real_budget)
				END project_current_budget",
				'dependencies' => ['schedulee','canceled','approved','payment_order_registered','conciliation_reception','wfl_project_status']], // FIX: faltaba 'wfl_project_status'

			// Presupuesto de diseño actual calculado — FIX: mismo fix
			'project_current_design_budget' => ['column' => "
				CASE
					WHEN keyword_pst in('project_has_been_created','drawing','stakes','digitization','returned')
						then initial_design_budget_pro
					WHEN keyword_pst in('schedule','ready_to_send','already_sent','rectify_design','rectify_illustration','rd_stakes','rd_digitization','rd_drawing','ri_digitization','ri_drawing')
						then schedulee.design_prb
					WHEN keyword_pst in('canceled')
						then canceled.design_prb
					WHEN keyword_pst in('approved','assign_to','in_progress','paused','stopped','completed','project_energized','as_built')
						then approved.design_prb
					WHEN keyword_pst in('conciliation_reception','conciliation_shipment','cre_return_order','project_return_materials','project_real_budget_confirmation')
						then if(payment_order_registered.order_number_pao != '', payment_order_registered.design_budget_pop, conciliation_reception.design_reb)
				END project_current_design_budget",
				'dependencies' => ['schedulee','canceled','approved','payment_order_registered','conciliation_reception','wfl_project_status']], // FIX: faltaba 'wfl_project_status'

			// Ready to send (status 9)
			'ready_to_send_date' => ['column' => 'ready_to_send.entry_date ready_to_send_date', 'dependencies' => ['ready_to_send']],

			// Already sent (status 10)
			'already_sent_date' => ['column' => 'already_sent.entry_date already_sent_date', 'dependencies' => ['already_sent']],

			// Approved (status 11)
			'approved_reservation_number' => ['column' => 'approved.reservation_number_prb approved_reservation_number', 'dependencies' => ['approved']],
			'approved_graph_number'        => ['column' => 'approved.graph_number_prb approved_graph_number',             'dependencies' => ['approved']],
			'approved_date'                => ['column' => 'approved.entry_date approved_date',                           'dependencies' => ['approved']],
			'design_budget'                => ['column' => 'approved.design_prb design_budget',                           'dependencies' => ['approved']],
			'building_budget'              => ['column' => 'approved.building_prb building_budget',                       'dependencies' => ['approved']],
			'transportation_budget'        => ['column' => 'approved.transportation_prb transportation_budget',           'dependencies' => ['approved']],
			'live_line_budget'             => ['column' => 'approved.live_line_prb live_line_budget',                     'dependencies' => ['approved']],
			'right_of_way_budget'          => ['column' => 'approved.right_of_way_prb right_of_way_budget',               'dependencies' => ['approved']],
			'total_approved'               => ['column' => 'approved.total_budget total_approved',                        'dependencies' => ['approved']],
			'manpower_file_id'             => ['column' => 'approved.manpower_file_id',                                   'dependencies' => ['approved']],
			'live_line_assigned'           => ['column' => "if(status_pro >= 34, if(conciliation_reception.live_line_reb > 0,'Si','No'), if(approved.live_line_prb > 0,'Si','No')) live_line_assigned", 'dependencies' => ['conciliation_reception','approved']],
			'construction_assignment_id'   => ['column' => 'IF(assign_to.construction_assignment_id is null, approved.construction_assignment_id, assign_to.construction_assignment_id) construction_assignment_id', 'dependencies' => ['assign_to','approved']],
			'project_manager_user_id'      => ['column' => 'IF(assign_to.project_manager_id is null, approved.project_manager_id, assign_to.project_manager_id) project_manager_user_id',           'dependencies' => ['assign_to','approved']],
			'project_manager_assigned'     => ['column' => 'IF(assign_to.project_manager_id is null, approved.project_manager_full_name, assign_to.project_manager_full_name) project_manager_assigned', 'dependencies' => ['assign_to','approved']],

			// Producción
			'production_percentage' => ['column' => "
				CASE
					WHEN keyword_pst in('project_has_been_created','drawing','stakes','digitization','returned','schedule','ready_to_send','already_sent','rectify_design','rectify_illustration','rd_stakes','rd_digitization','rd_drawing','ri_digitization','ri_drawing','canceled')
						then 0.00
					WHEN keyword_pst in('approved','assign_to','in_progress','paused','stopped','completed','project_energized','as_built')
						then FORMAT((((IFNULL(production.total_bs,0) + approved.design_prb) * 100) / approved.total_budget), 2)
					WHEN keyword_pst in('conciliation_reception','conciliation_shipment','cre_return_order','project_return_materials','project_real_budget_confirmation')
						then FORMAT((((IFNULL(production.total_bs,0) + if(payment_order_registered.order_number_pao != '', payment_order_registered.design_budget_pop, conciliation_reception.design_reb)) * 100) / if(payment_order_registered.order_number_pao != '', payment_order_registered.total_real_budget, conciliation_reception.total_real_budget)), 2)
				END production_percentage",
				'dependencies' => ['production','approved','payment_order_registered','conciliation_reception','wfl_project_status']],

			// Canceled (status 12)
			'canceled_date' => ['column' => 'canceled.entry_date canceled_date', 'dependencies' => ['canceled']],

			// Rectify design (status 13)
			'rectify_design_date' => ['column' => 'rectify_design.entry_date rectify_design_date', 'dependencies' => ['rectify_design']],

			// Rectify illustration (status 14)
			'rectify_illustration_date' => ['column' => 'rectify_illustration.entry_date rectify_illustration_date', 'dependencies' => ['rectify_illustration']],

			// Assign to (status 21)
			'assign_to_date'        => ['column' => 'assign_to.entry_date assign_to_date',               'dependencies' => ['assign_to']],
			'assign_to_responsible' => ['column' => 'assign_to.responsible assign_to_responsible',        'dependencies' => ['assign_to']],
			'fiscal_responsible_id' => ['column' => 'assign_to.fiscal_responsible_id fiscal_responsible_id', 'dependencies' => ['assign_to']],
			'fiscal_responsible'    => ['column' => 'assign_to.fiscal_responsible fiscal_responsible',    'dependencies' => ['assign_to']],
			'power_down_assigned'   => ['column' => "if(assign_to.power_down_cas, 'Si','No') power_down_assigned", 'dependencies' => ['assign_to']],
			'maneuver_assigned'     => ['column' => "if(assign_to.maneuver_cas, 'Si','No') maneuver_assigned",     'dependencies' => ['assign_to']],
			'start_date_assigned'   => ['column' => 'assign_to.start_date_cas start_date_assigned',       'dependencies' => ['assign_to']],
			'end_date_assigned'     => ['column' => 'assign_to.end_date_cas end_date_assigned',           'dependencies' => ['assign_to']],
			'estimated_time_assigned' => ['column' => 'assign_to.estimated_time_cas estimated_time_assigned', 'dependencies' => ['assign_to']],

			// In progress (status 29) — FIX: restaurado fallback assign_to para builder_responsible y builder_responsible_id
			'builder_responsible'      => ['column' => 'IF(in_progress.builder_responsible is NULL, assign_to.builder_responsible, in_progress.builder_responsible) builder_responsible',       'dependencies' => ['in_progress','assign_to']],
			'builder_responsible_id'   => ['column' => 'IF(in_progress.builder_responsible_id is null, assign_to.builder_responsible_id, in_progress.builder_responsible_id) builder_responsible_id', 'dependencies' => ['in_progress','assign_to']],
			'builder_responsible_user_id' => ['column' => 'in_progress.responsible_user_id builder_responsible_user_id', 'dependencies' => ['in_progress']],
			'in_progress_date'         => ['column' => 'in_progress.entry_date in_progress_date',         'dependencies' => ['in_progress']],

			// In progress first detail (status 29 MIN)
			'in_progress_first_detail_date' => ['column' => 'in_progress_first_detail.entry_date in_progress_first_detail_date', 'dependencies' => ['in_progress_first_detail']],

			// Completed (status 32)
			'completed_date' => ['column' => 'completed.entry_date completed_date', 'dependencies' => ['completed']],

			// Paused (status 31)
			'paused_date'       => ['column' => 'paused.entry_date paused_date',               'dependencies' => ['paused']],
			'percentage_paused' => ['column' => 'paused.percentage_paused percentage_paused',  'dependencies' => ['paused']],

			// Stopped (status 30)
			'stopped_date'       => ['column' => 'stopped.entry_date stopped_date',              'dependencies' => ['stopped']],
			'percentage_stopped' => ['column' => 'stopped.percentage_stopped percentage_stopped','dependencies' => ['stopped']],

			// As built (status 33)
			'as_built_date'            => ['column' => 'as_built.entry_date as_built_date',                      'dependencies' => ['as_built']],
			'as_built_points_quantity' => ['column' => 'as_built.points_quantity_prp as_built_points_quantity',  'dependencies' => ['as_built']],
			'as_built_distance'        => ['column' => 'as_built.distance_prp as_built_distance',                'dependencies' => ['as_built']],

			// Conciliation reception (status 34)
			'conciliation_reception_date' => ['column' => 'conciliation_reception.entry_date conciliation_reception_date', 'dependencies' => ['conciliation_reception']],

			// Conciliation shipment (status 35)
			'conciliation_shipment_date' => ['column' => 'conciliation_shipment.entry_date conciliation_shipment_date', 'dependencies' => ['conciliation_shipment']],

			// Payment order registered (status 42)
			'payment_order_registered_design_budget'        => ['column' => "if(payment_order_registered.order_number_pao != '', payment_order_registered.design_budget_pop,        conciliation_reception.design_reb)        payment_order_registered_design_budget",        'dependencies' => ['payment_order_registered','conciliation_reception']],
			'payment_order_registered_building_budget'      => ['column' => "if(payment_order_registered.order_number_pao != '', payment_order_registered.building_budget_pop,      conciliation_reception.building_reb)      payment_order_registered_building_budget",      'dependencies' => ['payment_order_registered','conciliation_reception']],
			'payment_order_registered_transportation_budget'=> ['column' => "if(payment_order_registered.order_number_pao != '', payment_order_registered.transportation_budget_pop,conciliation_reception.transportation_reb) payment_order_registered_transportation_budget",'dependencies' => ['payment_order_registered','conciliation_reception']],
			'payment_order_registered_live_line_budget'     => ['column' => "if(payment_order_registered.order_number_pao != '', payment_order_registered.live_line_budget_pop,     conciliation_reception.live_line_reb)     payment_order_registered_live_line_budget",     'dependencies' => ['payment_order_registered','conciliation_reception']],
			'payment_order_registered_right_of_way_budget'  => ['column' => "if(payment_order_registered.order_number_pao != '', payment_order_registered.right_of_way_budget_pop, conciliation_reception.right_of_way_reb)  payment_order_registered_right_of_way_budget",  'dependencies' => ['payment_order_registered','conciliation_reception']],
			'payment_order_registered_total_real_budget'    => ['column' => "if(payment_order_registered.order_number_pao != '', payment_order_registered.total_real_budget,        conciliation_reception.total_real_budget) payment_order_registered_total_real_budget",    'dependencies' => ['payment_order_registered','conciliation_reception']],
			'payment_order_registered_date'             => ['column' => 'payment_order_registered.entry_date payment_order_registered_date',                    'dependencies' => ['payment_order_registered']],
			'payment_order_registered_order_number'     => ['column' => 'payment_order_registered.order_number_pao payment_order_registered_order_number',      'dependencies' => ['payment_order_registered']],
			'payment_order_registered_contract_number'  => ['column' => 'payment_order_registered.end_contract_number payment_order_registered_contract_number','dependencies' => ['payment_order_registered']],
			'payment_status'                            => ['column' => "if(payment_order_registered.order_number_pao != '','Pagado','Pendiente de pago') payment_status", 'dependencies' => ['payment_order_registered']],
			'payment_order_registered_invoice_number'   => ['column' => 'payment_order_registered.invoice_number_pao payment_order_registered_invoice_number',  'dependencies' => ['payment_order_registered']],

			// CRE return order (status 37)
			'cre_return_order_date' => ['column' => 'cre_return_order.entry_date cre_return_order_date', 'dependencies' => ['cre_return_order']],

			// Project return materials (status 38)
			'project_return_materials_date' => ['column' => 'project_return_materials.entry_date project_return_materials_date', 'dependencies' => ['project_return_materials']],

			// Project return materials 2 (status 39)
			'project_return_materials2_date' => ['column' => 'project_return_materials2.entry_date project_return_materials2_date', 'dependencies' => ['project_return_materials2']],

			// Project energized (status 47)
			'project_energized_entry_date' => ['column' => 'project_energized.entry_date project_energized_entry_date', 'dependencies' => ['project_energized']],

			// Payment order invoice sent (status 43)
			'payment_order_invoice_sent_date' => ['column' => 'payment_order_invoice_sent.entry_date payment_order_invoice_sent_date', 'dependencies' => ['payment_order_invoice_sent']],

			// Payment order settled (status 44)
			'payment_order_has_been_settled_date' => ['column' => 'payment_order_has_been_settled.entry_date payment_order_has_been_settled_date', 'dependencies' => ['payment_order_has_been_settled']],

			// Estado del proyecto
			'status_name_pst' => ['column' => 'status_name_pst', 'dependencies' => ['wfl_project_status']],
			'keyword_pst'     => ['column' => 'keyword_pst',      'dependencies' => ['wfl_project_status']],
			'order_pst'       => ['column' => 'order_pst',        'dependencies' => ['wfl_project_status']],

			// Fiscal CRE
			'cre_fiscal_id'    => ['column' => 'cre_fiscal.id_usr cre_fiscal_id',                                              'dependencies' => ['cre_fiscal']],
			'cre_fiscal_pro'   => ['column' => "concat(cre_fiscal.firstname_usr,' ', cre_fiscal.lastname_usr) cre_fiscal_pro", 'dependencies' => ['cre_fiscal']],
			'cre_fiscal_email' => ['column' => 'cre_fiscal.email_usr cre_fiscal_email',                                        'dependencies' => ['cre_fiscal']],

			// Contratos
			'initial_id_con'              => ['column' => 'initial_contract.id_con initial_id_con',                             'dependencies' => ['initial_contract']],
			'initial_contract_number_con' => ['column' => 'initial_contract.contract_number_con initial_contract_number_con',   'dependencies' => ['initial_contract']],
			'final_id_con'                => ['column' => 'final_contract.id_con final_id_con',                                 'dependencies' => ['final_contract']],
			'final_contract_number_con'   => ['column' => 'final_contract.contract_number_con final_contract_number_con',       'dependencies' => ['final_contract']],

			// Log de estado actual
			'static_days'                  => ['column' => 'TIMESTAMPDIFF(DAY, status_log_manual_entry_date.manual_entry_date_psl, now()) static_days', 'dependencies' => ['status_log_manual_entry_date']],
			'status_log_manual_entry_date' => ['column' => 'status_log_manual_entry_date.manual_entry_date_psl status_log_manual_entry_date',           'dependencies' => ['status_log_manual_entry_date']],
			'responsible'                  => ['column' => 'status_log_manual_entry_date.responsible responsible',                                       'dependencies' => ['status_log_manual_entry_date']],

			// Incidentes
			'percentage_inc'           => ['column' => 'percentage_inc',                                       'dependencies' => ['wfl_incidents']],
			'detail_inc'               => ['column' => 'detail_inc',                                           'dependencies' => ['wfl_incidents']],
			'last_week_percentage'     => ['column' => 'wfl_incidents_last_week.last_week_percentage',         'dependencies' => ['wfl_incidents_last_week']],
			'previous_percentage'      => ['column' => 'previous_incident.previous_percentage',                'dependencies' => ['previous_incident']],
			'previous_manual_entry_date' => ['column' => 'previous_incident.previous_manual_entry_date',      'dependencies' => ['previous_incident']],
			'last_three_incidents'     => ['column' => 'wfl_incidents_last_three_incidents.last_three_incidents', 'dependencies' => ['wfl_incidents_last_three_incidents']],

			// Producción total
			'production_total_bs' => ['column' => 'production.total_bs production_total_bs', 'dependencies' => ['production']],

			// Materiales
			'quantity_picked_up_from_cre' => ['column' => 'IFNULL(quantity_picked_up_from_cre.quantity, 0) quantity_picked_up_from_cre', 'dependencies' => ['quantity_picked_up_from_cre']],
			'materials_delivered_to_cre'  => ['column' => 'IFNULL(materials_delivered_to_cre.quantity, 0) materials_delivered_to_cre',   'dependencies' => ['materials_delivered_to_cre']],
			'quantity_materials_assigned' => ['column' => 'IFNULL(quantity_materials_assigned.quantity, 0) quantity_materials_assigned',  'dependencies' => ['quantity_materials_assigned']],
			'pending_material_in_cre'     => ['column' => 'IFNULL(quantity_materials_assigned.quantity, 0)-IFNULL(quantity_picked_up_from_cre.quantity, 0) pending_material_in_cre', 'dependencies' => ['quantity_picked_up_from_cre','quantity_materials_assigned']],
		];
	}

	// ─────────────────────────────────────────────────────────────────────────
	// DEPENDENCIAS (JOINs)
	// ─────────────────────────────────────────────────────────────────────────

	private function _setQueryDependencies() : void
	{
		$this->_queryDependencies = [
			'stakes'                    => " LEFT JOIN (".Project::statusDetailQuery(2).") stakes on stakes.project_id_psl = id_pro ",
			'rd_digitization'           => " LEFT JOIN (".Project::statusDetailQuery(16).") rd_digitization on rd_digitization.project_id_psl = id_pro ",
			'returned'                  => " LEFT JOIN (".Project::statusDetailQuery(20).") returned on returned.project_id_psl = id_pro ",
			'digitization'              => " LEFT JOIN (".Project::statusDetailQuery(3).") digitization on digitization.project_id_psl = id_pro ",
			'drawing'                   => " LEFT JOIN (".Project::statusDetailQuery(5).") drawing on drawing.project_id_psl = id_pro ",
			'schedulee'                 => " LEFT JOIN (".Project::statusDetailQuery(6).") schedulee on schedulee.project_id_psl = id_pro ",
			'ready_to_send'             => " LEFT JOIN (".Project::statusDetailQuery(9).") ready_to_send on ready_to_send.project_id_psl = id_pro ",
			'already_sent'              => " LEFT JOIN (".Project::statusDetailQuery(10).") already_sent on already_sent.project_id_psl = id_pro ",
			'approved'                  => " LEFT JOIN (".Project::statusDetailQuery(11).") approved on approved.project_id_psl = id_pro ",
			'canceled'                  => " LEFT JOIN (".Project::statusDetailQuery(12).") canceled on canceled.project_id_psl = id_pro ",
			'rectify_design'            => " LEFT JOIN (".Project::statusDetailQuery(13).") rectify_design on rectify_design.project_id_psl = id_pro ",
			'rectify_illustration'      => " LEFT JOIN (".Project::statusDetailQuery(14).") rectify_illustration on rectify_illustration.project_id_psl = id_pro ",
			'assign_to'                 => " LEFT JOIN (".Project::statusDetailQuery(21).") assign_to on assign_to.project_id_psl = id_pro ",
			'in_progress'               => " LEFT JOIN (".Project::statusDetailQuery(29).") in_progress on in_progress.project_id_psl = id_pro ",
			'in_progress_first_detail'  => " LEFT JOIN (".Project::statusDetailQuery(29, TRUE).") in_progress_first_detail on in_progress_first_detail.project_id_psl = id_pro ",
			'completed'                 => " LEFT JOIN (".Project::statusDetailQuery(32).") completed on completed.project_id_psl = id_pro ",
			'paused'                    => " LEFT JOIN (".Project::statusDetailQuery(31).") paused on paused.project_id_psl = id_pro ",
			'stopped'                   => " LEFT JOIN (".Project::statusDetailQuery(30).") stopped on stopped.project_id_psl = id_pro ",
			'as_built'                  => " LEFT JOIN (".Project::statusDetailQuery(33).") as_built on as_built.project_id_psl = id_pro ",
			'conciliation_reception'    => " LEFT JOIN (".Project::statusDetailQuery(34).") conciliation_reception on conciliation_reception.project_id_psl = id_pro ",
			'conciliation_shipment'     => " LEFT JOIN (".Project::statusDetailQuery(35).") conciliation_shipment on conciliation_shipment.project_id_psl = id_pro ",
			'cre_return_order'          => " LEFT JOIN (".Project::statusDetailQuery(37).") cre_return_order on cre_return_order.project_id_psl = id_pro ",
			'project_return_materials'  => " LEFT JOIN (".Project::statusDetailQuery(38).") project_return_materials on project_return_materials.project_id_psl = id_pro ",
			'project_return_materials2' => " LEFT JOIN (".Project::statusDetailQuery(39).") project_return_materials2 on project_return_materials2.project_id_psl = id_pro ",
			'project_energized'         => " LEFT JOIN (".Project::statusDetailQuery(47).") project_energized on project_energized.project_id_psl = id_pro ",
			'payment_order_registered'      => " LEFT JOIN (".Project::paymentOrderStatusDetailQuery(42).") payment_order_registered on payment_order_registered.project_id_pop = id_pro ",
			'payment_order_invoice_sent'    => " LEFT JOIN (".Project::paymentOrderStatusDetailQuery(43).") payment_order_invoice_sent on payment_order_invoice_sent.project_id_pop = id_pro ",
			'payment_order_has_been_settled'=> " LEFT JOIN (".Project::paymentOrderStatusDetailQuery(44).") payment_order_has_been_settled on payment_order_has_been_settled.project_id_pop = id_pro ",
			'wfl_project_status'  => " LEFT JOIN wfl_project_status on status_pro = id_pst ",
			'cre_fiscal'          => " LEFT JOIN sec_users cre_fiscal on cre_fiscal.id_usr = cre_fiscal_pro ",
			'initial_contract'    => " LEFT JOIN wfl_contracts initial_contract on contract_id_pro = initial_contract.id_con ",
			'final_contract'      => " LEFT JOIN wfl_contracts final_contract on end_contract_pro = final_contract.id_con ",
			'status_log_manual_entry_date' => "
				LEFT JOIN (
					select * from (
						select
							project_id_psl project_id,
							max(manual_entry_date_psl) max_date
						from (
							SELECT
								project_id_psl,
								manual_entry_date_psl
							FROM
								wfl_project_status_log
							LEFT JOIN wfl_status_log_responsibles on status_log_id_slr = id_psl
							where deleted_psl != 1 and deleted_slr != 1 {id-list-psl}
							GROUP BY id_psl
						) statusLogAndResponsible group by project_id_psl
					) as max_entry
					LEFT JOIN (
						SELECT
							id_psl,
							project_id_psl,
							log_detail_psl,
							manual_entry_date_psl,
							GROUP_CONCAT(CONCAT(firstname_usr,' ',lastname_usr)) responsible,
							GROUP_CONCAT(id_usr) responsible_ids
						FROM
							wfl_project_status_log
						LEFT JOIN wfl_status_log_responsibles on status_log_id_slr = id_psl
						LEFT JOIN wfl_status_responsibles on id_sre = responsible_id_slr
						LEFT JOIN sec_users on id_usr = user_id_sre
						where deleted_psl != 1 and deleted_slr != 1 {id-list-psl}
						GROUP BY id_psl
					) log on log.project_id_psl = max_entry.project_id and log.manual_entry_date_psl = max_entry.max_date
				) as status_log_manual_entry_date on status_log_manual_entry_date.project_id_psl = id_pro ",
			'wfl_incidents' => "
				LEFT JOIN (
					select inc.*
					from (
						select
							project_id_inc,
							max(manual_entry_date_inc) manual_entry_date_inc
						from wfl_incidents
						left join wfl_projects on id_pro = project_id_inc
						where 1 = 1
						and status_pro = status_id_inc
						{id-list-inc}
						GROUP BY project_id_inc
					) as filtered
					inner join wfl_incidents as inc on inc.project_id_inc = filtered.project_id_inc and inc.manual_entry_date_inc = filtered.manual_entry_date_inc
				) wfl_incidents on project_id_inc = id_pro ",
			'wfl_incidents_last_week' => "
				LEFT JOIN (
					select
						IFNULL(percentage_inc,0) last_week_percentage,
						project_id_inc last_week_project_id
					from (
						select
							project_id_inc last_week_project_id,
							max(manual_entry_date_inc) last_week_manual_entry_date
						from wfl_incidents
						where status_id_inc in (29) {id-list-inc}
						and manual_entry_date_inc >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY
						AND manual_entry_date_inc < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY
						GROUP BY project_id_inc
					) as filtered_last_week
					inner join wfl_incidents as inc on inc.project_id_inc = filtered_last_week.last_week_project_id and inc.manual_entry_date_inc = filtered_last_week.last_week_manual_entry_date
				) wfl_incidents_last_week on last_week_project_id = id_pro ",
			'previous_incident' => "
				LEFT JOIN (
					select
						current.project_id_inc project_id,
						current.percentage_inc current_percentage,
						current.manual_entry_date_inc current_manual_entry_date,
						IFNULL(previous.percentage_inc,0) previous_percentage,
						previous.manual_entry_date_inc previous_manual_entry_date
					from (
						SELECT
							t1.project_id_inc project_id,
							max(t1.manual_entry_date_inc) current_update,
							max(t2.manual_entry_date_inc) previous_update
						FROM
							wfl_incidents t1
							LEFT JOIN wfl_incidents t2 ON t1.project_id_inc = t2.project_id_inc AND t2.manual_entry_date_inc < t1.manual_entry_date_inc
						where 1 {id-list-inc-t1}
						GROUP BY t1.project_id_inc
					) current_and_previous
					LEFT JOIN wfl_incidents previous on previous.project_id_inc = current_and_previous.project_id and previous.manual_entry_date_inc = current_and_previous.previous_update
					LEFT JOIN wfl_incidents current on current.project_id_inc = current_and_previous.project_id and current.manual_entry_date_inc = current_and_previous.current_update
				) previous_incident on previous_incident.project_id = id_pro ",
			'wfl_incidents_last_three_incidents' => "
				LEFT JOIN (
					SELECT
						project_id_inc,
						SUBSTRING_INDEX(GROUP_CONCAT(CONCAT(percentage_inc,' (',DATE_FORMAT(manual_entry_date_inc,'%d-%m-%Y'),')') ORDER BY manual_entry_date_inc desc SEPARATOR '\n'), '\n', 3) last_three_incidents
					FROM wfl_incidents
					where deleted_inc != 1 {id-list-inc}
					GROUP BY project_id_inc
				) wfl_incidents_last_three_incidents on wfl_incidents_last_three_incidents.project_id_inc = id_pro ",
			'production' => "
				LEFT JOIN (
					SELECT
						project_id_lad,
						sum(ROUND(worked_up_wus * price_wus, 2)) total_bs
					FROM
						bui_worked_up_structures
					LEFT JOIN bui_labor_cost on id_lac = labor_cost_id_wus
					LEFT JOIN bui_building_structures on building_structure_id_lac = id_bus
					LEFT JOIN bui_labor_details on id_lad = labor_detail_id_lac
					LEFT JOIN bui_labor_cost_log on id_lal = labor_cost_log_id_wus
					LEFT JOIN bui_building_points on point_id_lal = id_bpo
					where
						deleted_wus != 1
						and deleted_lal != 1 {id-list-lad}
						and status_id_lad = 11
					GROUP BY project_id_lad
				) production on production.project_id_lad = id_pro ",
			'quantity_picked_up_from_cre' => "
				LEFT JOIN (
					SELECT sum(quantity_prm) quantity, project_id_msu project_id
					FROM mat_projects_materials
					LEFT JOIN mat_materials_summary on materials_summary_id_prm = id_msu
					where summary_type_id_msu in (3) and deleted_msu != 1 and deleted_prm != 1 {id-list-msu}
					GROUP BY project_id_msu
				) quantity_picked_up_from_cre on quantity_picked_up_from_cre.project_id = id_pro ",
			'materials_delivered_to_cre' => "
				LEFT JOIN (
					SELECT sum(quantity_prm) quantity, project_id_msu project_id
					FROM mat_projects_materials
					LEFT JOIN mat_materials_summary on materials_summary_id_prm = id_msu
					where summary_type_id_msu in (8) and deleted_msu != 1 and deleted_prm != 1 {id-list-msu}
					GROUP BY project_id_msu
				) materials_delivered_to_cre on materials_delivered_to_cre.project_id = id_pro ",
			'quantity_materials_assigned' => "
				LEFT JOIN (
					SELECT sum(quantity_prm) quantity, project_id_msu project_id
					FROM mat_projects_materials
					LEFT JOIN mat_materials_summary on materials_summary_id_prm = id_msu
					where summary_type_id_msu in (1,2) and deleted_msu != 1 and deleted_prm != 1 {id-list-msu}
					GROUP BY project_id_msu
				) quantity_materials_assigned on quantity_materials_assigned.project_id = id_pro ",
		];
	}

	// ─────────────────────────────────────────────────────────────────────────
	// BUILD QUERY
	// ─────────────────────────────────────────────────────────────────────────

	private function _buildQuery() : array
	{
		$columns      = "";
		$dependencies = "";
		$dependencyList = [];

		$columnsAndDependencies = $this->_columnsAndDependencies;

		// Si hay columnas específicas solicitadas, filtramos
		if (count($this->_columnsToShow) > 0)
		{
			$columnsAndDependencies = array_filter(
				$columnsAndDependencies,
				fn($k) => in_array($k, $this->_columnsToShow),
				ARRAY_FILTER_USE_KEY
			);
		}

		foreach ($columnsAndDependencies as $value)
		{
			$columns .= $value['column'] . ",";
			foreach ($value['dependencies'] as $dependency)
			{
				$dependencyList[$dependency] = $dependency;
			}
		}

		// FIX: se eliminó el dd() que bloqueaba la ejecución
		foreach ($this->_queryDependencies as $key => $query)
		{
			if (isset($dependencyList[$key]))
			{
				$dependencies .= $query . "\n";
			}
		}

		return [
			'columns'      => $columns,
			'dependencies' => $dependencies,
		];
	}

	// ─────────────────────────────────────────────────────────────────────────
	// APPLY NESTED FILTERS
	// ─────────────────────────────────────────────────────────────────────────

	private function _applyNestedFilters(string $query) : string
	{
		if (is_array($this->_additionalParameters) && count($this->_additionalParameters) >= 1)
		{
			foreach ($this->_additionalParameters as $parameter => $value)
			{
				$token = "{" . $parameter . "}";

				switch ($token)
				{
					case "{code-list}":
						if ($value != '')
						{
							$codeList = $this->_parseList($value);
							if (!empty($codeList))
							{
								$escaped = implode(", ", array_map(fn($v) => DB::getPdo()->quote($v), $codeList));
								$value   = " and code_pro in ({$escaped}) ";
							}
							$query = str_replace("{code-list}", $value, $query);
						}
						break;

					case "{id-list}":
						$idList = $this->_parseList($value);
						if (!empty($idList))
						{
							$escaped = implode(", ", array_map('intval', $idList));
							$query = str_replace("{id-list}",         " and id_pro in ({$escaped}) ",          $query);
							$query = str_replace("{id-list-inc}",     " and project_id_inc in ({$escaped}) ",  $query);
							$query = str_replace("{id-list-inc-t1}",  " and t1.project_id_inc in ({$escaped}) ", $query);
							$query = str_replace("{id-list-lad}",     " and project_id_lad in ({$escaped}) ",  $query);
							$query = str_replace("{id-list-msu}",     " and project_id_msu in ({$escaped}) ",  $query);
							$query = str_replace("{id-list-psl}",     " and project_id_psl in ({$escaped}) ",  $query);
						}
						break;
				}
			}
		}

		// Limpiar tokens no reemplazados
		$query = preg_replace("/\{[^}]+\}/", "", $query);
		return $query;
	}

	// ─────────────────────────────────────────────────────────────────────────
	// HELPERS
	// ─────────────────────────────────────────────────────────────────────────

	/**
	 * Convierte un string de lista (separado por espacios o saltos de línea) en array
	 */
	private function _parseList(string $value) : array
	{
		$value = str_replace("\r\n", " ", $value);
		$value = str_replace(" ", PHP_EOL, $value);
		$list  = explode(PHP_EOL, $value);
		return array_values(array_filter($list));
	}
}