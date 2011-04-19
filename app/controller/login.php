<?php

class LoginController extends Controller {

	public function defaultAction() {
		$this->view->render('login-form');
	}

	public function authAction() {
		if (!empty($_POST['login-name'])) {
			$name = DB::protect($_POST['login-name']);
			$pass = md5($_POST['login-pass']);
			$result = DB::query("SELECT * FROM users WHERE name = '$name' AND pass = '$pass';");
			
			if ($result->count()) {
				// logowanie
			} else {
				$this->view->render('login-form',array('error'=>'Nieprawidłowy login lub hasło'));
			}
		}
	}

}
