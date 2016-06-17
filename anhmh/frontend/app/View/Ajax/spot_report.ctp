<h3><?php echo __('MESSAGE_REPORT_SPOT_TITLE') ?></h3>
<?php if(!empty($violation_reports)):
    $_checked = false;
?>
<?php foreach ($violation_reports as $violation_report): ?>
<div class="dlgPopupSpotReportItem">
    <?php
        if (!$_checked) {
            $_checkedText = ' checked="checked" ';
            $_checked = true;
        } else {
            $_checkedText = '';
        }
    ?>
    <input type="radio" name="report_id" id="dlgPopupSpotReportItem_<?php echo $violation_report['id'] ?>" value="<?php echo $violation_report['id'] ?>" <?php echo $_checkedText ?>/>
    <label for="dlgPopupSpotReportItem_<?php echo $violation_report['id'] ?>"><?php echo htmlspecialchars($violation_report['message']) ?></label>
</div>
<?php endforeach; ?>
<?php endif; ?>
<div class="dlgPopupSpotReportItem">
    <input type="radio" name="report_id" id="dlgPopupSpotReportItem_other" value="other" <?php if(!$_checked) echo ' checked="checked" ' ?>/>
    <label for="dlgPopupSpotReportItem_other"><?php echo __('LABEL_OTHER') ?></label>
</div>
<textarea name="report_comment" id="dlgPopupSpotReportItemComment"></textarea>
<input type="hidden" name="place_id" value="<?php echo htmlspecialchars($placeId) ?>"/>
<button type="button" class="btn btn-bmaps" id="dlgPopupSpotReportBtnSend"><?php echo __('LABEL_APPLY') ?></button>
<button type="button" class="btn" id="dlgPopupSpotReportBtnCancel"><?php echo __('LABEL_CLOSE') ?></button>
