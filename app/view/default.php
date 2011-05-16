<h1>Lista aktualnie dostępnych zdalnie wyświetlanych prezentacji</h1>

<?php if ($result->count() == 0): ?>
			No cóż, przykra sprawa, ale nikt aktualnie nie pokazuje prezentacji =)
<?php else: ?>
	<?php foreach ($result as $r): ?>
		<h2><a href="<?php echo $this->request->getUrl('remote/view', array('id' => $r->id)); ?>"><?php echo $r->name; ?></a></h2>
	<?php endforeach; ?>
<?php endif; ?>
