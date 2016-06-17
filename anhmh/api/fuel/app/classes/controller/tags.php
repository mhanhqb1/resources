<?php

/**
 * Controller for actions on Tags
 *
 * @package Controller
 * @created 2015-03-19
 * @version 1.0
 * @author Hoang Gia Thong
 * @copyright Oceanize INC
 */
class Controller_Tags extends \Controller_App
{
    /**
     * Add and update info for Tags
     *
     * @return boolean
     */
    public function action_addUpdate()
    {
        return \Bus\Tags_AddUpdate::getInstance()->execute();
    }
   
    /**
     * Get list Tags (using array count)
     *
     * @return boolean
     */
    public function action_list()
    {
        return \Bus\Tags_List::getInstance()->execute();
    }

    /**
     * Get all Tags (without array count)
     *
     * @return boolean
     */
    public function action_all()
    {
        return \Bus\Tags_All::getInstance()->execute();
    }

    /**
     * Disable/Enable list Tags
     *
     * @return boolean
     */
    public function action_disable()
    {
        return \Bus\Tags_Disable::getInstance()->execute();
    }

    /**
     * Get detail Tags
     *
     * @return boolean
     */
    public function action_detail()
    {
        return \Bus\Tags_Detail::getInstance()->execute();
    }    
}
