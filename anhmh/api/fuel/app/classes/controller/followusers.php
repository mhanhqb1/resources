<?php

/**
 * Controller for actions on Follow User
 *
 * @package Controller
 * @created 2015-06-26
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Controller_FollowUsers extends \Controller_App
{
    /**
     * Add info for Follow User
     *
     * @return boolean
     */
    public function action_add()
    {
        return \Bus\FollowUsers_Add::getInstance()->execute();
    }

    /**
     * Get list Follow User (using array count)
     *
     * @return boolean
     */
    public function action_list()
    {
        return \Bus\FollowUsers_List::getInstance()->execute();
    }

    /**
     * Disable/Enable a Follow User
     *
     * @return boolean
     */
    public function action_disable()
    {
        return \Bus\FollowUsers_Disable::getInstance()->execute();
    }
    
    /**
     * Get list Follow User (using array count)
     *
     * @return boolean
     */
    public function action_ifollow()
    {
        return \Bus\FollowUsers_IFollow::getInstance()->execute();
    }
    
    /**
     * Get list Follow User (using array count)
     *
     * @return boolean
     */
    public function action_followme()
    {
        return \Bus\FollowUsers_FollowMe::getInstance()->execute();
    }
}
