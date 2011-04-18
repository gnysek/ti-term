<?php

class View {

	private $_upRenreded = FALSE;

	public function _render($file, array $data = array()) {
		$inc = APP . 'view' . DS . strtolower(str_replace('_', DS, $file)) . EXT;
		if (file_exists($inc)) {
			if (is_array($data)) {
				foreach ($data as $k => $v) {
					$$k = $v;
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
