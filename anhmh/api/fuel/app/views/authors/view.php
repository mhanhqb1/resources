<h2>Viewing <span class='muted'>#<?php echo $author->id; ?></span></h2>

<p>
	<strong>Name:</strong>
	<?php echo $author->name; ?></p>
<p>
	<strong>Email:</strong>
	<?php echo $author->email; ?></p>

<?php echo Html::anchor('authors/edit/'.$author->id, 'Edit'); ?> |
<?php echo Html::anchor('authors', 'Back'); ?>