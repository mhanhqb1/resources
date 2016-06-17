<div id="changePasswordPanel">
    <div id="changePasswordError">
        <?php echo $this->Session->flash(); ?>
    </div>
    <div id="changePasswordTitle">
        <?php echo __('LABEL_MENU_CHANGE_USER_PASSWORD'); ?>
    </div>
    
    <form method="POST" action="" autocomplete="off">
        <input type="password" value="" style="display: none"/>
        
        <div><?php echo __('LABEL_CURRENT_PASSWORD') ?></div>
        <input type="password" class="changePasswordField" autocomplete="off" name="data[ChangePassword][password_old]" value="<?php echo !empty($params['password_old']) ? $params['password_old'] : '' ?>" maxlength="40"/>
        
        <div><?php echo __('LABEL_NEW_PASSWORD') ?></div>
        <input type="password" class="changePasswordField" autocomplete="off" name="data[ChangePassword][password]" value="<?php echo !empty($params['password']) ? $params['password'] : '' ?>" maxlength="40"/>
        
        <div><?php echo __('LABEL_NEW_CONFIRM_PASSWORD') ?></div>
        <input type="password" class="changePasswordField" autocomplete="off" name="data[ChangePassword][password_confirm]" value="<?php echo !empty($params['password_confirm']) ? $params['password_confirm'] : '' ?>" maxlength="40"/>
        
        <div class="changePasswordBtns">
            <button type="submit" id="changePasswordBtn"><?php echo __('LABEL_CHANGE') ?></button>
        </div>
    </form>
</div>
