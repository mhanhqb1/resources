<?php if (!$this->request->is('ajax')) : ?>
<link rel="stylesheet" href="<?php echo BASE_URL ?>/css/timeline.css"/>
<script type="text/javascript" src="<?php echo BASE_URL ?>/js/timeline.js?<?php echo date('Ymd') ?>"></script>

<div id="plcListTimelineNav">
    <div>
        <a href="<?php echo BASE_URL ?>/timelines" class="noselect <?php if(empty($type) || $type == 'all') echo 'active' ?>"><?php echo __('LABEL_ALL') ?></a>
        <a href="<?php echo BASE_URL ?>/timelines?t=follow" class="noselect <?php if(!empty($type) && $type == 'follow') echo 'active' ?>"><?php echo __('LABEL_FOLLOW') ?></a>
        <a href="<?php echo BASE_URL ?>/timelines?t=near" class="noselect <?php if(!empty($type) && $type == 'near') echo 'active' ?>"><?php echo __('LABEL_VICINITY') ?></a>
    </div>
</div>

<?php if(!empty($isEmptyZipcode)): ?>
<div id="plcListTimelineEmptyZipcode">
    <?php echo __('MESSAGE_TIMELINE_NO_NEAR') ?>
    <br/>
    <a id="plcListTimelineEditProfile" class="noselect" href="<?php echo BASE_URL . '/users/updateinfo' ?>">
        <?php echo __('LABEL_SETTING') ?>
    </a>
</div>
<?php endif; ?>

<div id="plcListTimeline">
<?php endif; ?>
<?php foreach($data as $place): ?>
<?php
    //$place['review_point'] = round($place['review_point'], 1);
    $categoryImagePath = Configure::read('Config.categoryImagePath');
    if (empty($categoryImagePath[$place['place_category_type_id']])) {
        $place['place_category_type_id'] = 0;        
    }
    $place['place_category_image_path'] = BASE_URL . '/' . $categoryImagePath[$place['place_category_type_id']];    
