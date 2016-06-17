<!doctype html>
<html lang="<?php echo $lpLang2Digit ?>">
<head>
    <title><?php echo $this->Common->getlanguageLp('LP_META_TITLE', $lpLang) ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,inicial-scale=1.0,user-scalable=no">
    <meta name="description" content="<?php echo $this->Common->getlanguageLp('LP_META_DESCRIPTION', $lpLang) ?>">
    <meta name="keywords" content="<?php echo $this->Common->getlanguageLp('LP_META_KEYWORD', $lpLang) ?>">
    
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/css/bootstrap.css?<?php echo date('Ymd') ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/css/bootstrap-theme.css?<?php echo date('Ymd') ?>">
    <?php if($isMobile): ?>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/css/landing_sp.css?<?php echo date('Ymd') ?>">
    <?php else: ?>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/css/landing.css?<?php echo date('Ymd') ?>">
    <?php endif; ?>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/css/validationEngine.jquery.css?<?php echo date('Ymd') ?>">
    
    <script type="text/javascript" src="<?php echo BASE_URL ?>/js/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL ?>/js/jquery-ui.min-1.11.3.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL ?>/js/bootstrap.js?<?php echo date('Ymd') ?>"></script>
</head>
<body class="<?php echo $lpLang2Digit ?> body_<?php echo $this->params->params['controller'] ?>_<?php echo $this->params->params['action'] ?>">
    <div id="navLang">
        <div id="navLangContainer">
            <?php if($isMobile): ?>
            <a class="navFacebook" href="https://www.facebook.com/Bmaps-1143055982381030/?fref=ts" target="_blank">facebook</a>
            <?php endif; ?>
            <a class="<?php if ($lpLang == 'spa') echo 'active' ?>" href="<?php echo BASE_URL ?>/es">Español</a>
            <span>/</span>
            <a class="<?php if ($lpLang == 'eng') echo 'active' ?>" href="<?php echo BASE_URL ?>/en">English</a>
            <span>/</span>
            <a class="<?php if ($lpLang == 'jpn') echo 'active' ?>" href="<?php echo BASE_URL ?>/jp">日本語</a>
        </div>
    </div>
    <?php echo $this->fetch('content'); ?>
    
    <a id="moveTop" href="#navLang" class="noselect">
        <img src="<?php echo BASE_URL ?>/img/landing/top.png"/>
        <div><?php echo $this->Common->getlanguageLp('LP_BTN_GO_TOP_PAGE', $lpLang) ?></div>
    </a>

    <div id="footer">
        ©2016 Bmaps.
    </div>
    
    <script type="text/javascript" src="<?php echo BASE_URL ?>/js/jquery.validationEngine.js?<?php echo date('Ymd') ?>"></script>
    <?php if($lpLang == 'jpn'): ?>
    <script language="javascript" type="text/javascript" src="<?php echo BASE_URL ?>/js/jquery.validationEngine-jp.js?<?php echo date('Ymd') ?>"></script>
    <?php elseif ($lpLang == 'spa'): ?>
    <script language="javascript" type="text/javascript" src="<?php echo BASE_URL ?>/js/jquery.validationEngine-es.js?<?php echo date('Ymd') ?>"></script>
    <?php else: ?>
    <script language="javascript" type="text/javascript" src="<?php echo BASE_URL ?>/js/jquery.validationEngine-en.js?<?php echo date('Ymd') ?>"></script>
    <?php endif; ?>
    <script type="text/javascript">
        var BASE_URL = "<?php echo BASE_URL ?>";
    </script>
    <script type="text/javascript" src="<?php echo BASE_URL ?>/js/landing.js?<?php echo date('Ymd') ?>"></script>
    
    <?php echo Configure::read('Google.Analyticstracking')['lp']."\n"; ?>
</body>
</html>
