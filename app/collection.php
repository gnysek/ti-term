<?php

class Collection implements Iterator, Countable {

	private $_data = array();
	private $_currentRow = 0;
	private $_countRow = 0;

	public function __construct($data = NULL) {

		if ($data instanceof Data) {
			$this->push($data);
		} else if (is_array($data)) {
			foreach ($data as $value) {
				if ($value instanceof Data) {
					$this->push($value);
				}
			}
		}

		return $this;
	}

	public function count() {
		return $this->_countRow;
//		return count($this->_data);
	}

	public function push(Data $value) {
		$this->_data[] = $value;
		$this->_countRow++;

		return $this->_data[$this->_countRow - 1];
		//return end($this->_data);
	}

	public function toOptionArray($name = 'name', $value = 'value') {
		$result = array();

		foreach ($this->_data as $v) {
			$result[$v->__get($name)] = $v->__get($value);
		}

		return $result;
	}
	
	public function current() {
		return $this->_data[$this->_currentRow];
	}

	public function key() {
		return $this->_currentRow;
	}

	public function next() {
		++$this->_currentRow;
		return $this;
	}

	public function rewind() {
		$this->_currentRow = 0;
		return $this;
	}
	
	public function get($offset) {
		return ($offset >= 0 && $offset < $this->_countRow) ? $this->_data[$offset] : NULL;
	}

	public function valid() {
		$offset = $this->_currentRow;
		return ($offset >= 0 && $offset < $this->_countRow);
		//return $this->current() !== false;
	}

}
