<?php

/**
 * Controller for actions on Help
 *
 * @package Controller
 * @created 2015-07-08
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Controller_Adminnotices extends \Controller_App
{
    /**
     * Add or update info
     *
     * @return boolean
     */
    public function action_addUpdate()
    {
        return \Bus\Adminnotices_AddUpdate::getInstance()->execute();
    }

    /**
     * Get list (using array count)
     *
     * @return boolean
     */
    public function action_list()
    {
        return \Bus\Adminnotices_List::getInstance()->execute();
    }

    /**
     * Get all (without array count)
     *
     * @return boolean
     */
    public function action_all()
    {
        return \Bus\Adminnotices_All::getInstance()->execute();
    }

    /**
     * Disable/Enable 
     *
     * @return boolean
     */
    public function action_disable()
    {
        return \Bus\Adminnotices_Disable::getInstance()->execute();
    }

    /**
     * Get detail 
     *
     * @return boolean
     */
    public function action_detail()
    {
        return \Bus\Adminnotices_Detail::getInstance()->execute();
    }
   
}
