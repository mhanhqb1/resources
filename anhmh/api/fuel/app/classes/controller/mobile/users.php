<?php

/**
 * Controller for actions on User
 *
 * @package Controller
 * @created 2015-06-09
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Controller_Mobile_Users extends \Controller_App
{
    /**
     * Register User
     *
     * @return boolean
     */
    public function action_register()
    {        
        return \Bus\Mobile_Users_Register::getInstance()->execute();
    }

    /**
     * Update info for User
     *
     * @return boolean
     */
    public function action_updateProfile()
    {
        return \Bus\Mobile_Users_UpdateProfile::getInstance()->execute();
    }
    
    /**
     * get orderlist
     *
     * @return boolean
     */
    public function action_orderlist()
    {
    	return \Bus\Mobile_Users_OrderList::getInstance()->execute();
    }
}
