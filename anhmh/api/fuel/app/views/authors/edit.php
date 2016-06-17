<h2>Editing <span class='muted'>Author</span></h2>
<br>

<?php echo render('authors/_form'); ?>
<p>
	<?php echo Html::anchor('authors/view/'.$author->id, 'View'); ?> |
	<?php echo Html::anchor('authors', 'Back'); ?></p>
