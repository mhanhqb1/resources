<link rel="stylesheet" href="<?php echo BASE_URL ?>/css/login.css?<?php echo date('Ymd') ?>" media="only screen and (min-width:640px)"/>
<link rel="stylesheet" href="<?php echo BASE_URL ?>/css/login_sp.css?<?php echo date('Ymd') ?>" media="only screen and (max-width:639px)"/>

<div id="lgiEmailPanel">
    <div id="lgiEmailError">
        <?php echo $this->Session->flash(); ?>
    </div>
    <div id="lgiEmailTitle">
        <?php echo __('LOGIN_SIGNUP_WITH_EMAIL_2');?>
    </div>
    <form method="POST" action="<?php echo BASE_URL ?>/login/email" autocomplete="off">
        <input type="email" value="" style="display: none"/>
        <input type="password" value="" style="display: none"/>
        
        <input <?php if(!empty($loginData['blocked'])) echo 'disabled' ?> type="email" placeholder="<?php echo __('INPUT_EMAIL_PLACEHOLDER');?>" name="data[Login][email]" value="<?php if(!empty($loginData['email'])) echo __($loginData['email']) ?>" maxlength="40" autocomplete="on"/>
        <input <?php if(!empty($loginData['blocked'])) echo 'disabled' ?> type="password" placeholder="<?php echo __('INPUT_PASSWD_PLACEHOLDER');?>" name="data[Login][password]" value="" maxlength="40" autocomplete="off"/>
        <div id="lgiEmailBtns">
            <input type="submit" value="<?php echo __('SUBMIT_LOGIN');?>" name="data[Submit][login]" id="lgiEmailBtnLogin" <?php if(!empty($loginData['blocked'])) echo 'disabled' ?>/>
            <input type="submit" value="<?php echo __('SUBMIT_SIGNUP');?>" name="data[Submit][register]" id="lgiEmailBtnRegister" <?php if(!empty($loginData['blocked'])) echo 'disabled' ?>/>
        </div>
        <div id="lgiEmailForgetPassword">    
            <a href="<?php echo $this->Html->url('/forgetpassword'); ?>">
                <?php echo __('LABEL_FORGET_PASSWORD')?>
            </a>
        </div>
    </form>
</div>
