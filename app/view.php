<?php

class View {

	private $_upRenreded = FALSE;
	/**
	 * @var Request
	 */
	public $request = FALSE;
	/**
	 * @var Session
	 */
	public $session = FALSE;
	public $js = array();
	public $css = array();

	public function __construct() {
		$this->request = Core::request();
		$this->session = Core::session();
	}

	public function addCss($css) {
		$this->css[] = $css;
	}

	public function addJs($js) {
		$this->js[] = $js;
	}

	public function _render($file, array $data = array()) {
		$inc = APP . 'view' . DS . strtolower(str_replace('_', DS, $file)) . EXT;
		if (file_exists($inc)) {
			if (is_array($data)) {
				foreach ($data as $___k => $___v) {
					$$___k = $___v;
				}
			}
			include $inc;
		} else {
			trigger_error('View not exists (' . $inc . ')');
		}
	}

	public function render($file, array $data = array()) {
		if (!$this->_upRenreded) {
			$this->_render('head');
			$this->_upRenreded = TRUE;
		}
		$this->_render($file, $data);
	}

	public function ajaxRender($file, array $data = array()) {
		$this->_render($file, $data);
	}

}
