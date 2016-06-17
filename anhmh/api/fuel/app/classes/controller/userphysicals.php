<?php

/**
 * Controller for actions on User Physical
 *
 * @package Controller
 * @created 2015-06-29
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Controller_UserPhysicals extends \Controller_App
{
    /**
     * Add or update info for User Physical
     *
     * @return boolean
     */
    public function action_addUpdate()
    {
        return \Bus\UserPhysicals_AddUpdate::getInstance()->execute();
    }

    /**
     * Get list User Physical (using array count)
     *
     * @return boolean
     */
    public function action_list()
    {
        return \Bus\UserPhysicals_List::getInstance()->execute();
    }

    /**
     * Get all User Physical (without array count)
     *
     * @return boolean
     */
    public function action_all()
    {
        return \Bus\UserPhysicals_All::getInstance()->execute();
    }

    /**
     * Disable/Enable User Physical
     *
     * @return boolean
     */
    public function action_disable()
    {
        return \Bus\UserPhysicals_Disable::getInstance()->execute();
    }

    /**
     * Get detail User Physical
     *
     * @return boolean
     */
    public function action_detail()
    {
        return \Bus\UserPhysicals_Detail::getInstance()->execute();
    }
}
