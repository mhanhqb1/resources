<?php

/**
 * Controller for actions on Config
 *
 * @package Controller
 * @created 2015-06-16
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Controller_Mobile_Config extends \Controller_App
{
    /**
     * Get config for mobile
     *
     * @return boolean
     */
    public function action_index()
    {
        return \Bus\Mobile_Config_Index::getInstance()->execute();
    }
}
