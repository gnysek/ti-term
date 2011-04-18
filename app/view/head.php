<!DOCTYPE HTML>
<html>
<head>
<title>HTML5</title>
<script src="http://code.jquery.com/jquery-1.5.2.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="media/style.css">
<meta charset="UTF-8">
</head>

<body>
	
<div id="main">
	<div class="menu">
		<ul>
			<li><a href="<?php echo Core::request()->getUrl('index'); ?>">Strona główna</a></li>
			<li><a href="<?php echo Core::request()->getUrl('list'); ?>">Lista prezentacji</a></li>
			<li><a href="<?php echo Core::request()->getUrl('pp/create'); ?>">Nowa prezentacja</a></li>
			<li><a href="<?php echo Core::request()->getUrl('login'); ?>">Logowanie</a></li>
			<li><a href="<?php echo Core::request()->getUrl('help'); ?>">Pomoc</a></li>
		</ul>
	</div>
	<div class="clearfix"></div>
