<?php if(!empty($history)): ?>
<?php foreach ($history as $review): ?>
<div class="dlgPopupPlaceReviewHistoryItem" data-id="<?php echo $review['id'] ?>">
    <div class="dlgPopupPlaceReviewHistoryDate">
        <?php echo date('Y-m-d H:i', $review['created']) ?>
    </div>
    <div class="dlgPopupPlaceReviewHistoryComment">
        <?php echo htmlspecialchars($review['comment']) ?>
    </div>
</div>
<?php endforeach; ?>
<?php endif; ?>