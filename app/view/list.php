<h1>Lista istniejących prezentacji</h1>

<?php foreach ($pp as $v): ?>
	<h2><?php echo $v->name; ?>
	<?php if ($v->user == $uid): ?>
		<a class="slide-del" href="<?php echo Core::request()->getUrl('pp/edit', array('id' => $v->id)); ?>"><img src="<?php echo Core::request()->getHost(); ?>media/img/pencil.png"/></a>
	<?php endif; ?>
	</h2><br/>
<?php endforeach; ?>
