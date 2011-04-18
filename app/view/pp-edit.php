<h1><?php echo $data->name ?> / Edycja</h1>

<script type="text/javascript">
	var ppId = '<?php echo $data->id; ?>';
</script>

<div class="left-column">
	Lista slajdów
	<div></div>

	<div id="slide-list">
		<?php echo $this->render('pp-left-slide'); ?>
	</div>

	<div id="slide-add">
		<a href="<?php echo Core::request()->getUrl('pp/slide', array('id' => $data->id)); ?>"><img src="<?php echo Core::request()->getHost(); ?>media/img/layer_add.png"/></a>
	</div>

</div>
<div class="right-page">
	Aktualny slajd
</div>
<div class="clearfix"></div>

<input id="token"/>
