<?php

/**
 * Controller for actions on Follow Place
 *
 * @package Controller
 * @created 2015-06-29
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Controller_FollowPlaces extends \Controller_App
{
    /**
     * Add info for Follow Place
     *
     * @return boolean
     */
    public function action_add()
    {
        return \Bus\FollowPlaces_Add::getInstance()->execute();
    }

    /**
     * Get list Follow Place (using array count)
     *
     * @return boolean
     */
    public function action_list()
    {
        return \Bus\FollowPlaces_List::getInstance()->execute();
    }

    /**
     * Disable/Enable a Follow Place
     *
     * @return boolean
     */
    public function action_disable()
    {
        return \Bus\FollowPlaces_Disable::getInstance()->execute();
    }
}
