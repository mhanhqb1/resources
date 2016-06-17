<?php

/**
 * Controller for actions on User Notification
 *
 * @package Controller
 * @created 2015-07-25
 * @version 1.0
 * @author thailh
 * @copyright Oceanize INC
 */
class Controller_UserNotifications extends \Controller_App
{
    /**
     *  Registion notification for user
     * 
     * @return boolean 
     */
	public function action_register()
	{
		return \Bus\UserNotifications_Register::getInstance()->execute();
	}

    /**
     *  Unregistion notification for user
     * 
     * @return boolean 
     */
	public function action_unregister()
	{
		return \Bus\UserNotifications_Unregister::getInstance()->execute();
	}
    
}