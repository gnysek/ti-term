<!DOCTYPE HTML>
<html>
	<head>
		<title>HTML5</title>
		<script src="http://code.jquery.com/jquery-1.5.2.min.js" type="text/javascript"></script>
		<?php foreach ($this->js as $js): ?>
			<script src="<?php echo $js ?>" type="text/javascript"></script>
		<?php endforeach; ?>
		<link rel="stylesheet" type="text/css" href="media/style.css"/>
		<?php foreach ($this->css as $css): ?>
		<link rel="stylesheet" type="text/css" href="<?php echo $css ?>"/>
		<?php endforeach; ?>
		<meta charset="UTF-8">
	</head>

	<body>

		<div id="main">
			<div class="menu">
				<ul>
					<li><a href="<?php echo Core::request()->getUrl('index'); ?>">Strona główna</a></li>
					<li><a href="<?php echo Core::request()->getUrl('list'); ?>">Lista prezentacji</a></li>
					<li><a href="<?php echo Core::request()->getUrl('pp/create'); ?>">Nowa prezentacja</a></li>
					<?php if (Core::session()->logged == false): ?>
						<li><a href="<?php echo Core::request()->getUrl('login'); ?>">Logowanie</a></li>
					<?php else: ?>
						<li><a href="<?php echo Core::request()->getUrl('login/logout'); ?>">Wyloguj (<?php echo Core::session()->userData->name; ?>)</a></li>
					<?php endif; ?>
					<li><a href="<?php echo Core::request()->getUrl('help'); ?>">Pomoc</a></li>
				</ul>
			</div>
			<div class="clearfix"></div>
