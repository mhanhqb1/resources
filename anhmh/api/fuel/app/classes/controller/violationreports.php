<?php

/**
 * Controller for actions on Violation_report
 *
 * @package Controller
 * @version 1.0
 * @author truongnn
 * @copyright Oceanize INC
 */
class Controller_ViolationReports extends \Controller_App
{
    /**
     * Add info for Violation_report
     *
     * @return boolean
     */
    public function action_add()
    {
        return \Bus\ViolationReports_Add::getInstance()->execute();
    }

     /**
     * Get list Violation_report (using array count)
     *
     * @return boolean
     */
    public function action_all()
    {
        return \Bus\ViolationReports_All::getInstance()->execute();
    }
    
    /**
     * Get list Violation_report (using array count)
     *
     * @return boolean
     */
    public function action_list()
    {
        return \Bus\ViolationReports_List::getInstance()->execute();
    }

    /**
     * Disable/Enable a Violation_report
     *
     * @return boolean
     */
    public function action_disable()
    {
        return \Bus\ViolationReports_Disable::getInstance()->execute();
    }
}
