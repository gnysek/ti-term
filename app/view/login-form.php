<h1>Zaloguj</h1>

<?php if (!empty($error)) {
	echo Error::t($error);
} ?>

<form action="<?php echo Core::request()->getUrl('login/auth'); ?>" method="POST">
	Nick:<br/>
	<input type="text" name="login-name"/><br/>
	Hasło:<br/>
	<input type="password" name="login-pass"/><br/>
	<input type="submit" value="Zaloguj"/>
</form>