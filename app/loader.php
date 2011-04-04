<?php

define('CORE','/app/');
define('DS',DIRECTORY_SEPARATOR);

class Loader {

	private static $_init = FALSE;

	static function start() {
		if (self::$_init) return FALSE;
		self::$_init = TRUE;
		spl_autoload_register(array(__CLASS__, 'autoload'));

		return TRUE;
	}

	static public function autoload($class) {
		// Sprawdź czy klasa juz nie istnieje
		if (class_exists($class, FALSE)) {
			return TRUE;
		}

		$file = str_replace('_', DS, strtolower($class));
		$files = array(
			CORE . $file . EXT,
		);

		// Przeszukuj
		foreach ($files as $file) {
			// Sprawdz czy plik istnieje
			if (file_exists($file)) {
				// Zaladuj plik
				require_once($file);

				// Sprawdz czy klasa istnieje w pliku
				if (class_exists($class, FALSE)) {
					return TRUE;
				} else if (interface_exists($class, FALSE)) {
					return TRUE;
				} else {
					trigger_error('Found class "' . $class . '" file (' . $file . ') but without class declaration');
					return FALSE;
				}
			}
		}

		// 404, class not found :(
		trigger_error('Unable to find class "' . $class . '" file');

		return FALSE;
	}

	static public function unload() {
		// Wyrejestruj autoloader systemowy
		spl_autoload_unregister(array(__CLASS__, 'handler'));
	}

}
