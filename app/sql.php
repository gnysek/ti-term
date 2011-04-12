<?php

class Sql {
	const TYPE_SELECT = 1;
	const TYPE_UPDATE = 2;
	const TYPE_DELETE = 3;
	const TYPE_INSERT = 4;
	const TYPE_REPLACE = 5;

	private $_type = 1;
	private $_columns = '';
	private $_where = '';
	private $_from = '';
	private $_join = '';
	private $_leftJoin = '';
	private $_group = '';
	private $_order = '';
	private $_limit = '';
	// bufory
	private $_sqlPrepared = FALSE;
	private $_finalSql = '';
	private $_count = NULL;
	private $_collection = NULL;

	/**
	 * Przygotowuje string z SQLem
	 * @return Sql 
	 */
	private function _prepareSql() {
		if ($this->_sqlPrepared)
			return $this;

		switch ($this->_type) {
			case SELECT:
				$this->_finalSql .= 'SELECT ' . ((empty($this->_columns)) ? '*' : $this->_columns)
					. ' FROM ' . $this->_from;
				if (!empty($this->_where))
					$this->_finalSql .= ' WHERE ' . $this->_where;
				if (!empty($this->_group))
					$this->_finalSql .= ' GROUP BY ' . $this->_group;
				if (!empty($this->_order))
					$this->_finalSql .= ' ORDER BY ' . $this->_order;
				if (!empty($this->_limit))
					$this->_finalSql .= ' LIMIT ' . $this->_limit;
				$this->_finalSql .= ';';
		}

		return $this;
	}

	public function columns($columns) {
		if (is_array($columns)) {
			$this->_columns = implode(', ', $columns);
		} else {
			$this->_columns = $columns;
		}
	}

	public function from($from) {
		if (is_array($select)) {
			$this->_from = implode(', ', $from);
		} else {
			$this->_from = $from;
		}
		return $this;
	}

	public function load() {
		if ($this->_collection === NULL) {
			// jeśli nie wiadomo skąd pobieramy, to jak w ogóle cokolwiek pobrać ;)
			if (empty($this->_from)) {
				trigger_error('Nie podano tabeli, nie mozna wykonac zapytania.');
			}

			$this->_prepareSql();

			$this->_collection = DB::query($this->_finalSql);
		}
		
		return $this->_collection;
	}

	/**
	 * zwraca ilosc pobranych rekordów
	 * @return Sql 
	 */
	public function size() {
		return $this;
	}

	/**
	 * zwraca ilość wszystkich elementów w tym zapytaniu, nie uwzględniając LIMIT
	 * @return Sql 
	 */
	public function count() {
		if ($this->_count === NULL) {
			// zamienia SELECT * na SELECT COUNT(*)
			$count_sql = $sql = preg_replace('/select\s+.+?\s+from\s+/is', 'select count(*) as count from ', $this->_sqlPrepared);
			$result = DB::query($count_sql);
			$this->_count = $result->count;
		}

		return $this->_count;
	}

}
