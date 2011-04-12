<?php

class Sql {
	const TYPE_SELECT = 1;
	const TYPE_UPDATE = 2;
	const TYPE_DELETE = 3;
	const TYPE_INSERT = 4;
	const TYPE_REPLACE = 5;

	private $_type = 0;
	private $_select = '';
	private $_from = '';
	private $_where = '';
	private $_from = '';
	private $_join = '';
	private $_leftJoin = '';
	private $_group = '';
	private $_order = '';
	private $_limit = '';
	private $_sqlPrepared = FALSE;
	private $_finalSql = '';

	private function _prepareSql() {
		if ($this->_sqlPrepared)
			return $this;

		switch ($this->_type) {
			case SELECT:
				$this->_finalSql .= 'SELECT ' . ((empty($this->_select)) ? '*' : $this->_select)
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

	public function select() {
		
	}

	public function from($from) {
		$this->_from = $from;
		return $this;
	}

	public function load() {
		// jeśli nie wiadomo skąd pobieramy, to jak w ogóle cokolwiek pobrać ?
		if (empty($this->_from)) {
			trigger_error('Nie podano tabeli, nie mozna wykonac zapytania.');
		}

		$this->_prepareSql();

		return DB::query($this->_finalSql);
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
		// zamienia SELECT * na SELECT COUNT(*)
		return $this;
	}

}
