Lista slajdów:

<div class="slajdy-div">
	<?php $i = 0; ?>
	<?php foreach ($slides as $s): ?>
		<div id="slide-pp-<?php echo $i++; ?>" class="sub-slajd">
			<?php echo $s->text; ?>
		</div>
	<?php endforeach; ?>
</div>

<script type="text/javascript">
	var totalSlides = <?php echo $i ?>;
	var currentSlide = 0;
	
	$( document ).ready( function() {
		var $body = $(document);
		var $slajd = $('#slajd-modal');
		var $window = $(window);

		function setFontScale() {
			var scaleSource = $body.height(),
			scaleFactor = 0.156,                     
			maxScale = 600,
			minScale = 30;
			var fontSize = Math.round(scaleSource * scaleFactor);

			if (fontSize > maxScale) fontSize = maxScale;
			if (fontSize < minScale) fontSize = minScale;

			$('#slajd-modal-inner').css('font-size', fontSize + '%');
		}
		
		function setModalScale() {
			var szer = $window.width(), wys = $slajd.height();
			
			if (szer * 0.75 > wys) {
				//normalnie
				szer = wys * 4/3;
			} else { //wys > szer
				wys = szer * 0.75;
			}
			
			$('#slajd-modal-inner').width(szer);
			$('#slajd-modal-inner').height(wys);
			setFontScale();
		}
		
		$(window).resize(function(){
			setModalScale();
		});

		$('#slajd-modal-controls').hover( function(){
			$(this).fadeTo('fast', '1');
		}, function() {
			$(this).fadeTo('fast','0.3');
		});
		
		setModalScale();
		showSlide(0);
	});
	
	function showSlide(id) {
		if (id >= totalSlides - 1) id = totalSlides - 1;
		if (id < 0) id = 0;
		currentSlide = id;
		$('#slajd-modal-inner').html( $('#slide-pp-' + currentSlide ).html() );
	}

</script>

<div id="slajd-modal">
	<div id="slajd-modal-controls">
		<img src="media/img/control_start.png" onclick="showSlide(0);"/>
		<img src="media/img/control_rewind.png" onclick="showSlide(currentSlide - 1);"/>
		<img src="media/img/control_fastforward.png" onclick="showSlide(currentSlide + 1);"/>
		<img src="media/img/control_end.png" onclick="showSlide(totalSlides-1);"/>
		<a href="<?php echo $this->request->getUrl('list'); ?>"><img src="media/img/control_eject.png"/></a>
	</div>
	<div id="slajd-modal-inner">asdf</div>
</div>