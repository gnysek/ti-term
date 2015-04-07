<?php

class Request {

	private $_params = array();
	private $_controller = NULL;
	private $_action = NULL;
	private $_requestString = NULL;
	private $_host = 'http://localhost/other/titag/';

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

	public function getHost() {
		return $this->_host;
	}

	public function getUrl($action = 'index', $additional = '') {
		$u = $this->_host . '?r=' . $action;

		if ($additional) {
			if (is_array($additional)) {
				foreach ($additional as $k => $v) {
					$u .= '&' . $k . '=' . $v;
				}
			} else {
				$u .= $additional;
			}
		}

		return $u;
	}

	public function redirect($action = 'index', $additional = '') {
		$url = $this->getUrl($action, $additional);
		header('Location: ' . $url);
		die();
	}

	public function getResuestString() {
		if ($this->_requestString === NULL) {
			$this->_requestString = preg_replace("/[^a-z0-9.,-]/", '', (string) $this->getQuery('r'));
		}
		return $this->_requestString;
	}

	public function getAction() {
		if ($this->_controller === NULL) {
			$this->getController();
		}

		return $this->_action;
	}

	public function getController() {
		if ($this->_controller === NULL) {
			$r = preg_replace('/^([0-9])*/', '', (string) $this->getQuery('r'));
			$c = explode('/', $r, 3);
			$r = preg_replace("/[^a-z0-9]/", '', $c[0]);
			$this->_controller = $r;
			if (!empty($c[1])) {
				$this->_action = preg_replace("/[^a-z0-9]/", '', $c[1]);
			}
		}
		return $this->_controller;
	}

	public function isAjax() {
		return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
		($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'));
	}

}
