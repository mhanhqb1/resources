<?php

/**
 * Controller for actions of Nails for mobile
 *
 * @package Controller
 * @created 2015-06-09
 * @version 1.0
 * @author CaoLP
 * @copyright Oceanize INC
 */
class Controller_Mobile_Nails extends \Controller_App
{
    /**
     * Recommend Nails (using for mobile)
     *
     * @return boolean
     */
    public function action_recommend()
    {
        return \Bus\Mobile_Nails_Recommend::getInstance()->execute();
    }

    /**
     * Search Nails popup (using for mobile)
     *
     * @return boolean
     */
    public function action_searchpopup()
    {
        return \Bus\Mobile_Nails_SearchPopup::getInstance()->execute();
    }
    
    /**
     * Search Nails popup (using for mobile)
     *
     * @return boolean
     */
    public function action_search()
    {
    	return \Bus\Mobile_Nails_Search::getInstance()->execute();
    }
}
