<?php

/**
 * Controller for actions on Notice
 *
 * @package Controller
 * @created 2015-07-08
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Controller_Notices extends \Controller_App
{
    /**
     * Get list Notice (using array count)
     *
     * @return boolean
     */
    public function action_list()
    {
        return \Bus\Notices_List::getInstance()->execute();
    }

    /**
     * Check read for Notice
     *
     * @return boolean
     */
    public function action_isRead() {
        return \Bus\Notices_IsRead::getInstance()->execute();
    }

    /**
     * Get detail Notice
     *
     * @return boolean
     */
    public function action_detail()
    {
        return \Bus\Notices_Detail::getInstance()->execute();
    }
}
