<?php

class BBCode {
	
	public static function show($text) {
		$text = preg_replace('#\[b\](.*?)\[/b\]#si','<b>$1</b>', $text);
		$text = preg_replace('#\[u\](.*?)\[/u\]#si','<u>$1</u>', $text);
		$text = preg_replace('#\[i\](.*?)\[/i\]#si','<i>$1</i>', $text);
		$text = preg_replace('#\[list\](.*?)\[/list\]#si','<ul>$1</ul>', $text);
		$text = preg_replace('#\[list=1\](.*?)\[/list\]#si','<ol>$1</ol>', $text);
		$text = preg_replace('#\[img\](.*?)\[/img]#si','<img src="$1" alt="Obrazek"/>', $text);
		$text = preg_replace('#\[\*\](.*?)\[/\*\]#si','<li>$1</li>', $text);
		$text = preg_replace('#\[font size="(.*?)"\](.*?)\[/font\]#si','<span style="font-size: $1em">$2</span>', $text);
		$text = preg_replace('#\[size=(.*?)\](.*?)\[/size\]#si','<font size="$1">$2</font>', $text);
		$text = preg_replace('#\[color=(.*?)\](.*?)\[/color\]#si','<span style="color: $1">$2</span>', $text);
		$text = preg_replace('#\[h1\](.*?)\[/h1\]#si','<h1>$1</h1>', $text);
		$text = nl2br($text);
		return $text;
	}
}
