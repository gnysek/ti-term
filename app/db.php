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

			try {
//				self::$_conn = new PDO('java:comp/env/ttDB');
				self::$_conn = new PDO('mysql:host=localhost;dbname=titag', 'root');
			} catch (PDOException $e) {
				Error::t('Nie można połączyć z PDO ' . $e->getMessage());
				return FALSE;
			}

			if (!self::$_conn) {
				Error::t('Nie można połączyć z PDO');
				return FALSE;
			}
		}
	}

	public static function connected() {
		return (bool) self::$_conn;
	}

	public static function query($sql) {
		$result = self::$_conn->query($sql);
		if (!$result) {
			Error::t('Pusta tabela?');
			return NULL;
		} else {
			return $result;
		}
	}

	public static function close() {
		self::$_conn = NULL;
	}

	public static function protect($str) {
		$str = str_replace("'", "''", $str);
		$str = str_replace('\\', '\\\\', $str);

		return $str;
	}

}