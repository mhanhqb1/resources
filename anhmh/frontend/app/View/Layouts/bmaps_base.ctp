<!DOCTYPE html>
<html lang="<?php echo !empty($lpLang2Digit) ? $lpLang2Digit : 'jp' ?>" id="app_page">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="Cache-Control" content="no-cache">
        <meta http-equiv="Expires" content="0">
        
        <title><?php echo $title_for_layout ?></title>
        <link rel="shortcut icon" href="<?php echo BASE_URL ?>/favicon.ico" />
        
        <link rel="stylesheet" href="<?php echo BASE_URL ?>/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo BASE_URL ?>/css/bootstrap-theme.min.css">
        
        <script type="text/javascript" src="<?php echo BASE_URL ?>/js/jquery-1.11.3.min.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL ?>/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL ?>/js/modernizr-custom.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL ?>/js/common_func.js?<?php echo date('Ymd') ?>"></script>
        <script type="text/javascript" src="<?php echo BASE_URL ?>/js/fitHeight.js?<?php echo date('Ymd') ?>"></script>
        <script type="text/javascript" src="<?php echo BASE_URL ?>/jsconstants?<?php echo date('Ymd') ?>"></script>
    </head>
    <body class="body_<?php echo $this->params->params['controller'] ?>_<?php echo $this->params->params['action'] ?> <?php echo !empty($lpLang2Digit) ? $lpLang2Digit : 'jp' ?>">
        <div id="app_page_container">
            <?php echo $this->fetch('content'); ?>
        </div>
    </body>
</html>
