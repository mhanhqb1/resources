<?php

/**
 * Controller for actions on Place Category
 *
 * @package Controller
 * @created 2015-06-29
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Controller_PlaceCategories extends \Controller_App
{
    /**
     * Add or update info for Place Category
     *
     * @return boolean
     */
    public function action_addUpdate()
    {
        return \Bus\PlaceCategories_AddUpdate::getInstance()->execute();
    }

    /**
     * Get list Place Category (using array count)
     *
     * @return boolean
     */
    public function action_list()
    {
        return \Bus\PlaceCategories_List::getInstance()->execute();
    }

    /**
     * Get all Place Category (without array count)
     *
     * @return boolean
     */
    public function action_all()
    {
        return \Bus\PlaceCategories_All::getInstance()->execute();
    }

    /**
     * Disable/Enable Place Category
     *
     * @return boolean
     */
    public function action_disable()
    {
        return \Bus\PlaceCategories_Disable::getInstance()->execute();
    }

    /**
     * Get detail Place Category
     *
     * @return boolean
     */
    public function action_detail()
    {
        return \Bus\PlaceCategories_Detail::getInstance()->execute();
    }
}
