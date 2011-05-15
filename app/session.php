<?php

class Session {

	public $logged = FALSE;
	public $key = FALSE;
	public $userId = FALSE;
	public $startTime = 0;
	public $lastTime = 0;
	public $userData = NULL;

	public function __construct() {
		$sesFound = FALSE;
		// sprawdz czy istnieje sesja tego usera (ciacho!)
		if ($cookie = Core::cookie()->get('pp_sid', NULL)) {
			$sql = new Sql();
			$sql->from('sessions')->where('sid = ?', $cookie);
			$result = $sql->load();
			if ($result->count()) {
				$r = $result->get(0);
				$this->key = $r->sid;
				$this->userId = $r->user_id;
				$this->startTime = $r->start_time;
				$this->lastTime = $r->last_time;
				if ($this->userId > 0) {
					// zalogowany
					$sql = new Sql();
					$sql->from('users')->where('user_id = ?', $this->userId);
					$result = $sql->load();
					if ($result->count()) {
						$this->userData = $result->get(0);
						$this->logged = TRUE;
					} else {
						$this->userId = -1;
						$this->logged = FALSE;
					}
				}
				$sesFound = TRUE;
			}
		}

		if ($sesFound === FALSE) {
			// utwórz nową sesję
			$this->start();
		} else {
			$this->refresh();
		}
	}

	/**
	 * Autoryzuje użytkownika
	 * @param string $user jako string
	 * @param string $pass jako MD5
	 */
	public function login($name, $pass) {
		$sql = new Sql();
		$sql->from('users')->where('name = ? AND pass = ?', $name, $pass);
		$result = $sql->load();
		if ($result->count() == 1) {
			$this->userData = $result->get(0);
			$this->userId = $this->userData->user_id;
			$this->logged = TRUE;

			$this->refresh();
		}
		return TRUE;
	}

	public function logout() {
		$this->logged = FALSE;
		$this->userId = -1;
		$this->userData = NULL;
		$this->refresh();
		return TRUE;
	}

	public function register($user, $pass, $email) {
		
	}

	public function start() {
		$key = md5(uniqid(mt_rand(), true));
		$sql = new Sql();
		$total = $sql->insert()->from('sessions')
			->columns(array('sid', 'user_id', 'start_time', 'last_time'))
			->values(array($key, -1, time(), time()))
			->execute();

		$this->key = $key;
		$this->startTime = $this->lastTime = time();

		Core::cookie()->set('pp_sid', $key);
	}

	public function refresh() {
		$sql = new Sql();
		$sql->update('sessions')
			->columns(array('last_time', 'user_id'))
			->values(array(time(), $this->userId))
			->where('sid = ?', $this->key)
			->execute();
		$this->lastTime = time();

		return TRUE;
	}

}