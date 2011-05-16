<h1>Lista istniejących prezentacji</h1>

<?php foreach ($pp as $v): ?>
	<h2>&bull; <a href="<?php echo $this->request->getUrl('show/viewpp', array('id' => $v->id)); ?>"><?php echo $v->name; ?></a>
		<?php if ($v->user == $uid): ?>
			<a class="slide-del" href="<?php echo Core::request()->getUrl('pp/edit', array('id' => $v->id)); ?>"><img src="<?php echo Core::request()->getHost(); ?>media/img/pencil.png"/></a>
			<a class="slide-del" href="<?php echo Core::request()->getUrl('remote/create', array('id' => $v->id)); ?>">Utwórz zdalną prezentację</a>
			<?php endif; ?>
	</h2>
<?php endforeach; ?>
