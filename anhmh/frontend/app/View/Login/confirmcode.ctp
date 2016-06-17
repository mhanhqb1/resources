<link rel="stylesheet" href="<?php echo BASE_URL ?>/css/login.css?<?php echo date('Ymd') ?>" media="only screen and (min-width:640px)"/>
<link rel="stylesheet" href="<?php echo BASE_URL ?>/css/login_sp.css?<?php echo date('Ymd') ?>" media="only screen and (max-width:639px)"/>

<div id="lgiEmailPanel">
    <div id="lgiEmailError">
        <?php echo $this->Session->flash(); ?>
    </div>
    <div id="lgiEmailTitle">
        <?php echo __d('login', 'LANG_LOGIN_CONFIRM_CODE');?>
    </div>
    <form method="POST">
        <input type="email" placeholder="<?php echo __d('login', 'LANG_LOGIN_CONFIRM_CODE_HOLDER');?>" name="data[Login][confirmcode]" value="" maxlength="40"/>
        <div id="lgiEmailBtns">            
            <input type="submit" value="<?php echo __('LABEL_NEXT'); ?>" name="data[Submit][login]" id="lgiConfirmCodeBtn"/>
        </div>        
    </form>
</div>
