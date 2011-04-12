<?php

class Controller {

	// czy wypluwac HTML
	protected $_output = TRUE;
	/**
	 * @var View klasa widoku
	 */
	public $view = NULL;

	public function __construct() {
		$this->view = Core::load('View');
	}

	public function _renderHead() {
		$this->view->render('head');
	}

	public function defaultAction() {
		$this->view->render('default');
		DB::query("SELECT * FROM config;");
	}

	public function _renderFooter() {
		$this->view->render('footer');
	}

}