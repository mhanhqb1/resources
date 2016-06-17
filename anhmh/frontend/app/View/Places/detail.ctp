<?php
    if (empty($place['id'])) {
        $place['id'] = 0;
    }
    if (empty($place['google_place_id'])) {
        $place['google_place_id'] = '0';
    }
    if (empty($place['review_point'])) {
        $place['review_point'] = 0;
    }
    //$place['review_point'] = round($place['review_point'], 1);
    $categoryImagePath = Configure::read('Config.categoryImagePath');
    if (empty($place['place_category_type_id'])) {
        $place['place_category_type_id'] = 0;        
    }
    $place['place_category_image_path'] = BASE_URL . '/' . $categoryImagePath[$place['place_category_type_id']]; 
    $facilityIcon = array();
    foreach(Configure::read('Config.placeFacilityIcon') as $key => $icon) {
        if (!empty($place[$key]) && $place[$key] > 0) {
            $facilityIcon[] = array(
                'total' => $place[$key],
                'icon' => BASE_URL . '/' . $icon
            );
        }
    }
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
<div id="leftSpotContainerDetail" data-place_id="<?php echo $place['id'] ?>" data-google_place_id="<?php echo $place['google_place_id'] ?>">
    <script type="text/javascript">
        var __placeDetailJson = <?php echo json_encode($place) ?>;
        var __myReview = <?php echo !empty($place['my_review']) ? json_encode($place['my_review']) : 'null' ?>;
    </script>
    <div id="leftSpotDetailHeaderContainer">       
        <div id="leftSpotDetailHeader" 
             onclick="return backSideView();">
        </div>      
        <div class="closeLeftSpotDetail" onclick="closeLeftSpotDetail()"></div>
    </div>
    <div id="leftSpotDetailContainer">
        <div id="leftSpotDetailBanner" style="background-image: url(<?php if (!empty($place['place_image_path'])) echo $place['place_image_path'] ?>);">
            <div class="leftSpotItemTotalLike noselect">
                <span class="leftSpotItemTotalLikeNumber"><?php echo !empty($place['count_favorite']) ? $place['count_favorite'] : '0' ?></span><span><?php echo __('LABEL_PLACE_WANT_TO_GO');?></span>
            </div>
            <?php if(!empty($place['indoor_url'])): ?>
            <a id="leftSpotDetailIndoorView" href="<?php echo htmlspecialchars($place['indoor_url']) ?>" style="background-image: url('<?php
                $indoorImageUrl = BASE_URL . '/img/ico_indoor.png';
                if (Configure::read('Config.language') == 'eng') {
                    $indoorImageUrl = BASE_URL . '/img/ico_indoor_en.png';
                }
                echo $indoorImageUrl;
                ?>')" target="_blank">
            </a>
            <?php endif; ?>
        </div>

        <div id="leftSpotDetailHeadline">
            <div id="leftSpotDetailTitleText">
                <?php echo !empty($place['name']) ? $place['name'] : '' ?>
            </div>
            <?php if (!empty($place['distance'])) :?>
            <div id="leftSpotDetailDistance">
                <?php echo __('LABEL_DISTANCE_BEFORE');?><?php echo ($place['distance'] < 1000) ? number_format($place['distance']) ."m" : number_format($place['distance']/1000) ."km";?><?php echo __('LABEL_DISTANCE_AFTER');?>
            </div>
            <?php endif ?>
        </div>

        <div id="leftSpotDetailGoInfo" onclick="goSpotInfoFromDetail()" class="noselect">
            <?php echo __('LABEL_DISPLAY_BASIC_INFORMATION');?>
        </div>

        <div id="leftSpotDetailReview" class="noselect">
            <div id="leftSpotDetailReviewIcon">
                <img src="<?php echo $place['place_category_image_path'] ?>"/>
                <!--div class="category">
                    <?php if (!empty($place['place_category_name'])) : ?>
                    <span class="categoryName"><?php echo $place['place_category_name'] ?></span>
                    <?php endif ?>
                    
                    <?php if (!empty($place['place_sub_category_name'])) : ?>
                    <span class="subCategoryName"><?php echo $place['place_sub_category_name'] ?></span>
                    <?php endif ?>
                </div-->
            </div>
            <div id="leftSpotDetailReviewDetail">
                <div id="leftSpotDetailReviewDetailTitle">
                    <?php echo __('LABEL_SPOT_REVIEW');?>
                </div>
                <div id="leftSpotDetailReviewDetailFace">
                    <div class="leftSpotDetailReviewDetailFace<?php if ($place['review_point'] >= 1) echo " on" ?>" id="leftSpotDetailReviewDetailFace1"></div>
                    <div class="leftSpotDetailReviewDetailFace<?php if ($place['review_point'] >= 2) echo " on" ?>" id="leftSpotDetailReviewDetailFace2"></div>
                    <div class="leftSpotDetailReviewDetailFace<?php if ($place['review_point'] >= 3) echo " on" ?>" id="leftSpotDetailReviewDetailFace3"></div>
                    <div class="leftSpotDetailReviewDetailFace<?php if ($place['review_point'] >= 4) echo " on" ?>" id="leftSpotDetailReviewDetailFace4"></div>
                    <div class="leftSpotDetailReviewDetailFace<?php if ($place['review_point'] >= 5) echo " on" ?>" id="leftSpotDetailReviewDetailFace5"></div>
                </div>
                <div id="leftSpotDetailReviewDetailNumber">
                    <?php echo ($place['review_point'] > 0 ? $place['review_point'] : '-') ?>
                </div>
            </div>
            
            <div id="leftSpotDetailReviewTotal" class="leftSpotDetailReviewNumber">
                <div id="leftSpotDetailReviewNumberTitle">
                    <?php echo __('LABEL_REVIEWER_NUMBER') ?>
                </div>            
                <div id="leftSpotDetailReviewNumberValue">
                    <?php echo !empty($place['count_review']) ? ($place['count_review']) : '0' ?><?php echo __('LABEL_REVIEWER_NUMBER_MARK') ?>
                </div>           
            </div>
        </div>
        <div id="leftSpotDetailEntryStep" class="noselect">
            <div id="leftSpotDetailEntryStepTop">
                <div id="leftSpotDetailEntryStepTopContainer">
                    <div id="leftSpotDetailEntryStepTopLeft">
                        <?php echo __('LABEL_ENTRY_STEPS');?>
                    </div>
                    <div id="leftSpotDetailEntryStepTopRight">
                        <div id="leftSpotDetailEntryStepTopLeftRank">
                            <div class="leftSpotDetailEntryStepTopLeftRankItem<?php if ($place['entrance_steps'] >= 0) echo " on" ?>" id="leftSpotDetailEntryStepTopLeftRankItem1"><div></div></div>
                            <div class="leftSpotDetailEntryStepTopLeftRankItem<?php if ($place['entrance_steps'] >= 1) echo " on" ?>" id="leftSpotDetailEntryStepTopLeftRankItem2"><div></div></div>
                            <div class="leftSpotDetailEntryStepTopLeftRankItem<?php if ($place['entrance_steps'] >= 2) echo " on" ?>" id="leftSpotDetailEntryStepTopLeftRankItem3"><div></div></div>
                            <div class="leftSpotDetailEntryStepTopLeftRankItem<?php if ($place['entrance_steps'] >= 3) echo " on" ?>" id="leftSpotDetailEntryStepTopLeftRankItem4"><div></div></div>
                            <div class="leftSpotDetailEntryStepTopLeftRankItem<?php if ($place['entrance_steps'] >= 4) echo " on" ?>" id="leftSpotDetailEntryStepTopLeftRankItem5"><div></div></div>
                        </div>
                        <div id="leftSpotDetailEntryStepTopLeftNumber">
                            <?php 
                                if (empty($place['entrance_steps'])) {
                                    echo 0;
                                } elseif ($place['entrance_steps'] > 3) {
                                    echo '3+';
                                } elseif ($place['entrance_steps'] == -1) {
                                    echo '-';
                                } else {
                                    echo $place['entrance_steps'];
                                }                        
                            ?>                    
                        </div>
                    </div>
                </div>
            </div>

            <?php if (!empty($facilityIcon)): ?>
            <div id="leftSpotDetailEntryStepBottom">
                <div id="leftSpotDetailEntryStepBottomContainer">
                    <div id="leftSpotDetailEntryStepBottomLeft">
                        <?php echo __('LABEL_FACILITY_DETAIL');?>
                    </div>
                    <div id="leftSpotDetailEntryStepBottomRight">
                        <?php                    
                            foreach($facilityIcon as $icon) {
                                echo "
                                    <div class=\"leftSpotDetailEntryStepBottomRightItem noselect\">
                                        <div class=\"leftSpotDetailEntryStepBottomRightItemImage\">
                                            <span><img src=\"{$icon['icon']}\"/></span>
                                        </div>
                                        <div class=\"leftSpotDetailEntryStepBottomRightItemNumber\">{$icon['total']}</div>
                                    </div>
                                ";                        
                            }
                        ?>                           
                    </div>
                </div>
            </div>
            <?php endif; ?>

        </div>

        <div id="leftSpotDetailNav">       
            <div id="leftSpotDetailNavRoute" class="noselect" onclick="window.open('http://maps.google.com/?q=<?php echo $place['latitude'] ?>,<?php echo $place['longitude'] ?>','_blank' );">
                <div class="leftSpotDetailNavItem">
                    <div class="leftSpotDetailNavItemImage">
                        <img src="<?php echo BASE_URL ?>/img/route.png"/>
                    </div>
                    <div class="leftSpotDetailNavText">
                        <?php echo __('LABEL_SHOW_ROUTE');?>
                    </div>
                </div>
            </div>
            <div id="leftSpotDetailNavPost" class="noselect" onclick="<?php
                if (!empty($AppUI->id)) {
                    echo "return showReviewSubmitPopup(" . $place['id'] . ", '" . $place['google_place_id'] . "')";
                } else {
                    echo "return showGuestPopup();";
                }
            ?>">
                <div class="leftSpotDetailNavItem">
                    <div class="leftSpotDetailNavItemImage">
                        <img src="<?php echo BASE_URL ?>/img/edit.png"/>
                    </div>
                    <div class="leftSpotDetailNavText">
                        <?php echo __('LABEL_DO_SUBMIT');?>
                    </div>
                </div>
            </div>
            <div id="leftSpotDetailNavShare" class="noselect" onclick="showShareUrlPopup('<?php echo !empty($place['share_url']) ? $place['share_url'] : BASE_URL ?>')">
                <div class="leftSpotDetailNavItem">
                    <div class="leftSpotDetailNavItemImage">
                        <img src="<?php echo BASE_URL ?>/img/share.png"/>
                    </div>
                    <div class="leftSpotDetailNavText">
                        <?php echo __('LABEL_DO_SHARE');?>
                    </div>
                </div>
            </div>
        </div>

        <?php if (!empty($place['place_images'])): ?>
        <div id="leftSpotDetailGallery">        
            <?php foreach($place['place_images'] as $image): ?>
            <a class="leftSpotDetailGalleryItem" 
                 data-lightbox="place_images"
                 href="<?php echo $image['image_path'] ?>"
                 target="_blank"
                 style="background-image: url(<?php echo $image['thm_image_path'] ?>);">
            </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <?php if (!empty($place['place_reviews'])): ?>
        <div id="leftSpotDetailEveryonePost">
            <div id="leftSpotDetailEveryonePostTitle">
                <?php echo __('LABEL_REVIEW_EVERYONE_SUBMITED');?>
            </div>
            <?php foreach($place['place_reviews'] as $r => $review): ?>
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
            <div data-id="<?php echo $review['id']?>" class="reviewItem<?php if ($r >= 2) echo ' reviewMore';?>">
                <div class="leftSpotDetailEveryonePostDetail">
                    <div id="leftSpotDetailEveryonePostUser">
                        <a  href='#'
                            onclick="return showLeftUser(<?php echo $review['user_id']?>);"
                            id="leftSpotDetailEveryonePostUserImage"
                            style="background-image: url(<?php echo $review['image_path'] ?>)"
                        >
                        </a>
                        <a
                            href='#'
                            onclick="return showLeftUser(<?php echo $review['user_id']?>);"
                            class="leftSpotDetailEveryonePostUserName"
                        >
                            <?php echo $review['name'] ?>
                        </a>
                    </div>
                    <div class="leftSpotDetailEveryonePostDate">
                        <?php if (!empty($review['has_review'])): ?>
                        <div
                            class="leftSpotDetailReviewHistory noselect"
                            onclick="return showPlaceReviewHistory(<?php echo $review['place_id'] ?>, <?php echo $review['user_id'] ?>)">
                            <?php echo __('LABEL_HISTORY');?>
                        </div>
                        <?php endif; ?>
                        
                        <?php echo date('Y-m-d', $review['created']) ?>
                    </div>
                    <div class="leftSpotDetailEveryonePostContent"> 
                        <?php echo nl2br($review['comment']) ?>
                    </div>

                    <div class="leftSpotDetailEveryonePostButton">                    

                        <!-- Like review -->
                        <div class="leftSpotDetailEveryonePostButtonLike noselect ajax-submit <?php echo ($review['is_like'] ? 'unlike' : 'like')?>"
                             data-url="<?php 
                                echo ($review['is_like'] ? $review['url_unlike'] : $review['url_like']);
                             ?>"
                             data-callback="      
                                if (btn.hasClass('like')) {
                                    btn.removeClass('like');
                                    btn.addClass('unlike');
                                    btn.data('url', '<?php echo $review['url_unlike']?>');
                                } else {
                                    btn.removeClass('unlike');
                                    btn.addClass('like');
                                    btn.data('url', '<?php echo $review['url_like']?>');
                                }
                            ">
                            <?php echo __('LABEL_LIKE');?>
                        </div>

                        <!-- Comment -->
                        <div
                            class="leftSpotDetailEveryonePostButtonComment noselect"
                            onclick="return showReviewCommentPopup(<?php echo $review['id']?>)">
                            <?php echo __('LABEL_COMMENT');?>
                        </div>

                        <!-- Follow user -->
                        <?php if(empty($AppUI->id) || (!empty($AppUI->id) && $AppUI->id != $review['user_id'])):?>
                        <?php if (!empty($AppUI->id)): ?>
                        <div class="leftSpotDetailEveryonePostButtonShare noselect" onclick="showShareUrlPopup('<?php echo !empty($place['share_url']) ? $place['share_url'] : BASE_URL ?>')">
                            <?php echo __('LABEL_SHARE_URL'); ?>
                        </div>
                        <?php else: ?>
                        <div class="leftSpotDetailEveryonePostButtonShare noselect follow">
                            <?php echo __('LABEL_SHARE_URL') ?>
                        </div>
                        <?php endif?>
                        <?php endif?>
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
                        <div id="leftSpotDetailEveryonePostReviewPointNumber"><?php echo ($review['review_point'] > 0 ? $review['review_point'] : '-') ?></div>
                    </div>
                    <?php if (!empty($review['place_images'])): ?>
                    <div id="leftSpotDetailEveryonePostReviewPointImages">
                        <?php if (!empty($review['place_images'][0])): ?>
                        <a 
                            data-lightbox="place_images_review_<?php echo $review['id'] ?>"
                            href="<?php echo $review['place_images'][0]['image_path'] ?>"
                            target="_blank"
                            id="leftSpotDetailEveryonePostReviewPointImageLeft" 
                            style="background-image: url(<?php echo $review['place_images'][0]['thm_image_path'] ?>)">
                        </a>
                        <?php endif; ?>

                        <?php if (!empty($review['place_images'][1])): ?>
                        <a 
                            data-lightbox="place_images_review_<?php echo $review['id'] ?>"
                            href="<?php echo $review['place_images'][1]['image_path'] ?>"
                            target="_blank"
                            id="leftSpotDetailEveryonePostReviewPointImageRight" 
                            style="background-image: url(<?php echo $review['place_images'][1]['thm_image_path'] ?>)">
                        </a>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <?php if (!empty($place['count_review']) && $place['count_review'] > 2): ?>
        <div id="leftSpotDetailReviewMore" 
             class="noselect"
             onclick="
                 $('.reviewMore').show();
                 $(this).hide();
             "
        >
            <?php echo __('LABEL_READ_MORE_SUBMIT');?>
        </div>
        <?php endif; ?>    

        <?php if(!empty($AppUI->id)): ?>
        <div id="leftSpotDetailGo" 
            class="noselect ajax-submit <?php echo ($place['is_favorite'] ? 'unfavorite' : 'favorite')?>"
            data-url="<?php 
                 echo ($place['is_favorite'] ? $place['url_unfavorite'] : $place['url_favorite']);
            ?>"
            data-callback="      
                if (btn.hasClass('favorite')) {
                    $('#leftSpotDetailBanner .leftSpotItemTotalLikeNumber').html(parseInt($('#leftSpotDetailBanner .leftSpotItemTotalLikeNumber').html())+1);                
                    btn.removeClass('favorite');
                    btn.addClass('unfavorite');
                    btn.data('url', '<?php echo $place['url_unfavorite']?>');
                } else {
                    $('#leftSpotDetailBanner .leftSpotItemTotalLikeNumber').html(parseInt($('#leftSpotDetailBanner .leftSpotItemTotalLikeNumber').html())-1);
                    btn.removeClass('unfavorite');
                    btn.addClass('favorite');
                    btn.data('url', '<?php echo $place['url_favorite']?>');
                }
            "
        >
            <div id="leftSpotDetailGoImage"></div>
            <span id="leftSpotDetailGoText"> <?php echo __('LABEL_PLACE_WANT_TO_GO');?></span>
            <span id="leftSpotDetailGoTextRemove"> <?php echo __('LABEL_DELETE_PLACE_WANT_TO_GO');?></span>
        </div>
        <?php else: ?>
        <div id="leftSpotDetailGo" class="noselect favorite" onclick="return showGuestPopup();">
            <div id="leftSpotDetailGoImage"></div>
            <span id="leftSpotDetailGoText"> <?php echo __('LABEL_PLACE_WANT_TO_GO');?></span>
        </div>
        <?php endif; ?>
    </div>
