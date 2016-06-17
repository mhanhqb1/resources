<?php
    $current_controller = $this->params->params['controller'];
    $current_action = $this->params->params['action'];
    $url_spot_ranking = $url_user_ranking = 'javascript: void(0)';
    if ($current_controller != 'top') {
        $url_spot_ranking = BASE_URL . '/top#spot_ranking';
        $url_user_ranking = BASE_URL . '/top#user_ranking';
    }
?>
<div id="leftMenu" class="asideShadow">
    <div id="leftMenuClose"></div>
    <div id="leftMenuContainer">
        <ul class="noselect">
            <li id="leftMenuItemMyTimeline" class="<?php if($current_controller == 'timelines' && $current_action == 'index') echo 'active' ?>">
                <a href="<?php echo BASE_URL ?>/timelines">
                    <span class="leftMenuItemIcon"></span><?php echo __('LABEL_MENU_MYTIMELINE'); ?>
                </a>
            </li>
            <li id="leftMenuItemMap">
                <a href="<?php echo BASE_URL ?>/top">
                    <span class="leftMenuItemIcon"></span><?php echo __('LABEL_MENU_MAP'); ?>
                </a>
            </li>
            <li id="leftMenuItemGoPlaces" class="<?php if($current_controller == 'places' && $current_action == 'index') echo 'active' ?>">
                <a href="<?php echo BASE_URL ?>/places">
                    <span class="leftMenuItemIcon"></span><?php echo __('LABEL_MENU_MYPLACES'); ?>
                </a>
            </li>
            <li id="leftMenuItemRanking">
                <a href="<?php echo htmlspecialchars($url_spot_ranking) ?>">
                    <span class="leftMenuItemIcon"></span><?php echo __('LABEL_MENU_RANKING'); ?>
                </a>
            </li>
            <li id="leftMenuItemUserRanking">
                <a href="<?php echo htmlspecialchars($url_user_ranking) ?>">
                    <span class="leftMenuItemIcon"></span><?php echo __('LABEL_MENU_USER_RANKING'); ?>
                </a>
            </li>
            <li id="leftMenuItemFeaturedUser" class="<?php if($current_controller == 'users' && $current_action == 'recommend') echo 'active' ?>">
                <a href="<?php echo BASE_URL ?>/users/recommend">
                    <span class="leftMenuItemIcon"></span><?php echo __('LABEL_MENU_RECOMMEND_USER'); ?>
                </a>
            </li>
            <li id="leftMenuItemChampionship">
                <a href="javascript: void(0)">
                    <span class="leftMenuItemIcon"></span><?php echo __('LABEL_MENU_CHAMPIONSHIP'); ?>
                </a>
            </li>
            
            <?php if(false): ?>
            <li id="leftMenuItemAttentionSpot"><a href="javascript: void(0)"><span class="leftMenuItemIcon"></span><?php echo __('LABEL_MENU_HOTSPOT'); ?></a></li>
            <li id="leftMenuItemFollow"><a><span class="leftMenuItemIcon"></span><?php echo __('LABEL_MENU_FOLLOW'); ?></a></li>
            <li id="leftMenuItemSurroundingArea"><a><span class="leftMenuItemIcon"></span>周辺地域</a></li>
            <li id="leftMenuItemNotice"><a href="javascript: void(0)"><span class="leftMenuItemIcon"></span>お知らせ</a></li>
            <li id="leftMenuItemMessage"><a href="javascript: void(0)"><span class="leftMenuItemIcon"></span>メッセージ</a></li>
            <?php endif; ?>
        </ul>
    </div>
</div>
