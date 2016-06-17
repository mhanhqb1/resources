<header>
    <div id="headerContainer">
        <div id="headerLeftBox">
            <form id="headerForm" method="get" action="<?php echo BASE_URL;?>/top" onsubmit="return headerSearch();" >
                <div id="headerLeftMenu"></div>
                <?php if(isset($query) && isset($query['keyword'])):?>
                <input type="text" name="keyword" value="<?php echo $query['keyword'];?>" id="headerKeyword" placeholder="<?php echo __('LANG_INPUT_SERACH_SPOT_PLACEHOLDER');?>" autocomplete="off"/>
                <?php else:?>
                <input type="text" name="keyword" value="" id="headerKeyword" placeholder="<?php echo __('LANG_INPUT_SERACH_SPOT_PLACEHOLDER');?>" autocomplete="off"/>
                <?php endif;?>

                <script id="headerKeywordResultTemplate" type="text/x-jsrender">
                    <div class="headerSuggestionItem" data-id="{{:place_id}}">
                        <div class="headerSuggestiontemName">{{:description}}</div>
                    </div>
                </script>

                <input type="submit" value="" id="btn_SearchHeader" />
            </form>
        </div>
        <div id="headerSuggestionResult"></div>
        <div id="headerLogo">
            <a href="<?php echo BASE_URL ?>/top">
                <img src="<?php echo BASE_URL ?>/img/headerLogo.png"/>
            </a>
        </div>
        <div id="headerRightContainer">
            <div id="headerRightBox" class="noselect">
                <div id="headerRightArrow"></div>
                <div id="headerUser"><?php if(!empty($AppUI->display_name)) echo __($AppUI->display_name) ?></div>
                <div id="headerAvatar" style="background-image: url(<?php
                    if (!empty($AppUI->image_path)) {
                        echo __($AppUI->image_path);
                    } else {
                        echo BASE_URL . '/img/avatar.png';
                    }
                ?>)">
                </div>
            </div>
            <div id="headerLanguageSwitch" class="noselect">
                <a class="<?php if(!empty($language) && $language == 'jpn') echo 'on' ?>" href="?lang=jpn">日本語</a>
                <a class="<?php if(!empty($language) && $language == 'eng') echo 'on' ?>" href="?lang=eng">English</a>
                <a class="<?php if(!empty($language) && $language == 'spa') echo 'on' ?>" href="?lang=spa">Español</a>
                <!--a class="<?php if(!empty($language) && $language == 'tha') echo 'on' ?>" href="?lang=tha">ไทย</a>
                <a class="<?php if(!empty($language) && $language == 'vie') echo 'on' ?>" href="?lang=vie">Tiếng Việt</a-->
            </div>
        </div>
        <div id="headerRightMenu" class="noselect">
            <a id="headerRightMenuUser" 
                href="javascript: void(0)"
                class="<?php if($this->params->params['controller'] == 'users' && $action == 'profile') echo 'active' ?>">
                <span></span><?php echo __('LABEL_MENU_USER');?>
            </a>
            <a id="headerRightMenuNotice" href="<?php echo BASE_URL ?>/notices" class="<?php if($this->params->params['controller'] == 'notices') echo 'active' ?>">
                <span></span><?php echo __('LABEL_MENU_NOTICES');?>
            </a>
            <a id="headerRightMenuSetting" href="<?php echo BASE_URL ?>/settings" class="<?php if($this->params->params['controller'] == 'settings') echo 'active' ?>">
                <span></span><?php echo __('LABEL_MENU_SETTINGS');?>
            </a>
            <a id="headerRightMenuChangeInfo" href="<?php echo BASE_URL ?>/users/updateinfo" class="<?php if($this->params->params['controller'] == 'users' && $this->params->params['action'] == 'updateinfo') echo 'active' ?>">
                <span></span><?php echo __('LABEL_MENU_CHANGE_USER_INFO');?>
            </a>
            <a id="headerRightMenuChangePassword" href="<?php echo BASE_URL ?>/users/changepassword" class="<?php if($this->params->params['controller'] == 'users' && $this->params->params['action'] == 'changepassword') echo 'active' ?>">
                <span></span><?php echo __('LABEL_MENU_CHANGE_USER_PASSWORD');?>
            </a>
            <a id="headerRightMenuChangeTeam" href="javascript: void(0)">
                <span></span><?php echo __('LABEL_MENU_CHANGE_TEAM_INFO');?>
            </a>
            <a id="headerRightMenuHelp" href="<?php echo BASE_URL ?>/helps" class="<?php if($this->params->params['controller'] == 'helps') echo 'active' ?>">
                <span></span><?php echo __('LABEL_MENU_HELPS');?>
            </a>
            <?php if (!empty($AppUI->id)) : ?>
            <a id="headerRightLogout" href="javascript:;">
                <span></span><?php echo __('LABEL_MENU_LOGOUT');?>
            </a>
            <?php endif; ?>
        </div>
    </div>
</header>