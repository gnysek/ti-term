<?php

/**
 * Cache
 * @author piotr.gnys
 * @version 0.1
 */
class Cache {

	/**
	 * Przechowuje aktualny czas unixa
	 * @var type 
	 */
	public $cacheTime = 0;
	/**
	 * Sciezka cache
	 * @var string ROOT/media/cache/
	 */
	public $cachePath = '';
	
	const HOUR = 3600;
	const DAY = 86400;
	const WEEK = 604800;
	const MONTH = 2629743;

	/**
	 * Ustawia aktualny czas
	 */
	public function __construct() {
		$this->cachePath = ROOT . 'media' . DS . 'cache' . DS;
		$this->cacheTime = time();
	}

	/**
	 * Ustawia sciezke cache po ROOT/media/
	 * @param string $new sciezka po ROOT/media/
	 */
	public function cachePath($new) {
		$this->cachePath = ROOT . 'media' . DS . $new;
	}

	/**
	 * Zapisuje do cache
	 * @param type $plik
	 * @param type $tresc
	 * @return type 
	 */
	public function saveCache($plik, $tresc) {
		if (!file_exists($this->cachePath . $plik)) {
			$f = fopen($this->cachePath . $plik, 'w');
			fclose($f);
		}
		file_put_contents($this->cachePath . $plik, $tresc);
		return true;
	}

	/**
	 * Wczytuje cache
	 * @param type $plik
	 * @param type $default
	 * @return type 
	 */
	public function loadCache($plik, $default = '') {
		if (file_exists($this->cachePath . $plik)) {
			return file_get_contents($this->cachePath . $plik);
		} else {
			return ($default === '') ? '[Pobrany cache jest pusty]' : $default;
		}
	}

	/**
	 * Sprawdza czas ostatniej modyfikacji
	 * @param type $plik
	 * @param type $check
	 * @param type $distance
	 * @return type 
	 */
	public function lastMtime($plik, $check = false, $distance = 0) {
		$wynik = 0;

		if (file_exists($this->cachePath . $plik)) {
			$wynik = filemtime($this->cachePath . $plik);
		}
		// zwróc wynik, jeżeli sekund nie podano
		if ($check == false) {
			return $wynik;
		}
		// zwróć czy plik jest starszy czy nowszy
		if ($wynik > ($this->cacheTime - $distance)) {
			return true;
		} else {
			return false;
		}
	}
	
	public function isFresh($file, $time) {
		return $this->lastMtime($file, TRUE, $time);
	}
	

	/**
	 * Sprawdza, czy cache istnieje
	 * @param type $plik
	 * @return type 
	 */
	public function findCache($plik) {
		return file_exists($this->cachePath . $plik);
	}

	/**
	 * Usuwa plik cache
	 * @param type $plik
	 * @return type 
	 */
	public function deleteCache($plik) {
		if (file_exists($this->cachePath . $plik)) {
			unlink($this->cachePath . $plik);
		}
		return true;
	}
	
	/**
	 * Tworzy katalog do zapisu cache
	 * @param string $dir 
	 */
	public function createCacheDir($dir) {
		if (!file_exists($this->cachePath . str_replace('/', '', $dir))) {
			mkdir($this->cachePath . str_replace('/', '', $dir));
		}
		return TRUE;
	}

}
