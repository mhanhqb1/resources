<?php

/**
 * Controller for actions on Help
 *
 * @package Controller
 * @created 2015-07-08
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Controller_Helps extends \Controller_App
{
    /**
     * Add or update info for Help
     *
     * @return boolean
     */
    public function action_addUpdate()
    {
        return \Bus\Helps_AddUpdate::getInstance()->execute();
    }

    /**
     * Get list Help (using array count)
     *
     * @return boolean
     */
    public function action_list()
    {
        return \Bus\Helps_List::getInstance()->execute();
    }

    /**
     * Get all Help (without array count)
     *
     * @return boolean
     */
    public function action_all()
    {
        return \Bus\Helps_All::getInstance()->execute();
    }

    /**
     * Disable/Enable Help
     *
     * @return boolean
     */
    public function action_disable()
    {
        return \Bus\Helps_Disable::getInstance()->execute();
    }

    /**
     * Get detail Help
     *
     * @return boolean
     */
    public function action_detail()
    {
        return \Bus\Helps_Detail::getInstance()->execute();
    }

    /**
     * Get view Help
     *
     * @return boolean
     */
    public function action_view()
    {
        return \Model_Help::get_view();
    }

    /**
     * Get view detail Help
     *
     * @param int $id Input data
     * @return boolean
     */
    public function action_viewDetail($id = 0)
    {
        return \Model_Help::get_view_detail($id);
    }
}