?>
<div class="tlTop" data-id="<?php echo $place['id'] ?>" onclick="return goLeftSpotDetail($(this), null, null, true)">
    <?php if (!empty($place['place_image_path'])):  ?>
    <div class="tlImage" style="background-image: url(<?php echo htmlspecialchars($place['place_image_path']) ?>)"></div>
    <?php endif; ?>  
    <div class="tlTopInfo">
        <div class="tlTopInfoGeneral">
            <div class="tlTopInfoName">
                <?php
                    $place['is_favorite'] = !empty($place['is_favorite']) ? 1 : 0;
                    $place['url_favorite'] = $this->Html->url(array(
                        'controller' => 'ajax', 
                        'action' => 'wanttovisit',
                        '?' => array(
                            'id' => $place['id'],                
                            'google_place_id' => $place['google_place_id'],                
                         )
                    ));
                    $place['url_unfavorite']  = $this->Html->url(array(
                        'controller' => 'ajax', 
                        'action' => 'wanttovisit',
                        '?' => array(
                            'id' => $place['id'],
                            'google_place_id' => $place['google_place_id'],
                            'disable' => 1
                         )
                    ));
                ?>
                <div class="tlWantToGo noselect ajax-submit <?php echo ($place['is_favorite'] ? 'unfavorite' : 'favorite')?>"
                    data-url="<?php 
                        echo ($place['is_favorite'] ? $place['url_unfavorite'] : $place['url_favorite']);
                   ?>"
                    data-callback="      
                        if (btn.hasClass('favorite')) {
                            btn.removeClass('favorite');
                            btn.addClass('unfavorite');
                            btn.data('url', '<?php echo $place['url_unfavorite']?>');
                        } else {
                            btn.removeClass('unfavorite');
                            btn.addClass('favorite');
                            btn.data('url', '<?php echo $place['url_favorite']?>');
                        }
                    "
                >
                    <div class="tlWantToGoImg"></div>
                    <?php echo __('LABEL_PLACE_WANT_TO_GO');?>
                </div>
                
                <span class="tlTopInfoNameTxt">
                <?php echo!empty($place['name']) ? $place['name'] : '' ?>
                </span>
            </div>
            <div class="tlTopInfoCategory">
                <?php echo !empty($place['place_sub_category_name']) ? $place['place_sub_category_name'] : '' ?>
            </div>
            <div class="tlTopInfoAddress">
                <?php echo !empty($place['address']) ? $place['address'] : '' ?>
            </div>
        </div>
        
        <!--
        <div class="tlTopInfoDetail">
            ○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○......
        </div>
        -->
    </div>    
    <div class="tlTopReview">
        <div class="tlTopReviewTop">
            <div class="tlTopReviewIcon">
                <img src="<?php echo $place['place_category_image_path'] ?>"/>
            </div>
            <div class="tlTopReviewDetail">
                <div class="tlTopReviewLabel">
                    <?php echo __('LABEL_SPOT_REVIEW');?>
                </div>
                <div class="tlTopReviewPoint">
                    <div class="tlTopReviewPointFace tlTopReviewPointFace1<?php if ($place['review_point'] >= 1) echo " on" ?>"></div>
                    <div class="tlTopReviewPointFace tlTopReviewPointFace2<?php if ($place['review_point'] >= 2) echo " on" ?>"></div>
                    <div class="tlTopReviewPointFace tlTopReviewPointFace3<?php if ($place['review_point'] >= 3) echo " on" ?>"></div>
                    <div class="tlTopReviewPointFace tlTopReviewPointFace4<?php if ($place['review_point'] >= 4) echo " on" ?>"></div>
                    <div class="tlTopReviewPointFace tlTopReviewPointFace5<?php if ($place['review_point'] >= 5) echo " on" ?>"></div>
                    <span><?php echo $place['review_point'] ?></span>
                </div>
            </div>
        </div>
        <div class="tlTopReviewBot">
            <div class="tlTopReviewEquipment">
                <div class="tlTopReviewEquipmentLabel">
                    <?php echo __('LABEL_FACILITY_DETAIL');?>
                </div>
                <div class="tlTopReviewEquipmentDetail">
                    <?php foreach(Configure::read('Config.placeFacilityIcon') as $key => $icon): ?>
                    <?php if (isset($place[$key]) && $place[$key] == 1): ?>
                    <div class="tlTopReviewEquipmentItem">
                        <img src="<?php echo BASE_URL . '/' . $icon?>"/>
                    </div>
                    <?php endif; ?>
                    <?php endforeach; ?>                    
                </div>
            </div>
            <div class="tlTopReviewChart">
                <div class="tlTopReviewChartLabel">
                    <?php echo __('LABEL_ENTRY_STEPS');?>
                </div>
                <div class="tlTopReviewChartDetail">
                    <div class="tlTopReviewChartLevel tlTopReviewChartLevel1<?php if ($place['entrance_steps'] >= 0) echo " on" ?>"></div>
                    <div class="tlTopReviewChartLevel tlTopReviewChartLevel2<?php if ($place['entrance_steps'] >= 1) echo " on" ?>"></div>
                    <div class="tlTopReviewChartLevel tlTopReviewChartLevel3<?php if ($place['entrance_steps'] >= 2) echo " on" ?>"></div>
                    <div class="tlTopReviewChartLevel tlTopReviewChartLevel4<?php if ($place['entrance_steps'] >= 3) echo " on" ?>"></div>
                    <div class="tlTopReviewChartLevel tlTopReviewChartLevel5<?php if ($place['entrance_steps'] >= 4) echo " on" ?>"></div>
                </div>
                <?php if (isset($place['entrance_steps']) && $place['entrance_steps'] != -1): ?>
                <div class="tlTopReviewChartNumber">
                <?php 
                    if (empty($place['entrance_steps'])) {
                        $place['entrance_steps'] = 0;
                    } elseif ($place['entrance_steps'] > 3) {
                        $place['entrance_steps'] = '3+';
                    }
                    echo $place['entrance_steps'];
                ?>                
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>   
</div>
<?php if (!empty($place['place_reviews'])): ?>
<?php foreach($place['place_reviews'] as $review): ?>
<?php
    $review['url_like'] = $this->Html->url(array(
        'controller' => 'ajax', 
        'action' => 'likereview',
        '?' => array(
            'id' => $review['id']                
         )
    ));
    $review['url_unlike']  = $this->Html->url(array(
        'controller' => 'ajax', 
        'action' => 'likereview',
        '?' => array(
            'id' => $review['id'],
            'disable' => 1
         )
    ));
    $review['url_followuser'] = $this->Html->url(array(
        'controller' => 'ajax', 
        'action' => 'followuser',
        '?' => array(
            'id' => $review['user_id']                
         )
    ));
    $review['url_unfollowuser']  = $this->Html->url(array(
        'controller' => 'ajax', 
        'action' => 'followuser',
        '?' => array(
            'id' => $review['user_id'],
            'disable' => 1
         )
    ));
