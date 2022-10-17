<?php
namespace App\CustomLibraries;

class MaterialSummaryPaginationHandler2 extends BasePaginationHandler
{
	const TABLE_NAME = "material_summary";
	const TABLE_ID = "id_mat";
	const ATTRIB_SUFIX = "_mat";

	public function __construct(int $limit = 100, int $offset = 0, string $orderBy = "", string $orderType = 'asc', string $textToSearch = "", array $colsArray = array())
	{
		parent::__construct($limit, $offset, $orderBy, $orderType, $textToSearch, $colsArray);
	}

	/**
	 * This method return the master detail table
	 * @return string
	 */
	protected function _coreQuery() : string
	{
		return "
			(
				SELECT
					code_pro,
					mat_materials_summary.project_id_msu,
					id_mat,
					description_mat,
					mat_materials_summary.id_msu,
					mat_materials_summary_types.name_mqt,
					mat_materials_summary_types.keyword_mqt
				FROM
					mat_materials
				LEFT JOIN mat_projects_materials on mat_projects_materials.material_id_prm = id_mat
				LEFT JOIN mat_materials_summary on materials_summary_id_prm = mat_materials_summary.id_msu
				LEFT JOIN wfl_projects on id_pro = project_id_msu
				LEFT JOIN mat_materials_summary_types on id_mqt = summary_type_id_msu
				where 
					project_id_msu = 2495
					and mat_projects_materials.deleted_prm != 1
					and mat_projects_materials.deleted_at is null
					and mat_materials_summary.deleted_msu != 1
					and mat_materials_summary.deleted_at is null
					and wfl_projects.deleted_pro != 1
					-- and 
					and mat_materials_summary_types.deleted_mqt != 1
					and mat_materials_summary_types.deleted_at is null
				order by id_msu, keyword_mqt, id_mat
			) ".static::TABLE_NAME."
		";
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
	 * @param string $summaryTypeId
	 * @return string
	 */
	private function _subQueryQuantity(string $summaryTypeId, $reservationNumber = TRUE, $project = TRUE, $summaryStatus = "") : string
	{
		$reservationNumberFilter = "";
		//Include reservation number filter if the summary type is materials_initial_list, materials_additional_list, materials_picked_up_from_cre, materials_delivered_to_cre
		if($reservationNumber && in_array($summaryTypeId,[1,2,3,8]))
			$reservationNumberFilter = " {reservation-number} ";

		$projectFilter = "";
		if($project)
			$projectFilter = " {project-id} ";


		$summaryStatusFilter = "";
		if(is_numeric($summaryStatus))
			$summaryStatusFilter = " and status_id_msu = ".$summaryStatus;

		return "
		SELECT
			sum(quantity_prm) quantity,
			material_id_prm material_id,
			project_id_msu project_id
		FROM
			mat_projects_materials
		LEFT JOIN mat_materials_summary on materials_summary_id_prm = id_msu
		where 
			summary_type_id_msu in ({$summaryTypeId})
			{$projectFilter}
			{$reservationNumberFilter}
			{$summaryStatusFilter}
			and deleted_msu != 1
			and deleted_prm != 1
		GROUP BY {grouping-criteria}
		";
	}

	/**
	 * Handle the additional parameters.
	 * @return string
	 */
	protected function _additionalParameters() : string
	{
		$sql = "";
		if(is_array($this->_additionalParameters) && count($this->_additionalParameters) >= 1)
		{
			foreach($this->_additionalParameters as $parameter => $value)
			{
				switch ($parameter)
				{
					case "id":
						if($value != "")
							$sql .= " and ".static::TABLE_ID." = ".$value;
						break;
				}
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
			$list[] = array(
				"id" => "id",
				"text" => "text"
			);
		}

		$moreResults = ($page * $this->_limit) < $recordsFiltered;
		$resultArray['list'] = $list;
		$resultArray['pagination'] = array("more" => $moreResults);
		return $resultArray;
	}
}
