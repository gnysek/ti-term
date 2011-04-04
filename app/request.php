<?php

class Request {

	private $_params = array();

	public function __construct() {
		$this->_params = array_merge($_GET, $_POST);
	}

	public function __get($name) {
		if (!empty($this->_params)) {
			return $this->_params;
		}
		return NULL;
	}

	public function getQuery($name) {
		if (!empty($_GET[$name])) {
			return $_GET[$name];
		}
		return NULL;
	}

	public function getParam($name) {
		if (!empty($this->_params)) {
			return $this->_params;
		}
		return NULL;
	}

	public function getPost($name) {
		if (!empty($_POST[$name])) {
			return $_POST[$name];
		}
		return NULL;
	}

	public function getUrl($url) {
		return $url;
	}

	public function getResuestString() {
		return preg_replace("/[^a-z0-9.,-]/", '', (string) $this->getQuery('r'));
	}
	
	public function getController() {
		$r = preg_replace('/^([0-9])*/','', (string) $this->getQuery('r'));
		return preg_replace("/[^a-z0-9]/", '', $r);
	}

}