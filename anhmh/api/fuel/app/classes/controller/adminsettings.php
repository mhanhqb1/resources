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
class Controller_AdminSettings extends \Controller_App {

    /**
     * Get all adminsetting by action POST
     *  
     * @return boolean    
     */
    public function post_all() {
        return \Bus\AdminSettings_All::getInstance()->execute();
    }
    /**
     * Get all adminsetting by action GET
     *  
     * @return boolean    
     */
    public function get_all(){
        return $this->post_all();
    }
    
    /**
     * Update disable field for adminsetting by action POST
     *  
     * @return boolean    
     */
    public function post_disable() {
        return \Bus\AdminSettings_Disable::getInstance()->execute();
    }
    
    /**
     * Update disable field for adminsetting by action GET
     *  
     * @return boolean    
     */
    public function get_disable(){
        return $this->post_disable();
    }

    /**
     * Update or add new for adminsetting by action POST
     *  
     * @return boolean    
     */
    public function post_addupdate() {
        return \Bus\AdminSettings_AddUpdate::getInstance()->execute();
    }

    /**
     * Update or add new for adminsetting by action GET
     *  
     * @return boolean    
     */
    public function get_addupdate() {
        return $this->post_addupdate();
    }

    /**
     * Update multi field for adminsetting by action POST
     *  
     * @return boolean    
     */
    public function post_multiupdate() {
        return \Bus\AdminSettings_MultiUpdate::getInstance()->execute();
    }

    /**
     * Update multi field for adminsetting by action GET
     *  
     * @return boolean    
     */
    public function get_multiupdate() {
        return $this->post_multiupdate();
    }
}
