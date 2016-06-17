<?php

/**
 * Controller for actions on Settings
 *
 * @package Controller
 * @created 2014-12-12
 * @version 1.0
 * @author Dien Nguyen
 * @copyright Oceanize INC
 */
class Controller_Settings extends \Controller_App {

    /**
     *  Get detail Settings by action POST
     * 
     * @return boolean 
     */
    public function post_detail() {
        return \Bus\Settings_Detail::getInstance()->execute();
    }

     /**
     *  Get detail Settings by action GET
      * 
     * @return boolean 
     */
    public function get_detail(){
        return $this->post_detail();
    }
    
     /**
     *  Get all Settings by action POST
      * 
     * @return boolean 
     */
    public function post_all() {
        return \Bus\Settings_All::getInstance()->execute();
    }
    
     /**
     *  Get all Settings by action GET
      * 
     * @return boolean 
     */
    public function get_all(){
        return $this->post_all();
    }

     /**
     *  Get lisyt Settings by action POST
      * 
     * @return boolean 
     */
    public function post_list() {
        return \Bus\Settings_List::getInstance()->execute();
    }
    
     /**
     *  Get detail Settings by action GET
      * 
     * @return boolean 
     */
    public function get_list(){
        return $this->post_list();
    }

     /**
     *  Update disable field for Settings by action POST
      * 
     * @return boolean 
     */
    public function post_disable() {
        return \Bus\Settings_Disable::getInstance()->execute();
    }
    
    /**
     *  Update disable field for Settings by action GET
     * 
     * @return boolean 
     */
    public function get_disable(){
        return $this->post_disable();
    }

    /**
     *  Update or add new Settings by action POST
     * 
     * @return boolean 
     */
    public function post_addupdate() {
        return \Bus\Settings_AddUpdate::getInstance()->execute();
    }

    /**
     *  Update or add new Settings by action GET
     * 
     * @return boolean 
     */
    public function get_addupdate() {
        return $this->post_addupdate();
    }
    
    /**
     *  Multi Update Settings by action POST
     * 
     * @return boolean 
     */
    public function post_multiupdate() {
        return \Bus\Settings_MultiUpdate::getInstance()->execute();
    }

    /**
     *  Multi Update Settings by action POST
     * 
     * @return boolean 
     */
    public function get_multiupdate() {
        return $this->post_multiupdate();
    }

}
