<?php $i = 0; /* @var $this View */
foreach ($slajdy as $v): ?>
	<a href="<?php echo $this->request->getUrl('pp/edit', array('id' => $id, 'slid' => $v->id)); ?>"><img src="<?php echo Core::request()->getHost(); ?>media/img/layer_edit.png"/></a>
	<?php echo++$i; ?>.
	<a class="slide-del" href="<?php echo Core::request()->getUrl('pp/delslide', array('id' => $id, 'slid' => $v->id)); ?>"><img src="<?php echo Core::request()->getHost(); ?>media/img/delete.png"/></a>
	<br/>

<?php endforeach; ?>
