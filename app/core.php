<?php

class Core
{

	private static $_init = FALSE;
	private static $_loadedClass = array();
	/**
	 * Przetrzymuje referencję na załadowany kontroler
	 *
	 * @var Controller
	 */
	private static $_controller = NULL;

	public static function start()
	{
		if (self::$_init == FALSE) {
			// definicja podstawowych ustawien
			self::$_init = TRUE;
//			self::request();
//			echo self::request()->getController();
//			echo '<br/>';
//			echo self::request()->getResuestString();
			DB::connect();
			self::session();
			self::route();
			DB::close();
		}
	}

	public static function route()
	{
		// znajdz kontroler do odpalenia
		self::request();
		// zaladuj kontroler
		$controllerFile = self::request()->getController();
		if (file_exists(APP . 'controller' . DS . strtolower($controllerFile) . EXT)) {
			include(APP . 'controller' . DS . strtolower($controllerFile) . EXT);
			self::$_controller = self::load($controllerFile . 'Controller');
		} else {
			self::$_controller = self::load('Controller');
		}
		// dispatch
//		self::$_controller->_renderHead();
		if (DB::connected()) {
			$action = strtolower(self::request()->getAction()) . 'Action';
			if (method_exists(self::$_controller, $action)) {
				self::$_controller->$action();
			} else {
				self::$_controller->defaultAction();
			}
		} else {
			Error::t('Błąd sterownika bazy danych. Kontroler nie zostanie wyświetlony');
		}
		// wyłącz stopkę dla ajaxu
		if (!self::request()->isAjax()) {
			self::$_controller->_renderFooter();
		}
		// koniec aplikacji
		self::end();
	}

	public static function stop()
	{
		//przerywa działanie (krytyczne)
	}

	public static function end()
	{
		// konczy dzialanie
	}

	/**
	 * Wczytuje klasę do rejestru
	 *
	 * @param string $class
	 *
	 * @return mixed
	 */
	public static function load($class)
	{
		if (!array_key_exists(($class), self::$_loadedClass)) {
			self::$_loadedClass[$class] = new $class();
		}
		return self::$_loadedClass[$class];
	}

	/**
	 * Klasa zajmująca się przetwarzaniem zapytania i tworzeniem URLi
	 *
	 * @return Request
	 */
	public static function request()
	{
		return self::load('Request');
	}

	/**
	 *
	 * @return Cookie
	 */
	public static function cookie()
	{
		return self::load('Cookie');
	}

	/**
	 *
	 * @return Session
	 */
	public static function session()
	{
		return self::load('Session');
	}

}
