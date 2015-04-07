Lista slajdów:

<div class="slajdy-div">
	<?php $i = 0; ?>
	<?php foreach ($slides as $s): ?>
		<div id="slide-pp-<?php echo $i++; ?>" class="sub-slajd" style="display: none;">
			<?php echo BBCode::show($s->text); ?>
		</div>
	<?php endforeach; ?>
</div>

<script type="text/javascript">
	var totalSlides = <?php echo $i ?>;
	var currentSlide = <?php echo (!empty($startSlide)) ? $startSlide : '0'; ?>;
	var remote = <?php echo (!empty($remote)) ? 'true' : 'false'; ?>;
	var remoteView = <?php echo (!empty($remoteView)) ? 'true' : 'false'; ?>;
	var remoteTimeout = false;
	
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

			$('#slajd-modal').css('font-size', fontSize + '%');
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
			$('#slajd-modal-controls').css('right', ($window.width() - szer + 20) / 2);
			$('#slajd-remote-monitor').css('right', ($window.width() - szer + 20) / 2 );
			$('#slajd-modal-inner.bg1').css('padding-left', (szer * 0.12) + 'px');
			console.log(szer);
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
		
		$('#slajd-remote-monitor').fadeTo(1,'0.3');
		
		$('#slajd-modal-controls img').hover(function(){
			var a = $(this).attr('src');
			if (a.indexOf('blue') < 0) {
				$(this).attr('src', a.replace('.png','_blue.png'));
			}
		}, function(){
			var a = $(this).attr('src');
			$(this).attr('src', a.replace('_blue.png','.png'));
		});
		
		setModalScale();
		showSlide(currentSlide);

		if (remoteView) {
			synchroSlide();
		}
	});
			
	function synchroSlide(){
		$.getJSON('<?php echo $this->request->getUrl('remote/synchroslide', array('id' => $s->pp_id)); ?>&slid=' + currentSlide, function(data){
			if (data.success == 1) {
				showSlide(data.currSlide);
				remoteTimeout = setTimeout('synchroSlide()', 2000);
			} else {
				alert('Nieznany błąd. Zdalna prezentacja zostaje wstrzymana\n'+data);
			}
		});
		
	}

	function showSlide(id) {
		if (id >= totalSlides - 1) id = totalSlides - 1;
		if (id < 0) id = 0;
		currentSlide = id;
				
		if (remote) {
			$.get('<?php echo $this->request->getUrl('remote/currentslide', array('id' => $s->pp_id)); ?>&slid=' + currentSlide);
		}
				
		$('#slajd-modal-content').html( $('#slide-pp-' + currentSlide ).html() );
        $('#slajd-pagination').html( (currentSlide+1) + '/' + totalSlides);
	}

	function turnLight() {
		$('#slajd-modal').css('background-color', ($('#slajd-modal').css('background-color') == 'rgb(0, 0, 0)') ? 'white' : 'black');
	}

</script>

<div id="slajd-modal">
	<?php if (!empty($remoteView)): ?>
		<div id="slajd-remote-monitor">
			<img src="media/img/world.png"/>
		</div>
	<?php endif; ?>
	<div id="slajd-modal-controls">
        <span id="slajd-pagination"></span>
        <img src="media/img/lightbulb.png" onclick="turnLight();"/>
        <?php if (empty($remoteView)): ?>
			<img src="media/img/control_start.png" onclick="showSlide(0);" title="First"/>
			<img src="media/img/control_rewind.png" onclick="showSlide(currentSlide - 1);" title="Prev"/>
			<img src="media/img/control_fastforward.png" onclick="showSlide(currentSlide + 1);" title="Next"/>
			<img src="media/img/control_end.png" onclick="showSlide(totalSlides-1);" title="Last"/>
		<?php endif; ?>
		<a href="<?php echo $this->request->getUrl('list'); ?>"><img src="media/img/control_eject.png"/></a>
	</div>
	<?php if (!empty($theme)): ?>
	<div id="slajd-modal-inner" class="<?php echo $theme ?>">
	<?php else: ?>
	<div id="slajd-modal-inner">
	<?php endif; ?>
		<div id="slajd-modal-content">asdf</div>
	</div>
</div>