</div>

<div id="leftSpotContainerInfo" style="display:none;">
    <div id="leftSpotInfoHeaderContainer">
        <div id="leftSpotInfoHeader"  onclick="$('#leftSpotContainerDetail').show();$('#leftSpotContainerInfo').hide();$('#leftSpotContainerEdit').hide();"></div>
        <div class="closeLeftSpotDetail" onclick="closeLeftSpotDetail()"></div>
        <div id="leftSpotInfoTitle">
            <?php echo __('LABEL_BASIC_INFORMATION');?>
            <div id="leftSpotInfoGoEdit" class="noselect" onclick="<?php
                if (!empty($AppUI->id)) {
                    echo "return goSpotEditFromInfo();";
                } else {
                    echo "return showGuestPopup();";
                }
            ?>">
                <?php echo __('LABEL_EDIT_BASIC_INFORMATION');?>
            </div>
        </div>
    </div>
    <div id="leftSpotInfoContainer">
        <div class="leftSpotInfoTable">
            <div class="leftSpotInfoRow" id="leftSpotInfoName">
                <div class="leftSpotInfoRowLeft">
                    <?php echo __('LABEL_SPOT_NAME');?>
                </div>
                <div class="leftSpotInfoRowRight">
                    <?php echo !empty($place['name']) ? $place['name'] : '' ?>
                    <div id="leftSpotContainerInfoNameKana">
                        <?php echo !empty($place['name_kana']) ? $place['name_kana'] : '' ?>
                    </div>
                </div>
            </div>
            <div class="leftSpotInfoRow" id="leftSpotInfoCategory">
                <div class="leftSpotInfoRowLeft">
                    <?php echo __('LABEL_CATEGORY');?>
                </div>
                <div class="leftSpotInfoRowRight">
                    <?php echo !empty($place['place_category_name']) ? $place['place_category_name'] : '-' ?>
                </div>
            </div>
            <div class="leftSpotInfoRow" id="leftSpotInfoGenre">
                <div class="leftSpotInfoRowLeft">
                    <?php echo __('LABEL_GENRE');?>
                </div>
                <div class="leftSpotInfoRowRight">
                    <?php
                        $_subCategoryTmp = '';
                        if (!empty($place['subcategories'])) {
                            foreach($place['subcategories'] as $subcategory) {
                                if($subcategory['type_id'] == $place['place_sub_category_type_id']) {
                                    $_subCategoryTmp = $subcategory['name'];
                                }
                            }
                        }
                        echo !empty($_subCategoryTmp) ? $_subCategoryTmp : '-';
                    ?>
                </div>
            </div>
            <div class="leftSpotInfoRow" id="leftSpotInfoAddress">
                <div class="leftSpotInfoRowLeft">
                    <?php echo __('LABEL_ADDRESS');?>
                </div>
                <div class="leftSpotInfoRowRight">
                    <?php echo !empty($place['address']) ? $place['address'] : '-' ?>
                </div>
            </div>
            <div class="leftSpotInfoRow" id="leftSpotInfoPhone">
                <div class="leftSpotInfoRowLeft">
                    <?php echo __('LABEL_TEL_NUMBER');?>
                </div>
                <div class="leftSpotInfoRowRight">
                    <?php echo !empty($place['tel']) ? $place['tel'] : '-' ?>
                </div>
            </div>
            <div class="leftSpotInfoRow" id="leftSpotInfoIndoorView">
                <div class="leftSpotInfoRowLeft">
                    <?php echo __('LABEL_INDOOR_VIEW');?>
                </div>
                <div class="leftSpotInfoRowRight">
                    <?php if (!empty($place['indoor_url'])): ?>
                    <a href="<?php echo htmlspecialchars($place['indoor_url']) ?>" target="_blank">
                        <?php echo $place['indoor_url'] ?>
                    </a>
                    <?php else: ?>
                    -
                    <?php endif; ?>
                </div>
            </div>
            <div class="leftSpotInfoRow" id="leftSpotInfoEquipmentDetail">
                <div class="leftSpotInfoRowLeft">
                    <?php echo __('LABEL_LICENSE');?>
                </div>
                <div class="leftSpotInfoRowRight">
                    <?php echo !empty($place['license']) ? nl2br(trim($place['license'])) : '-' ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="leftSpotContainerEdit" style="display:none">
    <div id="leftSpotEditHeaderContainer">
        <div id="leftSpotEditHeader" onclick="$('#leftSpotContainerDetail').hide();$('#leftSpotContainerInfo').show();$('#leftSpotContainerEdit').hide();"></div>
        <div class="closeLeftSpotDetail" onclick="closeLeftSpotDetail()"></div>
        <div id="leftSpotEditTitle">
            <?php echo __('LABEL_MODIFY_BASIC_INFORMATION');?>
        </div>
    </div>
    <div id="leftSpotEditContainer">
        <form id="leftSpotEditForm" method="POST">
            <div class="leftSpotEditTable">
                <div class="leftSpotEditRow">
                    <div class="leftSpotEditRowLeft">
                        <?php echo __('LABEL_SPOT_NAME');?>
                    </div>
                    <div class="leftSpotEditRowRight">
                        <input type="text" name="data[Spot][name]" value="<?php echo !empty($place['name']) ? htmlspecialchars($place['name']) : '' ?>"/>
                    </div>
                </div>
                <div class="leftSpotEditRow">
                    <div class="leftSpotEditRowLeft">
                        <?php echo __('LABEL_CATEGORY');?>
                    </div>
                    <div class="leftSpotEditRowRight">
                        <select 
                            onchange="return loadSubCategories(this.value);"
                            name="data[Spot][place_category_type_id]" 
                            class="leftSpotEditCustomSelectbox">
                            <option value=""><?php echo __('MESSAGE_SELECT_FROM_PULLDOWN');?></option>
                            <?php if (!empty($place['categories'])) : ?>
                            <?php foreach($place['categories'] as $category): ?>
                            <option <?php if($category['type_id'] == $place['place_category_type_id']) echo "selected=\"selected\"" ?>value="<?php echo $category['type_id'] ?>"><?php echo $category['name'] ?></option>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
                <div class="leftSpotEditRow">
                    <div class="leftSpotEditRowLeft">
                        <?php echo __('LABEL_GENRE');?>
                    </div>
                    <div class="leftSpotEditRowRight">
                        <select 
                            id="place_sub_category_type_id"
                            name="data[Spot][place_sub_category_type_id]" 
                            class="leftSpotEditCustomSelectbox">
                            <option value=""><?php echo __('MESSAGE_SELECT_FROM_PULLDOWN');?></option>
                            <?php if (!empty($place['subcategories'])) : ?>
                            <?php foreach($place['subcategories'] as $subcategory): ?>
                            <option <?php if($subcategory['type_id'] == $place['place_sub_category_type_id']) echo "selected=\"selected\"" ?>value="<?php echo $subcategory['type_id'] ?>"><?php echo $subcategory['name'] ?></option>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
                <div class="leftSpotEditRow">
                    <div class="leftSpotEditRowLeft">
                        <?php echo __('LABEL_ADDRESS');?>
                    </div>
                    <div class="leftSpotEditRowRight">
                        <input type="text" name="data[Spot][address]" value="<?php echo !empty($place['address']) ? htmlspecialchars($place['address']) : '' ?>"/>
                    </div>
                </div>
                <div class="leftSpotEditRow">
                    <div class="leftSpotEditRowLeft">
                        <?php echo __('LABEL_TEL_NUMBER');?>
                    </div>
                    <div class="leftSpotEditRowRight">
                        <input type="text" name="data[Spot][tel]" value="<?php echo !empty($place['tel']) ? htmlspecialchars($place['tel']) : '' ?>"/>
                    </div>
                </div>
                <div class="leftSpotEditRow">
                    <div class="leftSpotEditRowLeft">
                        <?php echo __('LABEL_INDOOR_VIEW');?>
                    </div>
                    <div class="leftSpotEditRowRight">
                        <input type="text" name="data[Spot][indoor_url]" value="<?php echo !empty($place['indoor_url']) ? htmlspecialchars($place['indoor_url']) : '' ?>"/>
                    </div>
                </div>
            </div>
            <button 
                type="button" 
                id="leftSpotEditSubmit"
                class="ajax-submit" 
                data-url="<?php 
                     echo $this->Html->url(array(
                         'controller' => 'places', 
                         'action' => 'save',
                         '?' => array(
                             'id' => $place['id'],
                             'google_place_id' => $place['google_place_id']
                          )
                     ))
                ?>"
                data-callback=" 
                    loadDetailSpot(<?php echo $place['id']?>, 2, '<?php echo $place['google_place_id']?>', null, <?php echo (!empty($param['openFromOutSide'])) ? 'true' : 'false' ?>);
                 "
            >
                <img src="<?php echo BASE_URL ?>/img/pencial.png"/>
                <?php echo __('LABEL_EDIT');?>
            </button>
            <button type="button" id="leftSpotDeleteReport" onclick="<?php
                if (!empty($AppUI->id)) {
                    echo "return confirmDeleteReportSpot(" . $place['id'] . ", " . ((!empty($place['user_id']) && $place['user_id'] == $AppUI->id) ? 'true' : 'false') . ");";
                } else {
                    echo "return showGuestPopup();";
                }
            ?>">
                <img src="<?php echo BASE_URL ?>/img/buttonCancel.png"/>
                <?php echo __('LABEL_DELETE') ?>
            </button>
        </form>
    </div>
</div>
