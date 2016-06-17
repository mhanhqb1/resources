<?php

/**
 * Controller for actions on Email
 *
 * @package Controller
 * @created 2016-04-28
 * @version 1.0
 * @author KienNH
 * @copyright Oceanize INC
 */
class Controller_Emails extends \Controller_App {
    
    /**
     * Send contact mail
     *
     * @return boolean
     */
    public function action_contact()
    {
        return \Bus\Emails_Contact::getInstance()->execute();
    }
    
}
