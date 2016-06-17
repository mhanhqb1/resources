<script type="text/javascript" src="<?php echo BASE_URL ?>/js/setting.js?<?php echo date('Ymd') ?>"></script>

<div class="stgTitle stgTitleNotice">
    <?php echo __('LABEL_NOTIFICATION_SETTING');?>
</div>

<div class="stgNoticeItems">
    <?php foreach ($settings as $setting):?>
    <div class="stgItem" data-name="<?php echo $setting['name']?>" data-value="<?php echo $setting['value']?>">
        <div class="stgItemContainer">
            <div class="stgItemText"><?php echo $setting['title']?></div>
            <div class="stgItemButton">
                <a href="javascript: void(0)">
                    <?php echo __('LABEL_EDIT');?>
                </a>
            </div>
        </div>
    </div>
    <?php endforeach;?>
</div>

<div class="stgTitle stgTitleGuideline">
    <?php echo __('LABEL_OTHER') ?>
</div>
<div class="stgOtherItems">
    <div class="stgItem">
        <div class="stgItemContainer">
            <div class="stgItemText stgOtherItem noselect" data-url="<?php echo htmlspecialchars($this->Common->getWebLink('userpolicy')) ?>"><?php echo __('LABEL_TERM_OF_USE') ?></div>
        </div>
    </div>
    
    <div class="stgItem">
        <div class="stgItemContainer">
            <div class="stgItemText stgOtherItem noselect" data-url="<?php echo htmlspecialchars($this->Common->getWebLink('policy')) ?>"><?php echo __('LABEL_PRIVACY_POLICY') ?></div>
        </div>
    </div>
    
    <div class="stgItem">
        <div class="stgItemContainer">
            <div class="stgItemText stgOtherItem noselect" data-url="<?php echo htmlspecialchars($this->Common->getWebLink('credit')) ?>"><?php echo __('LABEL_CREDIT') ?></div>
        </div>
    </div>
</div>
