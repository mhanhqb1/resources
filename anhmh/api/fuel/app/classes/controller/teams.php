<?php

/**
 * Controller for actions on Team
 *
 * @package Controller
 * @created 2015-07-01
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Controller_Teams extends \Controller_App
{
    /**
     * Add or update info for Team
     *
     * @return boolean
     */
    public function action_addUpdate()
    {
        return \Bus\Teams_AddUpdate::getInstance()->execute();
    }

    /**
     * Get list Team (using array count)
     *
     * @return boolean
     */
    public function action_list()
    {
        return \Bus\Teams_List::getInstance()->execute();
    }

    /**
     * Get all Team (without array count)
     *
     * @return boolean
     */
    public function action_all()
    {
        return \Bus\Teams_All::getInstance()->execute();
    }

    /**
     * Disable/Enable Team
     *
     * @return boolean
     */
    public function action_disable()
    {
        return \Bus\Teams_Disable::getInstance()->execute();
    }

    /**
     * Get detail Team
     *
     * @return boolean
     */
    public function action_detail()
    {
        return \Bus\Teams_Detail::getInstance()->execute();
    }    
    
    /**
     * Add or update info for Team
     *
     * @return boolean
     */
    public function action_addUpdateMultiple()
    {
        return \Bus\Teams_AddUpdateMultiple::getInstance()->execute();
    }
    
    /**
     * Delete team member
     * @return boolean
     */
    public function action_deletemember() {
        return \Bus\Teams_Deletemember::getInstance()->execute();
    }
    
}
