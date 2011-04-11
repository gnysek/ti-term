<?php

class Request {

	private $_params = array();
	private $_controller = NULL;
	private $_requestString = NULL;

	public function __construct() {
		$this->_params = array_merge($_GET, $_POST);
	}

	public function __get($name) {
		if (!empty($this->_params[$name])) {
			return $this->_params[$name];
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
		if (!empty($this->_params[$name])) {
			return $this->_params[$name];
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
		if ($this->_requestString === NULL) {
			$this->_requestString = preg_replace("/[^a-z0-9.,-]/", '', (string) $this->getQuery('r'));
		}
		return $this->_requestString;
	}

	public function getController() {
		if ($this->_controller === NULL) {
			$r = preg_replace('/^([0-9])*/', '', (string) $this->getQuery('r'));
			$this->_controller = preg_replace("/[^a-z0-9]/", '', $r);
		}
		return $this->_controller;
	}

}