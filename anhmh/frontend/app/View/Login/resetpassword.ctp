<link rel="stylesheet" href="<?php echo BASE_URL ?>/css/login.css?<?php echo date('Ymd') ?>" media="only screen and (min-width:640px)"/>
<link rel="stylesheet" href="<?php echo BASE_URL ?>/css/login_sp.css?<?php echo date('Ymd') ?>" media="only screen and (max-width:639px)"/>

<div id="lgiEmailPanel">
    <div id="lgiEmailError">
        <?php echo $this->Session->flash(); ?>
    </div>
    <div id="lgiEmailTitle">
        <?php echo __d('login', 'LANG_LOGIN_NEW_PASSWORD');?>
    </div>
    <form method="POST" autocomplete="off">
        <input type="password" value="" style="display: none"/>
        
        <input type="password" placeholder="<?php echo __('INPUT_PASSWD_PLACEHOLDER');?>" name="data[Login][password]" value="<?php if(!empty($dataPass['Login']['password'])) echo htmlspecialchars($dataPass['Login']['password']) ?>" maxlength="40" autocomplete="off"/>
        <input type="password" placeholder="<?php echo __d('login', 'INPUT_PASSWD_CONFIRM_PLACEHOLDER');?>" name="data[Login][password_confirm]" value="<?php if(!empty($dataPass['Login']['password_confirm'])) echo htmlspecialchars($dataPass['Login']['password_confirm']) ?>" maxlength="40" autocomplete="off"/>
        <div id="lgiEmailBtns">            
            <input type="submit" value="<?php echo __d('login', 'LOGIN_LABEL_UPDATE');?>" name="data[Submit][register]" id="lgiResetBtn"/>
        </div>
    </form>
</div>
