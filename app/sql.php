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
	private $_values = '';
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
			case self::TYPE_SELECT:
				$this->_finalSql = 'SELECT ' . ((empty($this->_columns)) ? '*' : $this->_columns)
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
				break;
			case self::TYPE_INSERT:
				$this->_finalSql = 'INSERT INTO ' . ($this->_from);
				$this->_finalSql .= ( (empty($this->_columns)) ? '' : '(' . $this->_columns . ') ');
				$this->_finalSql .= 'VALUES (' . $this->_values . ')';
				$this->_finalSql .= ';';
				break;
			case self::TYPE_UPDATE:
				$col = explode(',', $this->_columns);
				$val = explode(',', $this->_values);
				
				if (empty($this->_where) or count($col) != count($val)) {
					trigger_error('Błąd update - brakuje where, lub liczba kolumn i wartosci sie nie zgadza');
				}

				$set = array();
				for ($i = 0; $i < count($col); $i++) {
					$set[] = $col[$i] . ' = ' . $val[$i];
				}

				$this->_finalSql = 'UPDATE ' . ($this->_from);
				$this->_finalSql .= ' SET ' . implode(', ', $set) . '';
				$this->_finalSql .= ' WHERE ' . $this->_where;
				$this->_finalSql .= ';';
				break;
		}

		return $this;
	}

	public function insert() {
		$this->_type = self::TYPE_INSERT;
		return $this;
	}

	public function columns($columns) {
		if (is_array($columns)) {
			$this->_columns = implode(', ', $columns);
		} else {
			$this->_columns = $columns;
		}
		return $this;
	}

	public function from($from) {
		if (is_array($from)) {
			$this->_from = implode(', ', $from);
		} else {
			$this->_from = $from;
		}
		return $this;
	}

	public function into($into) {
		$this->insert();
		return $this->from($from);
	}

	public function update($where = '') {
		$this->_type = self::TYPE_UPDATE;
		if (!empty($where))
			$this->from($where);
		return $this;
	}

	public function values($values) {
		if (!is_array($values)) {
			$values = array($values);
		}
		
		$sql = array();
		foreach ($values as $v) {
			if ($v === NULL) {
				$v = 'NULL';
			} elseif (is_string($v)) {
				$v = '\'' . DB::protect($v) . '\'';
			}
			$sql[] = $v;
		}
		$this->_values = implode(', ', $sql);
		return $this;
	}

	public function where($where) {
		if (func_num_args() > 1) {
			for ($i = 1; $i < func_num_args(); $i++) {
				$var = func_get_arg($i);
				if ($var === NULL) {
					$var = 'NULL';
				} elseif (is_string($var)) {
					$var = '\'' . DB::protect($var) . '\'';
				}
				$where = preg_replace('/\?/i', $var, $where, 1);
			}
		}
		$this->_where .= $where . ' ';
		return $this;
	}

	/**
	 *
	 * @return Collection
	 */
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

	public function execute() {
		if ($this->_collection === NULL) {
			// jeśli nie wiadomo skąd pobieramy, to jak w ogóle cokolwiek pobrać ;)
			if (empty($this->_from)) {
				trigger_error('Nie podano tabeli, nie mozna wykonac zapytania.');
			}

			$this->_prepareSql();

			$total = DB::update($this->_finalSql);
		}

		return $total;
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

	public function __toString() {
		return $this->_finalSql;
	}

}
