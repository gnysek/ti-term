<?php

class BBCode {
	
	public static function show($text) {
		$text = preg_replace('#\[b\](.*?)\[/b\]#si','<b>$1</b>', $text);
		$text = preg_replace('#\[u\](.*?)\[/u\]#si','<u>$1</u>', $text);
		$text = preg_replace('#\[h1\](.*?)\[/h1\]#si','<h1>$1</h1>', $text);
		$text = nl2br($text);
		return $text;
	}
}
