<?php

/**
 * Controller for actions on Place 
 *
 * @package Controller
 * @created 2015-06-29
 * @version 1.0
 * @author Caolp
 * @copyright Oceanize INC
 */
class Controller_Places extends \Controller_App
{
    /**
     * Add or update info for Place 
     *
     * @return boolean
     */
    public function action_addUpdate()
    {
        return \Bus\Places_AddUpdate::getInstance()->execute();
    }

    /**
     * Get list Place  (using array count)
     *
     * @return boolean
     */
    public function action_list()
    {
        return \Bus\Places_List::getInstance()->execute();
    }

    /**
     * Get all Place  (without array count)
     *
     * @return boolean
     */
    public function action_all()
    {
        return \Bus\Places_All::getInstance()->execute();
    }

    /**
     * Disable/Enable Place 
     *
     * @return boolean
     */
    public function action_disable()
    {
        return \Bus\Places_Disable::getInstance()->execute();
    }

    /**
     * Get detail Place
     *
     * @return boolean
     */
    public function action_detail()
    {
        return \Bus\Places_Detail::getInstance()->execute();
    }

    /**
     * Search Place
     *
     * @return boolean
     */
    public function action_search()
    {
        return \Bus\Places_Search::getInstance()->execute();
    }

    /**
     * autocomplete
     *
     * @return boolean
     */
    public function action_autocomplete()
    {
        return \Bus\Places_Autocomplete::getInstance()->execute();
    }

    /**
     * Set want to visit with place
     *
     * @return boolean
     */
    public function action_wantToVisit()
    {
        return \Bus\Places_WantToVisit::getInstance()->execute();
    }

    /**
     * Add place by Google Place Id
     *
     * @return boolean
     */
    public function action_addFromGoogleMap()
    {
        return \Bus\Places_AddFromGoogleMap::getInstance()->execute();
    }

    /**
     * Get Place order by rank
     *
     * @return boolean
     */
    public function action_ranking()
    {
        return \Bus\Places_Ranking::getInstance()->execute();
    }

    /**
     * Get Place's recommend
     *
     * @return boolean
     */
    public function action_recommend()
    {
        return \Bus\Places_Recommend::getInstance()->execute();
    }

    /**
     * Get detail Place
     *
     * @return boolean
     */
    public function action_detailforedit()
    {
        return \Bus\Places_DetailForEdit::getInstance()->execute();
    }
    
    /**
     * Update place
     *
     * @return boolean
     */
    public function action_update()
    {
        return \Bus\Places_Update::getInstance()->execute();
    }
    
}