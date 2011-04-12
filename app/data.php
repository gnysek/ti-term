<?php

/**
 * Przetrzymuje dane
 */
class Data implements Iterator {

	protected $_data = array();

	public function current() {
		return current($this->_data);
	}

	public function key() {
		return key($this->_data);
	}

	public function next() {
		return next($this->_data);
	}

	public function rewind() {
		return reset($this->_data);
	}

	public function valid() {
		return $this->current() !== false;
	}

	public function __construct(array $data = array()) {
		foreach ($data as $name => $value) {
			$this->__set($name, $value);
		}
	}

	public function __set($name, $value) {
		if (is_array($value)) {
			$this->_data[$name] = new Data($value);
		} else {
			$this->_data[$name] = $value;
		}
	}

	public function __get($name) {
		if (!isset($this->_data[$name])) {
			return NULL;
			//return new ErrorException("Błąd kontenera danych");
		}

		return $this->_data[$name];
	}

	public function count() {
		return count($this->_data);
	}
	
	public function push($name, $value) {
		$this->__set($name, $value);
	}
	
	public function toArray() {
		return $this->_data;
	}
	
	public function __toString() {
		return 'Data::__toString()';
	}

}