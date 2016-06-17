<?php

/**
 * Controller for actions on admin
 *
 * @package Controller
 * @created 2014-11-20
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Controller_Admins extends \Controller_App {
    
    /**
     * Get detail of admins by id
     *
     * @return boolean
     */
    public function action_detail() {
        return \Bus\Admins_Detail::getInstance()->execute();
    }

    /**
     * Get list of admins by id
     *
     * @return boolean
     */
    public function action_list() {
        return \Bus\Admins_List::getInstance()->execute();
    }
    /**
     * Set disable value for admin
     *  
     * @return boolean   
     */
    public function action_disable() {
        return \Bus\Admins_Disable::getInstance()->execute();
    }

    /**
     * Update infomation for admin
     *  
     * @return boolean   
     */
    public function action_addUpdate() {
        return \Bus\Admins_AddUpdate::getInstance()->execute();
    }

    /**
     * login for admin
     *  
     * @return boolean
     */
    public function action_login() {
        return \Bus\Admins_Login::getInstance()->execute();
    }

    /**
     * Update passsword for admin
     *  
     * @return boolean
     */
    public function action_updatePassword() {
        return \Bus\Admins_UpdatePassword::getInstance()->execute();
    }
    /**
     * Get detail of admins by id
     *
     * @return boolean
     */
    public function action_all() {
        return \Bus\Admins_All::getInstance()->execute();
    }

}
