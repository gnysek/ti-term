<?php

/**
 * Klasa do odczytu ciastek
 *
 * @version 0.1
 * @author gnysek
 */
class Cookie {

	/**
	 * @var	string	Sól do zabezpieczania ciastek przed hackowaniem
	 */
	private $salt = 'qwerty';
	/**
	 * @var string	Domena ciastek
	 */
	public $domain = NULL;
	/**
	 * @var string	Ścieżka ciastek
	 */
	public $path = '/';

	/**
	 * Konstruktor klasy, pozwala zmienić defaultowe opcje
	 * @param	array	$cfg	Opcjonalna konfiguracja ('domain', 'path', 'salt')
	 */
	public function __construct(array $cfg = array()) {
		if (!empty($cfg)) {
			if (!empty($cfg['domain']))
				$this->domain = $cfg['domain'];
			if (!empty($cfg['path']))
				$this->path = $cfg['path'];
			if (!empty($cfg['key']))
				$this->salt = $cfg['key'];
		} else {
			$this->domain = HMT::cfg()->cookie_domain;
			$this->path = HMT::cfg()->cookie_path;
			$this->salt = HMT::cfg()->cookie_key;
		}
	}

	/**
	 * Ustawia ciacho
	 * @param	string	$name		Nazwa ciacha
	 * @param	string	$value		Wartość ciacha
	 * @param	int		$expire		Czas wygasania (0 = tylko sesja)
	 * @param	boolean	$secure		Czy ciastko jest ustawiane dla https://
	 * @param	boolean	$httponly	Czy ciastko ma być dostępne tylko dla przeglądarki, bez JS itp.
	 * @return	boolean
	 */
	public function set($name, $value, $expire = 0, $secure = FALSE, $httponly = FALSE) {
//		setcookie($name, $this->salt($name, $value) . '#' . $value, time() + $expire, $this->path, $this->domain, $secure, $httponly);
		setcookie($name, base64_encode($this->salt($name, $value) . '#' . $value), time() + $expire, $this->path, $this->domain, $secure, $httponly);
		return TRUE;
	}

	/**
	 * Pobiera wartość ciacha
	 * @param	string	$name		Nazwa ciacha
	 * @param	string	$defValue	Domyślna wartość
	 * @return	boolean
	 */
	public function get($name, $defValue = NULL) {
		if (!empty($_COOKIE[$name]) && strstr($_COOKIE[$name], '#')) {
//			list($oldSalt, $value) = explode('#', $_COOKIE[$name], 2);
			list($oldSalt, $value) = explode('#', base64_decode($_COOKIE[$name]), 2);
			return ($oldSalt === $this->salt($name, $value)) ? $value : $defValue;
		}

		return $defValue;
	}

	/**
	 * Kasuje ciacho
	 * @param	string	$name		Nazwa ciacha
	 * @return boolean
	 */
	public function delete($name) {
		return $this->set($name, NULL, time() - 3600);
	}

	/**
	 * Generuje sól
	 * @param	string	$name		Nazwa ciacha
	 * @param	string	$value		Wartość ciacha
	 * @return	string				Zwraca sól SHA1
	 */
	private function salt($name, $value) {
		$agent = isset($_SERVER['HTTP_USER_AGENT']) ? strtolower($_SERVER['HTTP_USER_AGENT']) : 'none';
		return sha1($agent . $name . $value . $this->salt);
	}

}