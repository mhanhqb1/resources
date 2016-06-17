<?php

/**
 * Controller for actions on Place Pin
 *
 * @package Controller
 * @created 2015-06-30
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Controller_PlacePins extends \Controller_App
{
    /**
     * Add info for Place Pin
     *
     * @return boolean
     */
    public function action_add()
    {
        return \Bus\PlacePins_Add::getInstance()->execute();
    }

    /**
     * Get list Place Pin (using array count)
     *
     * @return boolean
     */
    public function action_list()
    {
        return \Bus\PlacePins_List::getInstance()->execute();
    }

    /**
     * Disable/Enable a Place Pin
     *
     * @return boolean
     */
    public function action_disable()
    {
        return \Bus\PlacePins_Disable::getInstance()->execute();
    }
}
