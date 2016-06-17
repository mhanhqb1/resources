<?php
    //$place['review_point'] = round($place['review_point'], 1);
    $categoryImagePath = Configure::read('Config.categoryImagePath');
    if (empty($categoryImagePath[$place['place_category_type_id']])) {
        $place['place_category_type_id'] = 0;        
    }
    $place['place_category_image_path'] = BASE_URL . '/' . $categoryImagePath[$place['place_category_type_id']]; 
    $facilityIcon = array();
    foreach(Configure::read('Config.placeFacilityIcon') as $key => $icon) {
        if (isset($place[$key]) && $place[$key] == 1 && count($facilityIcon) < 6) {
            $facilityIcon[] = BASE_URL . '/' . $icon;            
        }
    }
    $place['id'] = !empty($place['id']) ? $place['id'] : '0';
    $place['google_place_id'] = !empty($place['google_place_id']) ? $place['google_place_id'] : '0';
?>

<div
    class="leftSpotItem"
    data-id="<?php echo $place['id'] ?>"
    data-type-id="<?php echo $place['place_category_type_id'] ?>"
    onclick="return goLeftSpotDetail($(this))" 
    data-key="<?php echo $place['google_place_id'] . '-' . $place['id'] ?>"
    data-google-place-id="<?php echo $place['google_place_id'] ?>">
    
    <div
        class="leftSpotItemLeft"
        style="background-image: url(<?php if (!empty($place['place_image_path'])) echo $place['place_image_path'] ?>)">
    </div>
    
    <div class="leftSpotItemLeftContent">
        <?php if(!empty($is_ranking)): ?>
        <?php if($i == 0): ?>
        <div class="leftRankingItemLevel leftRankingItemLevel1"></div>
        <?php elseif($i == 1): ?>
        <div class="leftRankingItemLevel leftRankingItemLevel2"></div>
        <?php elseif($i == 2): ?>
        <div class="leftRankingItemLevel leftRankingItemLevel3"></div>
        <?php else: ?>
        <div class="leftRankingItemLevel leftRankingItemLevelOther"><?php echo $i+1; ?></div>
        <?php endif; ?>
        <?php else: ?>
        <div class="leftSpotItemTotalLike noselect">
            <span class="leftSpotItemTotalLikeNumber"><?php echo !empty($place['count_favorite']) ? $place['count_favorite'] : '0' ?></span><span><?php echo __('LABEL_PLACE_WANT_TO_GO');?></span>
        </div>
        <?php endif; ?>
        
        <div class="leftSpotItemLeftAddress">           
            <?php if (!empty($place['distance'])) :?>
            <div class="leftSpotItemLeftAddressTop"><?php echo __('LABEL_DISTANCE_BEFORE');?><?php echo ($place['distance'] < 1000) ? number_format($place['distance']) ."m" : number_format($place['distance']/1000) ."km";?><?php echo __('LABEL_DISTANCE_AFTER');?></div>
            <?php endif ?>
            <div class="leftSpotItemLeftAddressBot"><?php echo !empty($place['address']) ? $place['address'] : '' ?></div>
        </div>
    </div>
    
    <div class="leftSpotItemRight">
        <div class="leftSpotItemRightTop">
            <div class="leftSpotItemTitle">
                <?php echo !empty($place['name']) ? $place['name'] : '' ?>
            </div>
            <div class="leftSpotItemReview">
                <div class="leftSpotItemReviewIcon">
                    <img src="<?php echo $place['place_category_image_path'] ?>"/>
                </div>
                <div class="leftSpotItemReviewDetail">
                    <div class="leftSpotItemReviewLabel">
                        <?php echo __('LABEL_SPOT_REVIEW');?>
                    </div>
                    <div class="leftSpotItemReviewPoint">
                        <div class="leftSpotItemReviewPointFace leftSpotItemReviewPointFace1<?php if ($place['review_point'] >= 1) echo " on" ?>"></div>
                        <div class="leftSpotItemReviewPointFace leftSpotItemReviewPointFace2<?php if ($place['review_point'] >= 2) echo " on" ?>"></div>
                        <div class="leftSpotItemReviewPointFace leftSpotItemReviewPointFace3<?php if ($place['review_point'] >= 3) echo " on" ?>"></div>
                        <div class="leftSpotItemReviewPointFace leftSpotItemReviewPointFace4<?php if ($place['review_point'] >= 4) echo " on" ?>"></div>
                        <div class="leftSpotItemReviewPointFace leftSpotItemReviewPointFace5<?php if ($place['review_point'] >= 5) echo " on" ?>"></div>
                        <span><?php echo ($place['review_point'] > 0 ? $place['review_point'] : '-') ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="leftSpotItemRightBot">
            <div class="leftSpotItemEquipment">
                <div class="leftSpotItemEquipmentLabel">
                    <?php echo __('LABEL_FACILITY_DETAIL');?>
                </div>
                <?php if (!empty($facilityIcon)): ?>
                <div class="leftSpotItemEquipmentDetail">
                <?php                    
                    foreach($facilityIcon as $icon) {
                        echo "
                            <div class=\"leftSpotItemEquipmentItem\">
                                <img src=\"{$icon}\"/>
                            </div>
                        ";                        
                    }
                ?>                    
                </div>
                <?php else: ?>
                <span class="spotNotReview">
                    <?php echo __('LABEL_REVIEW_NO_FACILITY') ?>
                </span>
                <?php endif; ?>
            </div>
            <div class="leftSpotItemReviewChart">
                <div class="leftSpotItemReviewChartLabel">
                    <?php echo __('LABEL_ENTRY_STEPS');?>
                </div>
                <?php if(!empty($place['entrance_steps']) && $place['entrance_steps'] != -1): ?>
                <div class="leftSpotItemReviewChartDetail">
                    <div class="leftSpotItemReviewChartLevel leftSpotItemReviewChartLevel1<?php if ($place['entrance_steps'] >= 0) echo " on" ?>"></div>
                    <div class="leftSpotItemReviewChartLevel leftSpotItemReviewChartLevel2<?php if ($place['entrance_steps'] >= 1) echo " on" ?>"></div>
                    <div class="leftSpotItemReviewChartLevel leftSpotItemReviewChartLevel3<?php if ($place['entrance_steps'] >= 2) echo " on" ?>"></div>
                    <div class="leftSpotItemReviewChartLevel leftSpotItemReviewChartLevel4<?php if ($place['entrance_steps'] >= 3) echo " on" ?>"></div>
                    <div class="leftSpotItemReviewChartLevel leftSpotItemReviewChartLevel5<?php if ($place['entrance_steps'] >= 4) echo " on" ?>"></div>
                </div>
                <div class="leftSpotItemReviewChartNumber">
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
                <?php else: ?>
                <span class="spotNotReview">
                    <?php echo __('LABEL_REVIEW_NO_STEP') ?>
                </span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
