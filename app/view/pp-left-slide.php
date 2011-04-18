<?php $i = 0;
foreach ($slajdy as $v): ?>
	<img src="<?php echo Core::request()->getHost(); ?>media/img/layer_edit.png"/>
	<?php echo++$i; ?>.
	<a class="slide-del" href="<?php echo Core::request()->getUrl('pp/delslide', array('id' => $id, 'slid' => $v->id)); ?>"><img src="<?php echo Core::request()->getHost(); ?>media/img/delete.png"/></a>
	<br/>

<?php endforeach; ?>
