<?php

/**
 * Controller for actions on Place View Point Log
 *
 * @package Controller
 * @created 2015-06-29
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Controller_PlaceReviewPointLogs extends \Controller_App
{
    /**
     * Add info for Place View Point Log
     *
     * @return boolean
     */
    public function action_add()
    {
        return \Bus\PlaceReviewPointLogs_Add::getInstance()->execute();
    }

    /**
     * Get list Place View Point Log (using array count)
     *
     * @return boolean
     */
    public function action_list()
    {
        return \Bus\PlaceReviewPointLogs_List::getInstance()->execute();
    }

    /**
     * Disable/Enable a Place View Point Log
     *
     * @return boolean
     */
    public function action_disable()
    {
        return \Bus\PlaceReviewPointLogs_Disable::getInstance()->execute();
    }
}
