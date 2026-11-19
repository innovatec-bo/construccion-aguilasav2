<?php
namespace App\CustomLibraries;

use Illuminate\Support\Facades\DB;

class BasePaginationHandler
{
	const TABLE_NAME = "";
	const TABLE_ID = "";
	const ATTRIB_SUFIX = "";

	/**
	 * @var int
	 */
	protected int $_limit;
	/**
	 * @var int
	 */
	protected int $_offset;
	/**
	 * @var string
	 */
	protected string $_orderBy;
	/**
	 * @var string
	 */
	protected string $_orderType;
	/**
	 * @var array
	 */
	protected array $_colsArray;
	/**
	 * @var array
	 */
	protected array $_additionalParameters;
	/**
	 * @var string
	 */
	protected string $_textToSearch;

	protected bool $_returnAsObjectCollection;

	public function __construct(int $limit = 100, int $offset = 0, string $orderBy = "", string $orderType = 'asc', string $textToSearch = "", array $colsArray = array())
	{
		$this->_limit = $limit;
		$this->_offset = $offset;
		$this->_orderBy = $orderBy;
		$this->_orderType = $orderType;
		$this->_textToSearch = $textToSearch;
		$this->_colsArray = $colsArray;
		$this->_additionalParameters = array();
		$this->_returnAsObjectCollection = TRUE;
	}

	/**
	 * @param array $additionalParameters
	 * @return void
	 */
	public function setAdditionalParameters(array $additionalParameters) : void
	{
		$this->_additionalParameters = array_merge($this->_additionalParameters, $additionalParameters);
	}

	/**
	 * @param bool $flag
	 */
	public function setReturnAsObjectCollection(bool $flag = TRUE) : void
	{
		$this->_returnAsObjectCollection = $flag;
	}

	/**
	 * @return int
	 */
	public function countAll() : int
	{
		// count(distinct) para que coincida con el "group by TABLE_ID" de getAll/search
		$sql = '
                select count(distinct ' . static::TABLE_ID . ') as total
                from ' . $this->_coreQuery() . ' where 1=1 ' . $this->_additionalParameters();

		return (int)DB::select($sql)[0]->total;
	}

	/**
	 * @return array
	 */
	public function getAll() : array
	{
		$sql = 'select ' . $this->_dataTableColumns() . ' from ' . $this->_coreQuery() . '
				where
				1 = 1
				' . $this->_additionalParameters() . '
                group by ' . static::TABLE_ID . ' order by ' . $this->_orderClause()
				. ' limit ' . (int)$this->_limit . ' offset ' . (int)$this->_offset;

		return $this->_fetch($sql);
	}

	/**
	 * @return array
	 */
	public function search() : array
	{
		$sql = 'select ' . $this->_dataTableColumns() . ' from ' . $this->_coreQuery() . '
			 where 1=1 ' . $this->_searchCondition() . $this->_additionalParameters()
			. ' group by ' . static::TABLE_ID
			. ' order by ' . $this->_orderClause()
			. ' limit ' . (int)$this->_limit . ' offset ' . (int)$this->_offset;

		return $this->_fetch($sql);
	}

	/**
	 * @return int
	 */
	public function searchTotalCount() : int
	{
		$sql = 'select count(distinct ' . static::TABLE_ID . ') as total from ' . $this->_coreQuery() . '
			 where 1=1 ' . $this->_searchCondition() . $this->_additionalParameters();

		return (int)DB::select($sql)[0]->total;
	}

	/**
	 * Ejecuta el SQL y devuelve objetos o arreglos segun _returnAsObjectCollection.
	 * @param string $sql
	 * @return array
	 */
	protected function _fetch(string $sql) : array
	{
		$results = DB::select($sql);
		if ($this->_returnAsObjectCollection)
		{
			return $results;
		}

		foreach ($results as $key => $value)
		{
			$results[$key] = (array)$value;
		}
		return $results;
	}

	/**
	 * Literal SQL escapado.
	 * @param mixed $value
	 * @return string
	 */
	protected function _quoteValue($value) : string
	{
		return (string)DB::getPdo()->quote((string)$value);
	}

	/**
	 * Condicion de busqueda de texto sobre _colsArray. Vacia si no hay texto ni columnas.
	 * Compartida por search() y searchTotalCount() para que los conteos coincidan.
	 * El texto se escapa y los comodines LIKE (% _) del usuario se toman como texto literal.
	 * @return string
	 */
	protected function _searchCondition() : string
	{
		if ($this->_textToSearch === "")
			return "";

		// solo columnas/alias simples
		$cols = array_filter($this->_colsArray, function ($col) {
			return is_string($col) && preg_match('/^[A-Za-z_][A-Za-z0-9_.]*$/', $col);
		});
		if (count($cols) === 0)
			return "";

		$like = str_replace(array('!', '%', '_'), array('!!', '!%', '!_'), $this->_textToSearch);
		$quoted = $this->_quoteValue('%' . $like . '%');

		$conditions = array();
		foreach ($cols as $col)
		{
			$conditions[] = $col . " like " . $quoted . " ESCAPE '!'";
		}
		return ' and (' . implode(' or ', $conditions) . ') ';
	}

	/**
	 * ORDER BY validado (columna/alias simple + asc|desc). Cae en TABLE_ID si no es valido.
	 * _orderBy puede venir de una propiedad publica de Livewire (manipulable desde el navegador).
	 * @return string
	 */
	protected function _orderClause() : string
	{
		$orderBy = preg_match('/^[A-Za-z_][A-Za-z0-9_.]*$/', $this->_orderBy) ? $this->_orderBy : static::TABLE_ID;
		$orderType = strtolower($this->_orderType) === 'desc' ? 'desc' : 'asc';
		return $orderBy . ' ' . $orderType;
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
					" . static::TABLE_NAME . ".*
				FROM
					" . static::TABLE_NAME . "
				GROUP BY " . static::TABLE_ID . "
			) " . static::TABLE_NAME . "_master_detail
		";
	}

	/**
	 * This method define the columns that will be used from _coreQuery
	 * @return string
	 */
	protected function _dataTableColumns() : string
	{
		return static::TABLE_NAME . ".*";
	}

	/**
	 * Handle the additional parameters.
	 * @return string
	 */
	protected function _additionalParameters() : string
	{
		return "";
	}

	/**
	 * Return the single data to draw the jquery data table
	 * @return array
	 */
	public function getResponseForDataTable() : array
	{
		$recordsTotal = $this->countAll();
		$recordsFiltered = $recordsTotal;
		if ($this->_textToSearch === "")
		{
			$resultArray = $this->getAll();
		}
		else
		{
			$resultArray = $this->search();
			$recordsFiltered = $this->searchTotalCount();
		}
		$result['recordsTotal'] = $recordsTotal;
		$result['recordsFiltered'] = $recordsFiltered;
		$result['resultArray'] = $resultArray;
		return $result;
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

	protected static function notDeleted()
	{
		return " deleted" . static::ATTRIB_SUFIX . " != 1 ";
	}
}