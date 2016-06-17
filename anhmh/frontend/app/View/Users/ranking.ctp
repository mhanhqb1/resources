<div id="coin_history_banner" class="noselect">
    <?php echo __('LABEL_GET_COIN') ?>
</div>
<div id="coin_history_user">
    <a id="coin_history_user_avatar"
       href="javascript: void(0)"
       style="background-image: url(<?php echo !empty($coinUser['avatar']) ? $coinUser['avatar'] : (BASE_URL . '/img/avatar.png') ?>)" 
       title=""></a>
    <?php if (empty($AppUI->id)): ?>
    <div id="coin_history_user_text_guest" class="noselect"><?php echo __('LABEL_GUEST') ?></div>
    <?php else: ?>
    <div id="coin_history_user_text" class="noselect"><?php echo __('LABEL_YOUR_RANKING') ?></div>
    <div id="coin_history_user_value" class="noselect"><?php echo sprintf(__('LABEL_YOUR_RANKING_VALUE'), !empty($coinUser['number_ranking']) ? number_format($coinUser['number_ranking']) : 0) ?></div>
    <?php endif; ?>
    <div id="coin_history_user_coin" class="noselect">
        <span></span><?php echo !empty($coinUser['coin']) ? number_format($coinUser['coin']) : 0 ?>
    </div>
</div>

<?php if (!empty($rankings)): ?>
<div id="coin_user_rankings">
    <?php foreach ($rankings as $ranking): ?>
    <div class="coin_user_ranking">
        <div class="coin_user_ranking_item coin_user_ranking_rank coin_user_ranking_rank_<?php echo $ranking['ranking'] ?>">
            <div><?php echo $ranking['ranking'] ?></div>
        </div>
        <div class="coin_user_ranking_item coin_user_ranking_user_avatar">
            <a href="javascript:void(0)" style="background-image: url(<?php echo !empty($ranking['user_avatar']) ? $ranking['user_avatar'] : (BASE_URL . '/img/avatar.png') ?>)"></a>
        </div>
        <div class="coin_user_ranking_item coin_user_ranking_user">
            <div class="coin_user_ranking_user_name noselect"><?php echo htmlspecialchars($ranking['user_name']) ?></div>
            <div class="coin_user_ranking_user_coin noselect">
                <span></span>
                <?php echo !empty($ranking['coin']) ? number_format($ranking['coin']) : 0 ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>