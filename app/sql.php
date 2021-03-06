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
	private $_size = 0;

	/**
	 * Przygotowuje string z SQLem
	 * @return Sql 
	 */
	private function _prepareSql() {
		if ($this->_sqlPrepared)
			return $this;

		switch ($this->_type) {
			case self::TYPE_SELECT:
				$this->_finalSql = 'SELECT ' . ((empty($this->_columns)) ? '*' : implode(',', $this->_columns))
					. ' FROM ' . $this->_from;
				if (!empty($this->_where))
					$this->_finalSql .= ' WHERE ' . $this->_where;
				if (!empty($this->_join))
					$this->_finalSql .= ' JOIN ' . $this->_join;
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
				$this->_finalSql .= ( (empty($this->_columns)) ? '' : '(' . implode(',', $this->_columns) . ') ');
				$this->_finalSql .= 'VALUES (' . implode(',', $this->_values) . ')';
				$this->_finalSql .= ';';
				break;
			case self::TYPE_UPDATE:
				$col = $this->_columns;
				$val = $this->_values;
				
				if (empty($this->_where)) {
					trigger_error('Błąd update - brakuje where');
				}

				if (count($col) != count($val)) {
					trigger_error('Błąd update - liczba kolumn i wartosci sie nie zgadza');
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
			$this->_columns = $columns;//implode(', ', $columns);
		} else {
			$this->_columns = array($columns);
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
		return $this->from($into);
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

		foreach ($values as $k => $v) {
			if ($v === NULL) {
				$v = 'NULL';
			} elseif (is_string($v)) {
				$v = '\'' . DB::protect($v) . '\'';
			}
			$values[$k] = $v;
		}
		$this->_values = $values;
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

	public function join($table, $on) {
		$this->_join = $table . ' ON ' . $on;
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
			$this->_size = $this->_collection->count();
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
	 * @return int
	 */
	public function size() {
		return $this->_size;
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
