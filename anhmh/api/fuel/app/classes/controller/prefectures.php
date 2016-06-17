<?php

/**
 * Controller_Prefectures - Controller for actions on Prefectures
 *
 * @package Controller
 * @created 2015-03-25
 * @version 1.0
 * @author Tran Xuan Khoa
 * @copyright Oceanize INC
 */
class Controller_Prefectures extends \Controller_App {

    /**
     *  Get list areas by condition
     * 
     * @return array 
     */
    public function action_list() {
        return \Bus\Prefectures_List::getInstance()->execute();
    }
    
    /**
     *  Get all areas
     * 
     * @return array 
     */
    public function action_all() {
        return \Bus\Prefectures_All::getInstance()->execute();
    }
    
    /**
     *  Update or add new an area
     * 
     * @return boolean 
     */
    public function action_addupdate() {
        return \Bus\Prefectures_AddUpdate::getInstance()->execute();
    }
    
    /**
     *  Disable list of areas
     * 
     * @return boolean 
     */
    public function action_disable() {
        return \Bus\Prefectures_Disable::getInstance()->execute();
    }
    
    /**
     *  Get detail info of an area
     * 
     * @return array Detail information of an area
     */
    public function action_detail() {
        return \Bus\Prefectures_Detail::getInstance()->execute();
    }

}
