<div id="leftUserCover" style="background-image: url(<?php echo !empty($user['cover_image_path']) ? $user['cover_image_path'] : '' ?>)">
    <div id="leftUserProfile" style="background-image: url(<?php echo !empty($user['image_path']) ? $user['image_path'] : '' ?>)"></div>
    <div id="leftUserName"><?php echo !empty($user['name']) ? $user['name'] : '' ?></div>
    <?php if (!empty($AppUI->id) && $user['id'] == $AppUI->id) : ?>
    <a id="leftUserGoEdit" href="<?php echo BASE_URL ?>/users/editProfile"><?php echo __('LABEL_EDIT_PROFILE') ?></a>
    <?php else: ?>
    <?php
        $user['url_followuser'] = $this->Html->url(array(
            'controller' => 'ajax', 
            'action' => 'followuser',
            '?' => array(
                'id' => $user['id']                
             )
        ));
        $user['url_unfollowuser']  = $this->Html->url(array(
            'controller' => 'ajax', 
            'action' => 'followuser',
            '?' => array(
                'id' => $user['id'],
                'disable' => 1
             )
        ));
    ?>
    
    <a
        id="leftUserFollowBtn" 
        class="noselect <?php if (!empty($AppUI->id)) echo "ajax-submit"?> <?php echo ($user['is_follow_user'] ? 'unfollow' : 'follow')?>"
        data-url="<?php 
            echo ($user['is_follow_user'] ? $user['url_unfollowuser'] : $user['url_followuser']);
        ?>"
        data-callback="
           var id = <?php echo $user['id'] ?>;
           if (btn.hasClass('follow')) {
                $('#leftMenuFollow span').html(parseInt($('#leftMenuFollow span').html()) + 1);
                btn.removeClass('follow');
                btn.addClass('unfollow');
                btn.find('span').text(LABEL_FOLLOWING);
                btn.data('url', '<?php echo $user['url_unfollowuser']?>');
            } else {
                $('#leftMenuFollow span').html(parseInt($('#leftMenuFollow span').html()) - 1);
                btn.removeClass('unfollow');
                btn.addClass('follow');
                btn.find('span').text(LABEL_FOLLOW);
                btn.data('url', '<?php echo $user['url_followuser']?>');
            }
        ">
        <span>
            <?php echo ($user['is_follow_user'] ? __('LABEL_FOLLOWING') : __('LABEL_FOLLOW')); ?>
        </span>
    </a>
    <?php  endif ?>
</div>

<div id="leftMenuProfileComment">
    <?php echo !empty($user['memo']) ? $user['memo'] : '' ?>
</div>

<div id="leftMenuFollowContainer">
    <div id="leftMenuFollow">
        <a href="<?php echo BASE_URL ?>/users/follow/<?php echo $user['id'] ?>/i">
            <?php echo !empty($user['count_follower']) ? number_format($user['count_follower']) : '0' ?>
            <span><?php echo __('LABEL_FOLLOWING');?></span>
        </a>
    </div>
    <div id="leftMenuFollower">
        <a href="<?php echo BASE_URL ?>/users/follow/<?php echo $user['id'] ?>/me">
            <?php echo !empty($user['count_follow']) ? number_format($user['count_follow']) : '0' ?>
            <span><?php echo __('LABEL_FOLLOWER');?></span>
        </a>
    </div>
    <div id="leftMenuCoin">
        <a href="<?php echo BASE_URL ?>/users/coin/<?php echo $user['id'] ?>">
            <?php echo !empty($user['point_get_total']) ? number_format($user['point_get_total']) : '0' ?>
            <span><?php echo __('LABEL_COIN');?></span>
        </a>
    </div>
</div>

