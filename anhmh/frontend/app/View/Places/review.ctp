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
<div id="dlgPopupReviewCommentHeader">
    <div id="dlgPopupReviewCommentTitle"><?php echo __('LABEL_SPOT_REVIEW');?></div>
    <div id="dlgPopupReviewCommentUserTool">
        <a
            id="dlgPopupReviewCommentUserImage"
            style="background-image: url(<?php echo !empty($review['image_path']) ? $review['image_path'] : BASE_URL . '/img/avatar.png' ?>)"
            href='#'
            onclick="return showLeftUser(<?php echo $review['user_id']?>);">
        </a>
        <a  id="dlgPopupReviewCommentUserName" 
            href='#'
            onclick="return showLeftUser(<?php echo $review['user_id']?>);">        
            <?php echo !empty($review['name']) ? $review['name'] : '' ?>
        </a>
        
        <?php if(!empty($AppUI->id)): ?>
        <div 
            class="dlgPopupReviewCommentButtonFollow noselect ajax-submit <?php echo ($review['is_follow_user'] ? 'unfollow' : 'follow')?>"
            data-url="<?php 
                echo ($review['is_follow_user'] ? $review['url_unfollowuser'] : $review['url_followuser']);
            ?>"
            data-callback="
               if (btn.hasClass('follow')) {
                    btn.removeClass('follow');
                    btn.addClass('unfollow');
                    btn.text('<?php echo __('LABEL_UNFOLLOW');?>');
                    btn.data('url', '<?php echo $review['url_unfollowuser']?>');
                } else {
                    btn.removeClass('unfollow');
                    btn.addClass('follow');
                    btn.text('<?php echo __('LABEL_FOLLOW');?>');
                    btn.data('url', '<?php echo $review['url_followuser']?>');
                }
            ">
            <?php echo $review['is_follow_user'] ? __('LABEL_UNFOLLOW') : __('LABEL_FOLLOW') ?>
        </div>
        <?php else: ?>
        <div class="dlgPopupReviewCommentButtonFollow noselect follow" onclick="return showGuestPopup()">
            <?php echo __('LABEL_FOLLOW');?>
        </div>
        <?php endif; ?>
        
        <?php if(!empty($AppUI->id)): ?>
        <div 
            class="dlgPopupReviewCommentButtonLike noselect ajax-submit <?php echo ($review['is_like'] ? 'unlike' : 'like')?>"
            data-url="<?php 
                echo ($review['is_like'] ? $review['url_unlike'] : $review['url_like']);
            ?>"
            data-callback="    
                var id = <?php echo $review['id']?>;
                var cnt = parseInt($('#dlgPopupReviewComment #dlgPopupReviewCommentTotalLike span').html());
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
                $('#dlgPopupReviewComment #dlgPopupReviewCommentTotalLike span').html(cnt); 
                if ($('.count-like-'+id).length > 0) {
                    $('.count-like-'+id).html(cnt);
                }
            ">
            <?php echo __('LABEL_LIKE');?>
        </div>
        <?php else: ?>
        <div class="dlgPopupReviewCommentButtonLike noselect like" onclick="return showGuestPopup()">
            <?php echo __('LABEL_LIKE');?>
        </div>
        <?php endif; ?>
    </div>
    <div class="leftSpotDetailEveryonePostReviewPoint">
        <div class="leftSpotDetailEveryonePostReviewPointTitle">
            <?php echo __('LABEL_SPOT_REVIEW');?>
        </div>
        <div id="leftSpotDetailEveryonePostReviewPointFaces">
            <div class="leftSpotDetailEveryonePostReviewPointFace<?php if ($review['review_point'] >= 1) echo " on" ?>" id="leftSpotDetailEveryonePostReviewPointFace1"></div>
            <div class="leftSpotDetailEveryonePostReviewPointFace<?php if ($review['review_point'] >= 2) echo " on" ?>" id="leftSpotDetailEveryonePostReviewPointFace2"></div>
            <div class="leftSpotDetailEveryonePostReviewPointFace<?php if ($review['review_point'] >= 3) echo " on" ?>" id="leftSpotDetailEveryonePostReviewPointFace3"></div>
            <div class="leftSpotDetailEveryonePostReviewPointFace<?php if ($review['review_point'] >= 4) echo " on" ?>" id="leftSpotDetailEveryonePostReviewPointFace4"></div>
            <div class="leftSpotDetailEveryonePostReviewPointFace<?php if ($review['review_point'] >= 5) echo " on" ?>" id="leftSpotDetailEveryonePostReviewPointFace5"></div>
        </div>
        <div id="leftSpotDetailEveryonePostReviewPointNumber"><span><?php echo ($review['review_point'] > 0 ? $review['review_point'] : '-') ?></div>
    </div>
    <div id="dlgPopupReviewCommentContent">
        <?php echo nl2br($review['comment']) ?>
    </div>
    <div id="dlgPopupReviewCommentTotal">
        <div id="dlgPopupReviewCommentTotalLike">
            <?php echo sprintf(__('TEXT_HOW_MANY_LIKE'), !empty($review['count_like']) ? $review['count_like'] : 0); ?>
        </div>
        <div id="dlgPopupReviewCommentTotalComment">
            <?php echo sprintf(__('TEXT_HOW_MANY_COMMENT'), !empty($review['count_comment']) ? $review['count_comment'] : 0); ?>
        </div>
    </div>
