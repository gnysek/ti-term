<h1>Lista istniejących prezentacji</h1>


<?php foreach ($pp as $v): ?>
	<?php echo $v->name; ?>
	<a class="slide-del" href="<?php echo Core::request()->getUrl('pp/edit', array('id' => $v->id)); ?>"><img src="<?php echo Core::request()->getHost(); ?>media/img/pencil.png"/></a>
	<br/>
<?php endforeach; ?>
