<?php foreach($data as $i => $team): ?>
<div class="dlgPopupChampionshipItem">
    <div class="dlgPopupChampionshipItemLeft" style="background-image: url(<?php echo !empty($team['image_path']) ? $team['image_path'] : '' ?>)">
        <?php if($team['rank'] == 1): ?>
        <div id="dlgPopupChampionshipLevel1"></div>
        <?php elseif($team['rank'] == 2): ?>
        <div id="dlgPopupChampionshipLevel2"></div>
        <?php elseif($team['rank'] == 3): ?>
        <div id="dlgPopupChampionshipLevel3"></div>
        <?php else: ?>
        <div id="dlgPopupChampionshipLevelOther"><?php echo $team['rank'] ?></div>
        <?php endif; ?>
    </div>
    <div class="dlgPopupChampionshipItemRight">
        <div class="dlgPopupChampionshipItemRightTop">
            <?php echo !empty($team['name']) ? $team['name'] : '' ?>
        </div>
        <div class="dlgPopupChampionshipItemRightBot">
            <div class="dlgPopupChampionshipItemRightBotLabel"><?php echo __('LABEL_POINT');?></div>
            <?php echo !empty($team['point']) ? number_format($team['point']) : 0 ?>
        </div>
    </div>
</div>
<?php endforeach; ?>