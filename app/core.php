<?php

class Core {

	private static $_init = FALSE;
	private static $_loadedClass = array();

	public static function start() {
		if (self::$_init == FALSE) {
			// definicja podstawowych ustawien
			self::$_init = TRUE;
			self::request();
			echo self::request()->getController();
			echo '<br/>';
			echo self::request()->getResuestString();
		}
	}

	public static function route() {
		// znajdz kontroler do odpalenia
		// zaladuj kontroler
		// dispatch
		// koniec aplikacji
		self::end();
	}

	public static function stop() {
		//przerywa działanie (krytyczne)
	}

	public static function end() {
		// konczy dzialanie
	}

	/**
	 * Wczytuje klasę do rejestru
	 * @param string $class
	 * @return mixed 
	 */
	public static function load($class) {
		if (!array_key_exists(($class), self::$_loadedClass)) {
			self::$_loadedClass[$class] = new $class();
		}
		return self::$_loadedClass[$class];
	}

	/**
	 * Klasa zajmująca się przetwarzaniem zapytania i tworzeniem URLi
	 * @return Request
	 */
	public function request() {
		return self::load('Request');
	}

}