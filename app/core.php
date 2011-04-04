<?php

class Core {

	private static $_init = FALSE;

	public static function start() {
		if (self::$_init == FALSE) {
			self::$_init = TRUE;
		} else {
			// definicja podstawowych ustawien
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

}