<h1>Dodaj prezentację</h1>

<form action="<?php echo Core::request()->getUrl('pp/create'); ?>" method="post">

	Nazwa prezentacji:<br/>
	<input type="text" name="presentation-name" class="input-half"/><br/>
	<input type="submit" value="Dalej &raquo;"/>
</form>
