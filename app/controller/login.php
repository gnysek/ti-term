<?php

class LoginController extends Controller {

	public function defaultAction() {
		$this->view->render('login-form');
	}

	public function authAction() {
		if (!empty($_POST['login-name'])) {
			$name = DB::protect($_POST['login-name']);
			$pass = md5($_POST['login-pass']);

			$this->session->login($name, $pass);

			if ($this->session->logged) {
				// zalogowany
				$this->request->redirect('index');
			} else {
				$this->view->render('login-form', array('error' => 'Nieprawidłowy login lub hasło'));
			}
		} else {
			$this->defaultAction();
		}
	}

	public function logoutAction() {
		$this->session->logout();
		$this->defaultAction();
	}

}
