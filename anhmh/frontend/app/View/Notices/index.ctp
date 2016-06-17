<?php if (!$this->request->is('ajax')) : ?>
<script type="text/javascript" src="<?php echo BASE_URL ?>/js/notice.js?<?php echo date('Ymd') ?>"></script>
<div id="ntcTitleContainer">
    <div id="ntcTitlePadding">&nbsp;</div>
    <div id="ntcTitle"><?php echo __('LABEL_MENU_NOTICES');?></div>
</div>
<div id="ntcContainer">
<?php endif; ?>
    <?php foreach ($data as $notification):?>
        <?php if(isset($notification['type'])):?>
            <?php if(count($notification['users']) == 1): $user = $notification['users'][0];?>
            <div class="ntcItem ntcItemType2">
                <a
                    class="ntcUser"
                    style="background-image: url(<?php echo $user['image_path']; ?>)"
                    href='javascript:;'
                    onclick="return showLeftUser(<?php echo $notification['user_id']?>, true);">
                </a>
                <div class="ntcDetail">
                    <div class="ntcItemDate">
                    <?php echo $this->Time->format(NOTIFICATION_DATETIME_FORMAT, $notification['updated']);?>
                    </div>
                    <a
                        class="ntcUserName"
                        href='javascript:;'
                        onclick="return showLeftUser(<?php echo $notification['user_id']?>, true);">
                        <?php echo $notification['name'] ?>
                    </a>
                    <div class="ntcText">
                        <?php echo $notification['notice'] ?>
                    </div>
                </div>
            </div>
            <?php elseif(count($notification['users']) > 1):?>
            <div class="ntcItem ntcItemType1">
                <div class="ntcListUser">
                    <?php foreach ($notification['users'] as $user): ?>
                    <a
                        title="<?php echo htmlspecialchars($user['name']) ?>"
                        class="ntcUserItem"
                        href='javascript:;'
                        onclick="return showLeftUser(<?php echo $user['user_id']?>, true);"
                        style="background-image: url(<?php echo $user['image_path'] ?>)">
                    </a>
                    <?php endforeach; ?>
                </div>
                <div class="ntcItemDate">
                    <?php echo $this->Time->format(NOTIFICATION_DATETIME_FORMAT, $notification['updated']);?>
                </div>
                <div class="ntcDetail">
                    <a
                        href='javascript:;'
                        onclick="return showLeftUser(<?php echo $notification['user_id']?>, true);">
                        <?php echo $notification['name'] ?>
                    </a>
                    <span><?php echo !empty($notification['notice_custom']) ? $notification['notice_custom'] : $notification['notice'] ?></span>
                </div>
            </div>
            <?php endif;?>
        <?php else:?>
            <div class="ntcItem ntcItemType2">
                <div
                    class="ntcUser"
                    style="background-image: url(<?php echo BASE_URL ?>/img/info.png)"
                >
                </div>
                <div class="ntcDetail">
                    <div class="ntcItemDate">
                    <?php echo $notification['date'];?>
                    </div>
                    <span
                        class="ntcUserName"
                        href="javascript: void(0)">
                        <?php echo $notification['title'] ?>
                    </span>
                    <div class="ntcText">
                        <?php if(!empty($notification['url'])): ?>
                        <a href="<?php echo $notification['url'] ?>" target="_blank"><?php echo $notification['message'] ?></a>
                        <?php else: ?>
                        <?php echo $notification['message'] ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif;?>
    <?php endforeach;?>
<?php if (!$this->request->is('ajax')) : ?>
</div>
<?php endif; ?>
