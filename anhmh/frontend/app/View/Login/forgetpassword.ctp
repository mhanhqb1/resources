<link rel="stylesheet" href="<?php echo BASE_URL ?>/css/login.css?<?php echo date('Ymd') ?>" media="only screen and (min-width:640px)"/>
<link rel="stylesheet" href="<?php echo BASE_URL ?>/css/login_sp.css?<?php echo date('Ymd') ?>" media="only screen and (max-width:639px)"/>

<div id="lgiEmailPanel">
    <div id="lgiEmailError">
        <?php echo $this->Session->flash(); ?>
    </div>
    <div id="lgiEmailTitle">
        <?php echo __d('login', 'LANG_LOGIN_FORGET_PASSWORD');?>
    </div>
    <div id="lgiForgotPassDesc">
        <?php echo __d('login', 'LABEL_FORGOT_PASSWORD_DESCRIPTION');?>
    </div>
    <form method="POST">
        <input type="email" placeholder="<?php echo __('INPUT_EMAIL_PLACEHOLDER');?>" name="data[Login][email]" value="<?php if(!empty($loginData['email'])) echo __($loginData['email']) ?>" maxlength="40"/>
        <div id="lgiEmailBtns">            
            <input type="submit" value="<?php echo __('LABEL_SUBMIT'); ?>" name="data[Submit][login]" id="lgiForgetPasswordBtn"/>
        </div>        
    </form>
</div>
