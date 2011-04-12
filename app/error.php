<?php

class Error {

	public static function t($text) {
		echo '<div class="error">';
		echo '<h2>Błąd</h2>';
		echo $text;
		echo '</div>';
	}

}