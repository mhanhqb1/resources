<?php

/**
 * Controller for actions of Orders for mobile
 *
 * @package Controller
 * @created 2015-06-10
 * @version 1.0
 * @author CaoLP
 * @copyright Oceanize INC
 */
class Controller_Mobile_Orders extends \Controller_App
{
    /**
     * Element Orders (using for mobile)
     *
     * @return boolean
     */
    public function action_element()
    {
        return \Bus\Mobile_Orders_Element::getInstance()->execute();
    }
}
