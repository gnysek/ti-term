<?php

class View {

	public function render($file) {
		$inc = APP . 'view' . DS . strtolower(str_replace('_', DS, $file)) . EXT;
		if (file_exists($inc)) {
			include $inc;
		} else {
			trigger_error('View not exists (' . $inc . ')');
		}
	}

}
