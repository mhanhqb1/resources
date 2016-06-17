<?php

/**
 * Controller for actions on Place Information
 *
 * @package Controller
 * @created 2015-06-29
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Controller_PlaceInformations extends \Controller_App
{
    /**
     * Add or update info for Place Information
     *
     * @return boolean
     */
    public function action_addUpdate()
    {
        return \Bus\PlaceInformations_AddUpdate::getInstance()->execute();
    }

    /**
     * Get list Place Information (using array count)
     *
     * @return boolean
     */
    public function action_list()
    {
        return \Bus\PlaceInformations_List::getInstance()->execute();
    }

    /**
     * Get all Place Information (without array count)
     *
     * @return boolean
     */
    public function action_all()
    {
        return \Bus\PlaceInformations_All::getInstance()->execute();
    }

    /**
     * Disable/Enable Place Information
     *
     * @return boolean
     */
    public function action_disable()
    {
        return \Bus\PlaceInformations_Disable::getInstance()->execute();
    }

    /**
     * Get detail Place Information
     *
     * @return boolean
     */
    public function action_detail()
    {
        return \Bus\PlaceInformations_Detail::getInstance()->execute();
    }
}
