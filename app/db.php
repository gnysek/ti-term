<?php

class DB {

	private static $_init = FALSE;
	/**
	 * @var PDO
	 */
	private static $_conn = FALSE;

	public static function connect() {
		if (!self::$_init) {
			self::$_init = TRUE;
			
			self::$_conn = new PDO('java:comp/env/ttDB');
			
			if (!self::$_conn) {
				trigger_error('Nie można połączyć z PDO');
			}
		}
	}
	
	public static function query($sql) {
		$result = self::$_conn->query($sql);
		if (!$result) {
			trigger_error("Pusta tabela?");
		}
		return $result;
	}
	
	public static function close() {
		self::$_conn = NULL;
	}

}