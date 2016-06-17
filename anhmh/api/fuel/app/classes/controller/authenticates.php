<?php

/**
 * Controller for actions on Authenticates
 *
 * @package Controller
 * @created 2014-12-25
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Controller_Authenticates extends \Controller_App
{
    /**
     * Get detail of Authenticate
     *  
     * @return boolean    
     */
	public function action_detail() {
		return \Bus\Authenticates_Detail::getInstance()->execute();
	}
    
    /**
     * Add new Authenticate
     *  
     * @return boolean
     */
	public function action_add() {
		return \Bus\Authenticates_Add::getInstance()->execute();
	}

}