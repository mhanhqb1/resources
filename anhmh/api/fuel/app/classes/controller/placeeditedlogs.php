<?php

/**
 * Controller for actions on PlaceEditedLog 
 *
 * @package Controller
 * @created 2015-06-29
 * @version 1.0
 * @author Caolp
 * @copyright Oceanize INC
 */
class Controller_PlaceEditedLogs extends \Controller_App
{
    /**
     * Add or update info for PlaceEditedLog 
     *
     * @return boolean
     */
    public function action_addUpdate()
    {
        return \Bus\PlaceEditedLogs_AddUpdate::getInstance()->execute();
    }

    /**
     * Get list PlaceEditedLog  (using array count)
     *
     * @return boolean
     */
    public function action_list()
    {
        return \Bus\PlaceEditedLogs_List::getInstance()->execute();
    }

    /**
     * Get all PlaceEditedLog  (without array count)
     *
     * @return boolean
     */
    public function action_all()
    {
        return \Bus\PlaceEditedLogs_All::getInstance()->execute();
    }

    /**
     * Disable/Enable PlaceEditedLog 
     *
     * @return boolean
     */
    public function action_disable()
    {
        return \Bus\PlaceEditedLogs_Disable::getInstance()->execute();
    }

    /**
     * Get detail PlaceEditedLog
     *
     * @return boolean
     */
    public function action_detail()
    {
        return \Bus\PlaceEditedLogs_Detail::getInstance()->execute();
    }

    /**
     * Search PlaceEditedLog
     *
     * @return boolean
     */
    public function action_search()
    {
        return \Bus\PlaceEditedLogs_Search::getInstance()->execute();
    }
}