<div id="leftUserNavContainer">
    <ul class="nav nav-pills" id="leftUserNav">
        <li class="active"><a class="noselect" data-toggle="pill" href="#luRegisteredSpot"><?php echo __d('profile', 'LABEL_PROFILE_NAV_TAB1') ?></a></li>
        <li><a class="noselect" data-toggle="pill" href="#luSubmissionsReviews"><?php echo __d('profile', 'LABEL_PROFILE_NAV_TAB2') ?></a></li>
        <li><a class="noselect" data-toggle="pill" href="#luPhoto"><?php echo __d('profile', 'LABEL_PROFILE_NAV_TAB3') ?></a></li>
    </ul>
</div>

<div class="tab-content" id="leftUserNavContentContainer">
    <div id="luRegisteredSpot" class="tab-pane leftUserContent active">
        <?php if (!empty($user['place_pins']['data'])): ?>
        <?php
            foreach($user['place_pins']['data'] as $i => $place) {
                echo $this->element('left_spot_item', array(
                    'i' => $i,
                    'place' => $place
                ));
            }
        ?>
        <?php else: ?>
        <div class="leftUserContentEmpty">
            <?php
                if (empty($AppUI->id) || empty($user['id']) || $AppUI->id != $user['id']) {
                    echo __d('profile', 'LABEL_PROFILE_NAV_OTHER_EMPTY_TAB1');
                } else {
                    echo __d('profile', 'LABEL_PROFILE_NAV_ME_EMPTY_TAB1');
                }
            ?>
        </div>
        <?php endif; ?>
    </div>
    
    <div id="luSubmissionsReviews" class="tab-pane leftUserContent">
        <?php if (!empty($user['place_reviews']['data'])): ?>
        <?php
            foreach($user['place_reviews']['data'] as $i => $place) {
                echo $this->element('left_spot_item', array(
                    'i' => $i,
                    'place' => $place
                ));
            }
        ?>
        <?php else: ?>
        <div class="leftUserContentEmpty">
            <?php
                if (empty($AppUI->id) || empty($user['id']) || $AppUI->id != $user['id']) {
                    echo __d('profile', 'LABEL_PROFILE_NAV_OTHER_EMPTY_TAB2');
                } else {
                    echo __d('profile', 'LABEL_PROFILE_NAV_ME_EMPTY_TAB2');
                }
            ?>
        </div>
        <?php endif; ?>
    </div>
    
    <div id="luPhoto" class="tab-pane leftUserContent">
        <?php if (!empty($user['place_images']['data'])): ?>
        <div id="leftUserContentPhoto">
            <?php
                $_totalImages = 0;
            ?>
            <?php foreach($user['place_images']['data'] as $image): ?>
            <?php
                if (empty($image['image_path']) || empty($image['thm_image_path'])) {
                    continue;
                } else {
                    $_totalImages++;
                    $_reviewImagePath = !empty($image['thm_image_path']) ? $image['thm_image_path'] : $image['image_path'];
                }
            ?>
            <div class="leftUserPhotoItem" 
                 style="background-image: url(<?php echo $_reviewImagePath ?>)"
                 data-id="<?php echo $image['place_id'] ?>" 
                 onclick="goLeftSpotDetail($(this))">
            </div>
            <?php endforeach; ?>
            <?php
                if ($_totalImages == 0) {
                    if (empty($AppUI->id) || empty($user['id']) || $AppUI->id != $user['id']) {
                        echo __d('profile', 'LABEL_PROFILE_NAV_OTHER_EMPTY_TAB3');
                    } else {
                        echo __d('profile', 'LABEL_PROFILE_NAV_ME_EMPTY_TAB3');
                    }
                }
            ?>
        </div>
        <?php else: ?>
        <div class="leftUserContentEmpty">
            <?php
                if (empty($AppUI->id) || empty($user['id']) || $AppUI->id != $user['id']) {
                    echo __d('profile', 'LABEL_PROFILE_NAV_OTHER_EMPTY_TAB3');
                } else {
                    echo __d('profile', 'LABEL_PROFILE_NAV_ME_EMPTY_TAB3');
                }
            ?>
        </div>
        <?php endif; ?>
    </div>
</div>
