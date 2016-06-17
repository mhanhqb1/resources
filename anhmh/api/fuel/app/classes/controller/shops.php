<?php

/**
 * Controller for actions on Shop
 *
 * @package Controller
 * @created 2015-03-19
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Controller_Shops extends \Controller_App
{
    /**
     * Add or update info for Shop
     *
     * @return boolean
     */
    public function action_addUpdate()
    {
        return \Bus\Shops_AddUpdate::getInstance()->execute();
    }

    /**
     * Get list Shop (using array count)
     *
     * @return boolean
     */
    public function action_list()
    {
        return \Bus\Shops_List::getInstance()->execute();
    }

    /**
     * Get all Shop (without array count)
     *
     * @return boolean
     */
    public function action_all()
    {
        return \Bus\Shops_All::getInstance()->execute();
    }

    /**
     * Disable/Enable list Shop
     *
     * @return boolean
     */
    public function action_disable()
    {
        return \Bus\Shops_Disable::getInstance()->execute();
    }

    /**
     * Get detail Shop
     *
     * @return boolean
     */
    public function action_detail()
    {
        return \Bus\Shops_Detail::getInstance()->execute();
    }

    /**
     * Get list of customers of shop
     *
     * @return boolean
     */
    public function action_customer()
    {
        return \Bus\Shops_Customer::getInstance()->execute();
    }
    
     /**
     * Execute is_plus shop
     *
     * @return boolean
     */
    public function action_plus()
    {
        return \Bus\Shops_Plus::getInstance()->execute();
    }
}
