<?php

/**
 * Controller for actions on Place Review Like
 *
 * @package Controller
 * @created 2015-06-30
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Controller_PlaceReviewLikes extends \Controller_App
{
    /**
     * Add info for Place Review Like
     *
     * @return boolean
     */
    public function action_add()
    {
        return \Bus\PlaceReviewLikes_Add::getInstance()->execute();
    }

    /**
     * Get list Place Review Like (using array count)
     *
     * @return boolean
     */
    public function action_list()
    {
        return \Bus\PlaceReviewLikes_List::getInstance()->execute();
    }

    /**
     * Disable/Enable a Place Review Like
     *
     * @return boolean
     */
    public function action_disable()
    {
        return \Bus\PlaceReviewLikes_Disable::getInstance()->execute();
    }
}
