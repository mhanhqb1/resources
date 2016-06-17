<link rel="stylesheet" href="<?php echo BASE_URL ?>/css/place.css?<?php echo date('Ymd') ?>" media="only screen and (min-width:640px)"/>

<div id="plcListTab">
    <div id="plcListTabInner">
        <a data-tab="plcList1" href="javascript:void(0)" class="noselect active">
            <?php echo __('LABEL_SPOT_WANT_TO_GO');?>
        </a>
        <a data-tab="plcList2" href="javascript:void(0)" class="noselect">
            <?php echo __('LABEL_SPOT_WENT_TO_GO');?>
        </a>
    </div>
</div>

<div class="plcList1">
<?php if (!empty($placefavorites['want_to_visit'])): ?>
<div class="plcList">    
    <?php foreach($placefavorites['want_to_visit'] as $place): ?>
    <div class="plcItem"> 
        <a data-id="<?php echo $place['place_id'] ?>" onclick="return goLeftSpotDetail($(this), null, null, true)">
            <?php if (!empty($place['thm_image_path'])): ?>        
            <div class="plcItemImage" style="background-image:url('<?php echo $place['thm_image_path'] ?>')"></div>
            <?php else: ?>
            <div class="plcItemImage" style="background-color:<?php echo $place['image_bg'] ?>">
                <span><?php echo $place['name_1'] ?></span>
            </div>
            <?php endif; ?>
            <div class="plcItemName">
                <div><span><?php echo !empty($place['name_short']) ? $place['name_short'] : '' ?></span></div>
            </div>
        </a>
    </div>
    <?php endforeach; ?>    
</div>
<?php else: ?>
    <div class="no-place"><?php echo __('MESSAGE_NOPLACE_WANT_TO_GO');?></div>
<?php endif; ?>
</div>

<div class="plcList2"> 
<?php if (!empty($placefavorites['visited'])): ?>
<div class="plcList">    
    <?php foreach($placefavorites['visited'] as $place): ?>
    <div class="plcItem"> 
        <a data-id="<?php echo $place['place_id'] ?>" onclick="return goLeftSpotDetail($(this), null, null, true)">
            <?php if (!empty($place['thm_image_path'])): ?>        
            <div class="plcItemImage" style="background-image:url('<?php echo $place['thm_image_path'] ?>')"></div>
            <?php else: ?>
            <div class="plcItemImage" style="background-color:<?php echo $place['image_bg'] ?>">
                <span><?php echo $place['name_1'] ?></span>
            </div>
            <?php endif; ?>
            <div class="plcItemName">
                <div><span><?php echo !empty($place['name_short']) ? $place['name_short'] : '' ?></span></div>
            </div>
        </a>
    </div>
    <?php endforeach; ?>    
</div>
<?php else: ?>
    <div class="no-place"><?php echo __('MESSAGE_NOPLACE_REVIEWED');?></div>
<?php endif; ?>
</div>
