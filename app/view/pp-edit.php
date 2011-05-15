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
		
        $("#slideData").cleditor({
			colors:
				// kolory w selectboxie
				"FFF FCC FC9 FF9 FFC 9F9 9FF CFF CCF FCF " +
				"CCC F66 F96 FF6 FF3 6F9 3FF 6FF 99F F9F " +
				"BBB F00 F90 FC6 FF0 3F3 6CC 3CF 66C C6C " +
				"999 C00 F60 FC3 FC0 3C0 0CC 36F 63F C3C " +
				"666 900 C60 C93 990 090 399 33F 60C 939 " +
				"333 600 930 963 660 060 366 009 339 636 " +
				"000 300 630 633 330 030 033 006 309 303",
			width: 740,
			height: 350
		});
		
		$('#slide-data-form').submit(function(){
			$('#slideData').cleditor()[0].updateTextArea();
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
		<a href="<?php echo Core::request()->getUrl('pp/addslide', array('id' => $data->id)); ?>"><img src="<?php echo Core::request()->getHost(); ?>media/img/layer_add.png"/></a>
		Dodaj slajd
	</div>

</div>
<div class="right-page">
	<div class="custom-tabs" style="width: 733px;">
		<ul class="custom-tabs">
			<li class="active"><a href="#aktualny">Aktualny slajd</a></li>
		</ul>
	</div>
	<div class="clearfix"></div>
	<?php
	//znajdź obecny slajd
	$obecny = $slajdy->get(0);
	if ($slajdObecny > 0) {
		foreach ($slajdy as $s) {
			if ($s->id == $slajdObecny) {
				$obecny = $s;
			}
		}
	}
	?>
	<?php echo $this->render('pp-textarea', array('obecny' => $obecny)); ?>
</div>
<div class="clearfix"></div>

<input id="token" type="hidden"/>