</div>
    
<div id="dlgPopupReviewCommentContainer">        
    <div id="dlgPopupReviewCommentItems">
        <div id="dlgPopupReviewCommentNewItem" style="display:none">
            <?php if (!empty($AppUI->id)) : ?>
            <div class="dlgPopupReviewCommentItem">
                <a
                    class="dlgPopupReviewCommentItemLeft"
                    href='#'
                    onclick="return showLeftUser(<?php echo $AppUI->id?>);"
                    style="background-image: url(<?php echo !empty($AppUI->image_path) ? $AppUI->image_path : BASE_URL . '/img/avatar.png' ?>)">
                </a>
                <div class="dlgPopupReviewCommentItemRight">
                    <div class="dlgPopupReviewCommentItemRightTop">
                        <a  href='#'
                            onclick="return showLeftUser(<?php echo $AppUI->id?>);">
                            <?php echo !empty($AppUI->name) ? $AppUI->name : '' ?>
                        </a>
                        <div class="dlgPopupReviewCommentItemDate">

                        </div>
                    </div>
                    <div class="dlgPopupReviewCommentItemDetail">

                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <?php foreach($review['place_review_comments'] as $comment): ?>
        <div class="dlgPopupReviewCommentItem">
            <a
                class="dlgPopupReviewCommentItemLeft"
                href='#'
                onclick="return showLeftUser(<?php echo $comment['user_id']?>);"
                style="background-image: url(<?php echo !empty($comment['image_path']) ? $comment['image_path'] : BASE_URL . '/img/avatar.png' ?>)">
            </a>
            <div class="dlgPopupReviewCommentItemRight">
                <div class="dlgPopupReviewCommentItemRightTop">
                    <a  href='#'
                        onclick="return showLeftUser(<?php echo $comment['user_id']?>);">
                        <?php echo !empty($comment['name']) ? $comment['name'] : '' ?>
                    </a>
                    <div class="dlgPopupReviewCommentItemDate"><?php echo date('Y-m-d', $comment['created']) ?></div>
                </div>
                <div class="dlgPopupReviewCommentItemDetail">
                    <?php echo nl2br($comment['comment']) ?>
                </div>
            </div>
        </div>        
        <?php endforeach; ?>
    </div>
    <div class="dlgPopupReviewCommentForm">
    <form 
        action="<?php echo $this->Html->url(array(
            'controller' => 'places', 
            'action' => 'review'
        ));?>"
        onsubmit="return submitComment(this);"
        method="POST">
        <input type="hidden" name="data[place_review_id]" value="<?php echo !empty($review['id']) ? $review['id'] : '0' ?>" />
        <input type="hidden" name="data[place_id]" value="<?php echo !empty($review['place_id']) ? $review['place_id'] : '0' ?>"/>
        <input 
            autocomplete="off"
            name="data[comment]" 
            id="dlgPopupReviewCommentInput" placeholder="<?php echo __('LABEL_COMMENT');?>" />
        <div id="dlgPopupReviewCommentFormBtn">
        <button id="dlgPopupReviewCommentBtnPost"
            type="submit">
            <?php echo __('LABEL_DO_SUBMIT');?>
        </button>
        <button id="dlgPopupReviewCommentBtnCancel"
            type="button">
            <?php echo __('LABEL_CANCEL');?>
        </button>
        </div>   
    </form>
    </div>
</div>