<?php

/**
 * Controller for actions on Place Favorite
 *
 * @package Controller
 * @created 2015-06-26
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Controller_PlaceFavorites extends \Controller_App
{
    /**
     * Add info for Place Favorite
     *
     * @return boolean
     */
    public function action_add()
    {
        return \Bus\PlaceFavorites_Add::getInstance()->execute();
    }

    /**
     * Get list Place Favorite (using array count)
     *
     * @return boolean
     */
    public function action_list()
    {
        return \Bus\PlaceFavorites_List::getInstance()->execute();
    }

    /**
     * Get all Place Favorite (without  array count)
     *
     * @return boolean
     */
    public function action_all()
    {
        return \Bus\PlaceFavorites_All::getInstance()->execute();
    }

    /**
     * Disable/Enable a Place Favorite
     *
     * @return boolean
     */
    public function action_disable()
    {
        return \Bus\PlaceFavorites_Disable::getInstance()->execute();
    }
    
    /**
     * Get top Place Favorite (without  array count)
     *
     * @return boolean
     */
    public function action_top()
    {
        return \Bus\PlaceFavorites_Top::getInstance()->execute();
    }
    
}
