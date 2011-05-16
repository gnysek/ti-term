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
	/**
	 * @var Session
	 */
	public $session = FALSE;

	public function __construct() {
		$this->view = Core::load('View');
		$this->request = Core::request();
		$this->session = Core::session();
//		$this->view->controller = $this;
	}

//	public function _renderHead() {
//		$this->view->render('head');
//	}

	public function defaultAction() {
		$result = DB::sql()->from('remote')->join('pp', 'remote_pp = id')->load();

		$this->view->render('default', array('result' => $result));
	}

	public function _renderFooter() {
		if ($this->ajax)
			return;
		$this->view->render('footer');
	}

	public function accessDenied() {
//		$this->view->render('login-form');
		$this->request->redirect('login');
	}

}