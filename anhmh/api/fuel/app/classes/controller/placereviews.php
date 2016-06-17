<?php

/**
 * Controller for actions on Place Review
 *
 * @package Controller
 * @created 2015-06-29
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Controller_PlaceReviews extends \Controller_App
{
    /**
     * Add or update info for Place Review
     *
     * @return boolean
     */
    public function action_addUpdate()
    {
        return \Bus\PlaceReviews_AddUpdate::getInstance()->execute();
    }

    /**
     * Get list Place Review (using array count)
     *
     * @return boolean
     */
    public function action_list()
    {
        return \Bus\PlaceReviews_List::getInstance()->execute();
    }

    /**
     * Get all Place Review (without array count)
     *
     * @return boolean
     */
    public function action_all()
    {
        return \Bus\PlaceReviews_All::getInstance()->execute();
    }

    /**
     * Disable/Enable Place Review
     *
     * @return boolean
     */
    public function action_disable()
    {
        return \Bus\PlaceReviews_Disable::getInstance()->execute();
    }

    /**
     * Get detail Place Review
     *
     * @return boolean
     */
    public function action_detail()
    {
        return \Bus\PlaceReviews_Detail::getInstance()->execute();
    }
    
    /**
     * Update info for Place Review
     *
     * @return boolean
     */
    public function action_update()
    {
        return \Bus\PlaceReviews_Update::getInstance()->execute();
    }
    
    /**
     * Get History of Place Review
     *
     * @return boolean
     */
    public function action_history() {
        return \Bus\PlaceReviews_History::getInstance()->execute();
    }
    
}
