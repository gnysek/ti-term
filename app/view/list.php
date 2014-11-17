<h1>Lista istniejących prezentacji</h1>

<?php foreach ($pp as $v): ?>
	<h2>&curren; <a href="<?php echo $this->request->getUrl('show/viewpp', array('id' => $v->id)); ?>"><b><?php echo $v->name; ?></b></a>
		<?php if ($v->user == $uid): ?>
			| <a class="slide-del" href="<?php echo Core::request()->getUrl('pp/edit', array('id' => $v->id)); ?>"><img src="<?php echo Core::request()->getHost(); ?>media/img/pencil.png"/> Edycja</a>
			| <a class="slide-del" href="<?php echo Core::request()->getUrl('pp/theme', array('id' => $v->id)); ?>">Zmień design</a>
			<?php if (!$v->remote_pp): ?>
			| <a class="slide-del" href="<?php echo Core::request()->getUrl('remote/create', array('id' => $v->id)); ?>">+ Utwórz zdalną prezentację</a>
			<?php else: ?>
			| <a class="slide-del" href="<?php echo Core::request()->getUrl('remote/create', array('id' => $v->id)); ?>">+ Odpal zdalną prezentację</a>
			<?php endif; ?>
			<?php if ($v->remote_pp): ?>
			| <a class="slide-del" href="<?php echo Core::request()->getUrl('remote/delete', array('id' => $v->id)); ?>">- Usuń zdalną prezentację</a>
			<?php endif; ?>
		<?php endif; ?>
	</h2>
<?php endforeach; ?>
