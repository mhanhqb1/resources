<link rel="stylesheet" href="<?php echo BASE_URL ?>/css/login.css?<?php echo date('Ymd') ?>" media="only screen and (min-width:640px)"/>
<link rel="stylesheet" href="<?php echo BASE_URL ?>/css/login_sp.css?<?php echo date('Ymd') ?>" media="only screen and (max-width:639px)"/>
<script type="text/javascript" src="<?php echo BASE_URL ?>/js/login_action.js?<?php echo date('Ymd') ?>"></script>
<script type="text/javascript" src="<?php echo BASE_URL ?>/js/login.js?<?php echo date('Ymd') ?>"></script>
<script src="https://connect.facebook.net/en_US/all.js"></script>
<script type="text/javascript">
    var fb_app_id = '<?php echo FACEBOOK_APP_ID ?>';
    $(function () {
        FB.init({
            appId: fb_app_id,
            cookie: true,
            status: true,
            oauth: true,
            xfbml: true
        });
    });
</script>

<div id="lgiTopPanel">
    <div id="lgiTopTitle">
        <?php echo __('BMAPS_BRAND_COPYRIGHT');?>
    </div>
    <div id="lgiTopbtns">
        <a class="lgiTopbtn noselect" id="lgiTopbtnFacebook" href="javascript: void(0)" data-action="actionLoginFacebook" data-action-type="function">
            <?php echo __('LOGIN_SIGNUP_WITH_FACEBOOK');?>
        </a>
        <a class="lgiTopbtn noselect" id="lgiTopbtnTwitter" href="javascript: void(0)" data-action="<?php echo BASE_URL ?>/login/twitter" data-action-type="url">
            <?php echo __('LOGIN_SIGNUP_WITH_TWITTER');?>
        </a>
        <a class="lgiTopbtn noselect" id="lgiTopbtnEmail" href="javascript: void(0)" data-action="<?php echo BASE_URL ?>/login/email" data-action-type="url">
            <?php echo __('LOGIN_SIGNUP_WITH_EMAIL');?>
        </a>
        
        <a class="lgiTopbtnGuest noselect" href="<?php echo BASE_URL ?>/login/guest">
            <?php echo __('LOGIN_WITH_GUESTMODE'); ?>
        </a>
        
        <img src="<?php echo BASE_URL ?>/img/developerLogo.png" id="developerLogo"/>
    </div>
    
    <div style="display: none">
        <?php echo $this->Session->flash(); ?>
    </div>
</div>

<div class="wrapPanel" id="wrapPanelLogin"></div>
<div class="dlgPopoup" id="dlgPopupLoginRule">
    <div id="dlgPopupLoginRuleTitle" class="noselect"><?php echo __('LABEL_AGREE_TERMS_OF_USE') ?></div>
    <div id="dlgPopupLoginRuleContent">
        <iframe src="<?php echo htmlspecialchars($this->Common->getWebLink('userpolicy')) ?>"></iframe>
    </div>
    <div id="dlgPopupLoginRuleBtn" class="noselect">
        <?php echo __('LABEL_AGREE') ?>
    </div>
</div>
