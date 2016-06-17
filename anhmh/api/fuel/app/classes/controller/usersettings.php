<?php

/**
 * Controller for actions on UserSettings
 *
 * @package Controller
 * @created 2014-12-12
 * @version 1.0
 * @author Dien Nguyen
 * @copyright Oceanize INC
 */
class Controller_UserSettings extends \Controller_App {

    /**
     *  Get all setting of user by action POST
     * 
     * @return boolean 
     */
    public function post_all() {
        return \Bus\UserSettings_All::getInstance()->execute();
    }
    /**
     *  Get all setting of user by action GET
     * 
     * @return boolean 
     */
    public function get_all(){
        return $this->post_all();
    }

    /**
     *  Update disable field for Usersettings by action POST
     * 
     * @return boolean 
     */
    public function post_disable() {
        return \Bus\UserSettings_Disable::getInstance()->execute();
    }
    
     /**
     *  Update disable field for Usersettings by action GET
      * 
     * @return boolean 
     */
    public function get_disable(){
        return $this->post_disable();
    }

     /**
     *  Update or add new Usersettings by action POST
      * 
     * @return boolean 
     */
    public function post_addupdate() {
        return \Bus\UserSettings_AddUpdate::getInstance()->execute();
    }

    /**
     *  Update or add new Usersettings by action GET
     * 
     * @return boolean 
     */
    public function get_addupdate() {
        return $this->post_addupdate();
    }

    /**
     * Multi update for Usersettings by action POST 
     * 
     * @return boolean 
     */
    public function post_multiupdate() {
        return \Bus\UserSettings_MultiUpdate::getInstance()->execute();
    }

    /**
     *  Multi update for Usersettings by action GET
     *
     * @return boolean
     */
    public function get_multiupdate() {
        return $this->post_multiupdate();
    }

    /**
     *  Update for User settings
     *
     * @return boolean
     */
    public function action_update() {
        return \Bus\UserSettings_Update::getInstance()->execute();
    }
}
