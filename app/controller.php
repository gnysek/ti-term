<?php

class Controller {

	// czy wypluwac HTML
	protected $_output = TRUE;
	/**
	 * @var View klasa widoku
	 */
	public $view = NULL;
	/**
	 * @var Request
	 */
	public $request = NULL;
	public $ajax = FALSE;

	public function __construct() {
		$this->view = Core::load('View');
		$this->request = Core::request();
//		$this->view->controller = $this;
	}

//	public function _renderHead() {
//		$this->view->render('head');
//	}

	public function defaultAction() {
		$this->view->render('default');
		DB::query("SELECT * FROM config;");
	}

	public function _renderFooter() {
		if ($this->ajax)
			return;
		$this->view->render('footer');
	}

}