<?php

/**
 * Controller for actions on Place Review Comment
 *
 * @package Controller
 * @created 2015-07-03
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Controller_PlaceReviewComments extends \Controller_App
{
    /**
     * Add or update info for Place Review Comment
     *
     * @return boolean
     */
    public function action_addUpdate()
    {
        return \Bus\PlaceReviewComments_AddUpdate::getInstance()->execute();
    }

    /**
     * Get list Place Review Comment (using array count)
     *
     * @return boolean
     */
    public function action_list()
    {
        return \Bus\PlaceReviewComments_List::getInstance()->execute();
    }

    /**
     * Get all Place Review Comment (without array count)
     *
     * @return boolean
     */
    public function action_all()
    {
        return \Bus\PlaceReviewComments_All::getInstance()->execute();
    }

    /**
     * Disable/Enable Place Review Comment
     *
     * @return boolean
     */
    public function action_disable()
    {
        return \Bus\PlaceReviewComments_Disable::getInstance()->execute();
    }

    /**
     * Get detail Place Review Comment
     *
     * @return boolean
     */
    public function action_detail()
    {
        return \Bus\PlaceReviewComments_Detail::getInstance()->execute();
    }

    /**
     * Get all Place Review Comment by Place Review Id (using array count)
     *
     * @return boolean
     */
    public function action_listByPlaceReviewId()
    {
        return \Bus\PlaceReviewComments_ListByPlaceReviewId::getInstance()->execute();
    }
    
    /**
     * Update comment
     *
     * @return boolean
     */
    public function action_update()
    {
        return \Bus\PlaceReviewComments_Update::getInstance()->execute();
    }
}
