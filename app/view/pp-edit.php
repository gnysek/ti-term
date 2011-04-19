<h1><?php echo $data->name ?> / Edycja</h1>

<script type="text/javascript">
	var ppId = '<?php echo $data->id; ?>';
	var token = '';
	
	$().ready(function(){
		$('#slide-add a').click(function(){
			$('#slide-list').load( $(this).attr('href') );
			$().focus();
			return false;
		});
		
		$('#slide-list .slide-del').live('click', function(){
			$('#slide-list').load( $(this).attr('href') );
			$().blur();
			return false;
		});
	});
</script>

<div class="left-column">
	Lista slajdów
	<hr/>
	<div id="slide-list">
		<?php echo $this->render('pp-left-slide', array('slajdy' => $slajdy, 'id' => $data->id)); ?>
	</div>
	<hr/>
	<div id="slide-add">
		<a href="<?php echo Core::request()->getUrl('pp/slide', array('id' => $data->id)); ?>"><img src="<?php echo Core::request()->getHost(); ?>media/img/layer_add.png"/></a>
		Dodaj slajd
	</div>

</div>
<div class="right-page">
	Aktualny slajd
	<hr/>
	<?php echo $this->render('pp-textarea', array('obecny' => $slajdy->get(0))); ?>
</div>
<div class="clearfix"></div>

<input id="token" type="hidden"/>
