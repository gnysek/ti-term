<?php

class Session {

	public $logged = FALSE;
	public $key = FALSE;
	public $userId = False;
	public $startTime = 0;
	public $lastTime = 0;

	public function __construct() {
		// sprawdz czy istnieje sesja tego usera (ciacho!)
		if ($cookie = Core::cookie()->get('pp_sid', NULL)) {
			$result = DB::query("SELECT * FROM sessions ORDER BY last_time");
		} else {
			// utwórz nową sesję
		}
	}

	public function login($user, $pass) {
		
	}

	public function logout() {
		
	}

	public function register($user, $pass, $email) {
		
	}

}