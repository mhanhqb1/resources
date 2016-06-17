<?php

/**
 * Controller for actions on Place Review Comment Like
 *
 * @package Controller
 * @created 2015-07-12
 * @version 1.0
 * @author Caolp
 * @copyright Oceanize INC
 */
class Controller_PlaceReviewCommentLikes extends \Controller_App
{
    /**
     * Add info for Place Review Comment Like
     *
     * @return boolean
     */
    public function action_add()
    {
        return \Bus\PlaceReviewCommentLikes_Add::getInstance()->execute();
    }

    /**
     * Get list Place Review Comment Like (using array count)
     *
     * @return boolean
     */
    public function action_list()
    {
        return \Bus\PlaceReviewCommentLikes_List::getInstance()->execute();
    }

    /**
     * Disable/Enable a Place Review Comment Like
     *
     * @return boolean
     */
    public function action_disable()
    {
        return \Bus\PlaceReviewCommentLikes_Disable::getInstance()->execute();
    }
}
