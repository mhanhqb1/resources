<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $this->fetch('title'); ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('cake.generic');
        echo $this->Html->css('error');
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
    <header>
        <div id="headerContainer">
            <div id="headerLogo">
                <a href="<?php echo BASE_URL ?>/top">
                    <img src="<?php echo BASE_URL ?>/img/headerLogo.png"/>
                </a>
            </div>
        </div>
    </header>
	<div id="container">
		<div id="content">
            <?php if ($error->getCode() == 404): ?>
            <div class="error404">
                <div class="error404Number">404</div>
                <div class="error404Text"><?php echo __('ERROR_404_MESSAGE') ?></div>
            </div>
            <?php
            else:
                echo $this->fetch('content');
            endif;
            ?>
		</div>
	</div>
</body>
</html>
