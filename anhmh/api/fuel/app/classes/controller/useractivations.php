<?php

/**
 * Controller_UserActivations
 *
 * @package Controller
 * @created 2014-11-20
 * @version 1.0
 * @author thailh
 * @copyright Oceanize INC
 */
class Controller_UserActivations extends \Controller_App {

    /**
     *  Get detail for UserActivations
     * 
     * @return boolean 
     */
    public function action_detail() {
        return \Bus\UserActivations_Detail::getInstance()->execute();
    }

    /**
     *  Check token is expire_date from UserActivations
     * 
     * @return boolean 
     */
    public function action_check() {
        return \Bus\UserActivations_Check::getInstance()->execute();
    }

    /**
     *  Update disable field for UserActivations
     * 
     * @return boolean 
     */
    public function action_disable() {
        return \Bus\UserActivations_Disable::getInstance()->execute();
    }

    /**
     *  Get list of UserActivations by condition 
     * 
     * @return boolean 
     */
    public function action_list() {
        return \Bus\UserActivations_List::getInstance()->execute();
    }

    /**
     *  Update or add new UserActivations
     * 
     * @return boolean 
     */
    public function action_addupdate() {
        return \Bus\UserActivations_AddUpdate::getInstance()->execute();
    }

}
