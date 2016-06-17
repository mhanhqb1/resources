<?php

/* 
 * Description : Class contain constants value for Javascript
 * User        : KienNH
 * Date created: 2015/10/28
 */

class JsconstantsController extends AppController {
    
    /**
     * Load library
     */
    function beforeFilter () {
        parent::beforeFilter();
        $this->autoRender = FALSE;
        $this->Auth->allow();
    }
    
    /**
     * Define constant for Javascript
     */
    function index() {
        Header("content-type: application/x-javascript; charset=utf-8");        
        echo "var GUEST = " . (empty($this->AppUI->id) ? 1 : 0) . ";" . PHP_EOL;
        echo "var BASE_URL = '" . BASE_URL . "';" . PHP_EOL;
        echo "var DEFAULT_SITE_TITLE = '" . DEFAULT_SITE_TITLE . "';" . PHP_EOL;
        echo "var SEARCH_SPOT_RECOMMEND_TITLE = '" . __('LABEL_HOT_SPOT') . "';" . PHP_EOL;
        echo "var SEARCH_KEYWORD_TITLE = '" . __('LABEL_SEARCH_KEYWORD_RESULT') . "';" . PHP_EOL;
        echo "var SEARCH_ADVANCED_TITLE = '" . __('LABEL_FILTERING') . "';" . PHP_EOL;
        echo "var SEARCH_CATEGORY_TITLE = '" . __('LABEL_CATEGORY') . "';" . PHP_EOL;
        echo "var ERROR_MESSAGE_NAME_EMPTY = '".  __("ERROR_MESSAGE_NAME_EMPTY")."';" . PHP_EOL;
        echo "var ERROR_MESSAGE_SECTION_EMPTY = '".  __('ERROR_MESSAGE_SECTION_EMPTY') ."';" . PHP_EOL;
        echo "var ERROR_MESSAGE_CATEGORY_EMPTY = '".  __("ERROR_MESSAGE_CATEGORY_EMPTY")."';" . PHP_EOL;
        echo "var CATEGORYNAME_MOBILITY = '" . __('LABEL_CATEGORY_NAME_MOBILITY') . "';" . PHP_EOL;
        echo "var CATEGORYNAME_CAR = '" . __('LABEL_CATEGORY_NAME_CAR') . "';" . PHP_EOL;
        echo "var CATEGORYNAME_LEISURE = '" . __('LABEL_CATEGORY_NAME_LEISURE') . "';" . PHP_EOL;
        echo "var CATEGORYNAME_FOOD = '" . __('LABEL_CATEGORY_NAME_FOOD') . "';" . PHP_EOL;
        echo "var CATEGORYNAME_LIFE = '" . __('LABEL_CATEGORY_NAME_LIFE') . "';" . PHP_EOL;
        echo "var CATEGORYNAME_PUB = '" . __('LABEL_CATEGORY_NAME_PUB') . "';" . PHP_EOL;
        echo "var CATEGORYNAME_WELLNESS = '" . __('LABEL_CATEGORY_NAME_WELLNESS') . "';" . PHP_EOL;
        echo "var CATEGORYNAME_SHOP = '" . __('LABEL_CATEGORY_NAME_SHOP') . "';" . PHP_EOL;
        echo "var SEARCH_NO_SELECT = '" . __('LABEL_SEARCH_NO_SELECT') . "';" . PHP_EOL;
        echo "var NOT_FOUND_MESSAGE = '" . __('LABEL_SPOT_NOT_FOUND') . "';" . PHP_EOL;
        echo "var LABEL_FOLLOW = '".  __('LABEL_FOLLOW') ."';" . PHP_EOL;
        echo "var LABEL_FOLLOWING = '".  __('LABEL_FOLLOWING') ."';" . PHP_EOL;
        echo "var TEAM_ID = " . (!empty($this->AppUI->team_id) ? $this->AppUI->team_id : 0) . ";" . PHP_EOL;
        echo "var TEAM_NAME = '" . (!empty($this->AppUI->team_name) ? $this->AppUI->team_name : '') . "';" . PHP_EOL;
        echo "var MESSAGE_SYSTEM_ERROR_TRY_AGAIN = '".  __('MESSAGE_SYSTEM_ERROR_TRY_AGAIN') ."';" . PHP_EOL;
        
        echo "var LABEL_ERROR = '".  __('LABEL_ERROR') ."';" . PHP_EOL;
        echo "var LABEL_CLOSE = '".  __('LABEL_CLOSE') ."';" . PHP_EOL;
        echo "var MESSAGE_GEO_ERROR_PERMISSION_DENIED = '".  __('MESSAGE_GEO_ERROR_PERMISSION_DENIED') ."';" . PHP_EOL;
        echo "var MESSAGE_GEO_ERROR_POSITION_UNAVAILABLE = '".  __('MESSAGE_GEO_ERROR_POSITION_UNAVAILABLE') ."';" . PHP_EOL;
        echo "var MESSAGE_GEO_ERROR_TIMEOUT = '".  __('MESSAGE_GEO_ERROR_TIMEOUT') ."';" . PHP_EOL;
        echo "var MESSAGE_GEO_ERROR_UNKNOWN_ERROR = '".  __('MESSAGE_GEO_ERROR_UNKNOWN_ERROR') ."';" . PHP_EOL;
        echo "var MESSAGE_GEO_ERROR_BROWSER_NOT_SUPPORT = '".  __('MESSAGE_GEO_ERROR_BROWSER_NOT_SUPPORT') ."';" . PHP_EOL;
        echo "var LABEL_SPOT_NOT_REGISTERED = '".  __('LABEL_SPOT_NOT_REGISTERED') ."';" . PHP_EOL;
        echo "var MESSAGE_CONFIRM_LOGOUT = '".  __('MESSAGE_CONFIRM_LOGOUT') ."';" . PHP_EOL;
        echo "var LABEL_CANCEL = '".  __('LABEL_CANCEL') ."';" . PHP_EOL;
        echo "var MESSAGE_REPORT_SPOT = '".  __('MESSAGE_REPORT_SPOT') ."';" . PHP_EOL;
        echo "var MESSAGE_CONFIRM_DELETE_SPOT = '".  __('MESSAGE_CONFIRM_DELETE_SPOT') ."';" . PHP_EOL;
        echo "var MESSAGE_CANNOT_DELETE_SPOT = '".  __('MESSAGE_CANNOT_DELETE_SPOT') ."';" . PHP_EOL;
        echo "var ERROR_MESSAGE_SPOT_NAME_EMPTY = '".  __('ERROR_MESSAGE_SPOT_NAME_EMPTY') ."';" . PHP_EOL;
        echo "var ERROR_MESSAGE_SPOT_CATEGORY_EMPTY = '".  __('ERROR_MESSAGE_SPOT_CATEGORY_EMPTY') ."';" . PHP_EOL;
        echo "var LABEL_INFORMATION = '".  __('LABEL_INFORMATION') ."';" . PHP_EOL;
        echo "var MESSAGE_TEAM_CHANGED_JS = '".  __('MESSAGE_TEAM_CHANGED_JS') ."';" . PHP_EOL;
    }
}
