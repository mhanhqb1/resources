<?php if (!$this->request->is('ajax')) : ?>
<script type="text/javascript" src="<?php echo BASE_URL ?>/js/coin.js?<?php echo date('Ymd') ?>"></script>
<div id="coin_history_container">
    <div id="coin_history_banner" class="noselect">
        <?php echo __('LABEL_GET_COIN') ?>
    </div>
    
    <div id="coin_history_user">
        <a id="coin_history_user_avatar"
           href="javascript: void(0)"
           style="background-image: url(<?php echo !empty($coinUser['avatar']) ? $coinUser['avatar'] : (BASE_URL . '/img/avatar.png') ?>)" 
           title="<?php echo htmlspecialchars($coinUser['name']) ?>"
           onclick="event.stopPropagation(); showLeftUser(<?php echo $coinUser['id'] ?>, true);"></a>
        <div id="coin_history_user_text" class="noselect"><?php echo __('LABEL_YOUR_RANKING') ?></div>
        <div id="coin_history_user_value" class="noselect"><?php echo sprintf(__('LABEL_YOUR_RANKING_VALUE'), !empty($coinUser['number_ranking']) ? number_format($coinUser['number_ranking']) : 0) ?></div>
        <div id="coin_history_user_coin" class="noselect">
            <span></span><?php echo !empty($coinUser['coin']) ? number_format($coinUser['coin']) : 0 ?>
        </div>
    </div>
    
    <div id="coin_history_type">
        <a href="<?php echo BASE_URL ?>/users/coin/<?php echo $coinUser['id'] ?>/get" class="noselect <?php if($type == 'get') echo 'active' ?>">
            <?php echo __('LABEL_COIN_TYPE_GET') ?>
        </a>
        <a href="<?php echo BASE_URL ?>/users/coin/<?php echo $coinUser['id'] ?>/used" class="noselect <?php if($type == 'used') echo 'active' ?>">
            <?php echo __('LABEL_COIN_TYPE_USED') ?>
        </a>
    </div>
    
    <div id="coin_history_data">
        <?php endif; ?>
        <?php if(!empty($data)): ?>
        <div id="coin_history_data_container">
            <?php foreach ($data as $coin): ?>
            <div class="coin_history_data_item">
                <div class="coin_history_data_item_cell coin_history_data_item_date">
                    <?php echo date('m/d', strtotime($coin['date'])) ?><br/>
                    <?php echo '（' . $coin['day_of_week'] . '）' ?>
                </div>
                <div class="coin_history_data_item_cell coin_history_data_item_name">
                    <?php echo !empty($pointType[$coin['type']]) ? $pointType[$coin['type']] : '' ?><br/>
                    <?php echo $coin['place_name'] ?>
                </div>
                <div class="coin_history_data_item_cell coin_history_data_item_coin">
                    <span></span>
                    <?php echo !empty($coin['coin']) ? number_format($coin['coin']) : 0 ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div id="coin_history_data_empty" class="noselect">
            <img src="<?php echo BASE_URL ?>/img/bcoin_disable.png"/>
            <div><?php echo __('LABEL_EMPTY_COIN') ?></div>
        </div>
        <?php endif; ?>
        
        <?php if (!$this->request->is('ajax')) : ?>
    </div>
</div>
<?php endif; ?>
