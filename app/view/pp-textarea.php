<?php /* @var $this View */ ?>
<?php if (!empty($obecny)): ?>
	<form action="<?php echo $this->request->getUrl('pp/saveslide', array('id' => $obecny->id)); ?>" method="post" id="slide-data-form">
		<textarea cols="10" rows="10" style="width: 98%; height: 300px;" name="slideData[text]" id="slideData"><?php echo $obecny->text; ?></textarea>
		<input type="submit" value="Zapisz"/>
	</form>
<?php endif; ?>
