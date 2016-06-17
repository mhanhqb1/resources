<?php

/**
 * Controller for actions on Place Sub Category
 *
 * @package Controller
 * @created 2015-07-01
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Controller_PlaceSubCategories extends \Controller_App
{
    /**
     * Add or update info for Place Sub Category
     *
     * @return boolean
     */
    public function action_addUpdate()
    {
        return \Bus\PlaceSubCategories_AddUpdate::getInstance()->execute();
    }

    /**
     * Get list Place Sub Category (using array count)
     *
     * @return boolean
     */
    public function action_list()
    {
        return \Bus\PlaceSubCategories_List::getInstance()->execute();
    }

    /**
     * Get all Place Sub Category (without array count)
     *
     * @return boolean
     */
    public function action_all()
    {
        return \Bus\PlaceSubCategories_All::getInstance()->execute();
    }

    /**
     * Disable/Enable Place Sub Category
     *
     * @return boolean
     */
    public function action_disable()
    {
        return \Bus\PlaceSubCategories_Disable::getInstance()->execute();
    }

    /**
     * Get detail Place Sub Category
     *
     * @return boolean
     */
    public function action_detail()
    {
        return \Bus\PlaceSubCategories_Detail::getInstance()->execute();
    }

    /**
     * Get detail Place Sub Category by Google name
     *
     * @return boolean
     */
    public function action_detailByGoogleName()
    {
        return \Bus\PlaceSubCategories_DetailByGoogleName::getInstance()->execute();
    }
    
    /**
     * Add or update info for Place Sub Category
     *
     * @return boolean
     */
    public function action_addUpdateMultiple()
    {
        return \Bus\PlaceSubCategories_AddUpdateMultiple::getInstance()->execute();
    }
}