?>
<div class="tlBot" data-id="<?php echo $place['id'] ?>" onclick="return goLeftSpotDetail($(this), null, null, true)">
    <div class="tlBotItem">
        <div class="tlBotItemInfo">
            <a
                href='#'
                onclick="event.stopPropagation(); showLeftUser(<?php echo $review['user_id']?>, true);"
                class="tlBotItemInfoImage"
                style="background-image: url(<?php echo $review['image_path'] ?>)"
            </a>
            <a 
                href='#'
                onclick="event.stopPropagation(); showLeftUser(<?php echo $review['user_id']?>, true);"
                class="tlBotItemInfoName">
                <?php echo $review['name'] ?>
            </a>
            <?php if(!empty($review['user_physical_type_id'])): ?>
            <div class="tlUserPhysicalTypeId" data-id="<?php echo $review['user_physical_type_id'] ?>"></div>
            <?php endif; ?>
            <div class="tlBotItemInfoDate">
                <?php echo date('Y-m-d', $review['created']) ?>
            </div>
        </div>
        <div class="tlBotItemDetail">
            <?php echo $review['comment'] ?>
        </div>
    </div>
    <div class="tlBotTotal">
        <div class="tlBotTotalLike">
            <span class="count-like-<?php echo $review['id'] ?>">
                <?php echo sprintf(__('TEXT_HOW_MANY_LIKE'), !empty($review['count_like']) ? $review['count_like'] : 0); ?>
            </span>
        </div>
        <div class="tlBotTotalComment">
            <span class="count-comment-<?php echo $review['id'] ?>">
                <?php echo sprintf(__('TEXT_HOW_MANY_COMMENT'), !empty($review['count_comment']) ? $review['count_comment'] : 0); ?>
            </span>
        </div>
    </div>
    <div class="tlBotBtns">
        <!-- Follow -->
        <?php if(empty($AppUI->id) || (!empty($AppUI->id) && $AppUI->id != $review['user_id'])):?>
        <div class="tlBotBtnFollow noselect ajax-submit <?php echo ($review['is_follow_user'] ? 'unfollow' : 'follow')?>"
           data-url="<?php 
                echo ($review['is_follow_user'] ? $review['url_unfollowuser'] : $review['url_followuser']);
            ?>"
            data-callback="
               if (btn.hasClass('follow')) {
                    btn.removeClass('follow');
                    btn.addClass('unfollow');
                    btn.text('<?php echo __('LABEL_FOLLOWING');?>');
                    btn.data('url', '<?php echo $review['url_unfollowuser']?>');
                } else {
                    btn.removeClass('unfollow');
                    btn.addClass('follow');
                    btn.text('<?php echo __('LABEL_FOLLOW');?>');
                    btn.data('url', '<?php echo $review['url_followuser']?>');
                }
            ">
            <?php echo ($review['is_follow_user'] ? __('LABEL_FOLLOWING') :  __('LABEL_FOLLOW') );?>
        </div>
        <?php endif?>
        
        <!-- Comment -->
        <div class="tlBotBtnComment noselect" onclick="event.stopPropagation(); showReviewCommentPopup(<?php echo $review['id']?>)">
            <?php echo __('LABEL_COMMENT');?>
        </div>
        
        <!-- Like -->
        <div class="tlBotBtnLike noselect ajax-submit <?php echo ($review['is_like'] ? 'unlike' : 'like')?>"
            data-url="<?php 
                echo ($review['is_like'] ? $review['url_unlike'] : $review['url_like']);
            ?>"
            data-callback="    
                var id = <?php echo $review['id']?>;
                var cnt = parseInt($('.count-like-'+id).html());
                if (btn.hasClass('like')) { 
                    cnt++;                                       
                    btn.removeClass('like');
                    btn.addClass('unlike');
                    btn.data('url', '<?php echo $review['url_unlike']?>');
                } else {
                    cnt--;
                    btn.removeClass('unlike');
                    btn.addClass('like');
                    btn.data('url', '<?php echo $review['url_like']?>');
                }
                if ($('.count-like-'+id).length > 0) {
                    $('.count-like-'+id).html(cnt);
                }
            ">
           <?php echo __('LABEL_LIKE');?>
        </div>
       
    </div>
</div>
<?php endforeach; ?>
<?php endif; ?>
<?php endforeach; ?>
<?php if (!$this->request->is('ajax')) : ?>
</div>
<?php endif; ?>