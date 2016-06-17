<?php foreach($users as $user): ?>
<div class="urcmItem">
    <div class="urcmItemUser">
        <a
            href='#'
            onclick="return showLeftUser(<?php echo $user['id']?>, true);"
            class="urcmItemUserImage"
            style="background-image: url(<?php echo $user['image_path'] ?>)">             
        </a>
        <div class="urcmItemUserDetail">
            <a  href='#'
                onclick="return showLeftUser(<?php echo $user['id']?>, true);"
                class="urcmItemUserDetailName">
                <?php echo $user['name'] ?>
            </a>
            <div class="urcmItemUserDetailFollowers">
                <span class="count-follow-<?php echo $user['id'] ?>"><?php echo !empty($user['count_follow']) ? $user['count_follow'] : '0' ?></span> <?php echo __('LABEL_FOLLOWER');?>
            </div>
            <div class="urcmItemUserDetailAttributes">
                <?php echo __('LABEL_USER_ATTRIBUTE');?>　<?php echo $user['user_physical_type_name'] ?>
            </div>
        </div>
    </div>
    <!-- Follow user -->
    <?php if (empty($AppUI->id) || (!empty($AppUI->id) && $user['id'] != $AppUI->id)): ?>
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
        class="<?php if (!empty($AppUI->id)) echo "ajax-submit"?> <?php echo ($user['is_follow_user'] ? 'unfollow' : 'follow')?>"
        data-url="<?php 
            echo ($user['is_follow_user'] ? $user['url_unfollowuser'] : $user['url_followuser']);
        ?>"
        data-callback="
            var id = <?php echo $user['id'] ?>;
           if (btn.hasClass('follow')) {
                $('.count-follow-'+id).html(parseInt($('.count-follow-'+id).html()) + 1);
                btn.removeClass('follow');
                btn.addClass('unfollow');
                btn.find('.urcmItemFollow').text('<?php echo __('LABEL_FOLLOWING');?>');
                btn.data('url', '<?php echo $user['url_unfollowuser']?>');
            } else {
                $('.count-follow-'+id).html(parseInt($('.count-follow-'+id).html()) - 1);
                btn.removeClass('unfollow');
                btn.addClass('follow');
                btn.find('.urcmItemFollow').text('<?php echo __('LABEL_FOLLOW');?>');
                btn.data('url', '<?php echo $user['url_followuser']?>');
            }
        "
    >
        <div class="urcmItemFollow noselect">
            <?php echo ($user['is_follow_user'] ? __('LABEL_FOLLOWING') : __('LABEL_FOLLOW')); ?>
        </div>
    </a>  
    <?php endif; ?>
</div>
<?php endforeach; ?>