<?php

if (get_magic_quotes_gpc()) {

	/**
	 * Disable magic quotes in runtime if needed
	 *
	 * @link http://us3.php.net/manual/en/security.magicquotes.disabling.php
	 */
	function undoMagicQuotes($array, $topLevel=true) {
		$newArray = array();
		foreach ($array as $key => $value) {
			if (!$topLevel) {
				$newKey = stripslashes($key);
				if ($newKey !== $key) {
					unset($array[$key]);
				}
				$key = $newKey;
			}
			$newArray[$key] = is_array($value) ? undoMagicQuotes($value, false) : stripslashes($value);
		}
		return $newArray;
	}

	$_GET = undoMagicQuotes($_GET);
	$_POST = undoMagicQuotes($_POST);
	$_COOKIE = undoMagicQuotes($_COOKIE);
	$_REQUEST = undoMagicQuotes($_REQUEST);
}