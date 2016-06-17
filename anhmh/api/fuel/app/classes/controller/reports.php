<?php

/**
 * Controller for actions to report
 *
 * @package Controller
 * @created 2014-12-26
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Controller_Reports extends \Controller_App
{
    /**
     *  Get list commont report data
     * 
     * @return boolean 
     */
	public function action_general() {
		return \Bus\Reports_General::getInstance()->execute();
	}
    
    /**
     *  Get dau report data
     * 
     * @return boolean 
     */
	public function action_dau() {
		return \Bus\Reports_Dau::getInstance()->execute();
	}

	/**
	 *  Get user report data
	 *
	 * @return boolean
	 */
	public function action_usergraph() {
		return \Bus\Reports_Usergraph::getInstance()->execute();
	}



}