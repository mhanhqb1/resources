<?php

/**
 * Controller for actions on Place Image
 *
 * @package Controller
 * @created 2015-06-29
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Controller_PlaceImages extends \Controller_App
{
    /**
     * Add or update info for Place Image
     *
     * @return boolean
     */
    public function action_addUpdate()
    {
        return \Bus\PlaceImages_AddUpdate::getInstance()->execute();
    }

    /**
     * Get list Place Image (using array count)
     *
     * @return boolean
     */
    public function action_list()
    {
        return \Bus\PlaceImages_List::getInstance()->execute();
    }

    /**
     * Get all Place Image (without array count)
     *
     * @return boolean
     */
    public function action_all()
    {
        return \Bus\PlaceImages_All::getInstance()->execute();
    }

    /**
     * Disable/Enable Place Image
     *
     * @return boolean
     */
    public function action_disable()
    {
        return \Bus\PlaceImages_Disable::getInstance()->execute();
    }

    /**
     * Get detail Place Image
     *
     * @return boolean
     */
    public function action_detail()
    {
        return \Bus\PlaceImages_Detail::getInstance()->execute();
    }
    
    /**
     * Change default image of Spot
     *
     * @return boolean
     */
    public function action_changedefault()
    {
        return \Bus\PlaceImages_Changedefault::getInstance()->execute();
    }
    
}
