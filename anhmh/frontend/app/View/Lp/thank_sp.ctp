<div id="section1">
    <div id="section1_1">
        <div id="section1_1_thanks">
            <div>
                <?php echo nl2br($this->Common->getlanguageLp('LANDING_MAIL_SENT', $lpLang)) ?>
            </div>
        </div>
        <img src="<?php echo BASE_URL ?>/img/landing/section1_1_sp.png"/>
    </div>
</div>

<div id="topMenu" class="noselect">
    <a class="topMenuItem" href="<?php echo BASE_URL . '/' . $lpLang2Digit ?>#contact"><?php echo $this->Common->getlanguageLp('LP_MENU_CONTACT', $lpLang) ?></a>
    <a class="topMenuItem" href="<?php echo BASE_URL . '/' . $lpLang2Digit ?>#social"><?php echo $this->Common->getlanguageLp('LP_MENU_SOCIAL', $lpLang) ?></a>
    <a class="topMenuItem" href="<?php echo BASE_URL . '/' . $lpLang2Digit ?>#about"><?php echo $this->Common->getlanguageLp('LP_MENU_WHAT', $lpLang) ?></a>
</div>
