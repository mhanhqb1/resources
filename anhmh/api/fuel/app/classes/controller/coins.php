<?php

/**
 * Controller for actions on Coin
 *
 * @package Controller
 * @created 2016-03-22
 * @version 1.0
 * @author KienNH
 * @copyright Oceanize INC
 */
class Controller_Coins extends \Controller_App {
    
    /**
     * Get coin's hisoty of User
     *
     * @return boolean
     */
    public function action_history() {
        return \Bus\Coins_History::getInstance()->execute();
    }
    
    /**
     * Get User coin ranking list
     * 
     * @return boolean
     */
    public function action_ranking() {
        return \Bus\Coins_Ranking::getInstance()->execute();
    }
    
    /**
     * Get new point
     * @return integer
     */
    public function action_check() {
        return \Bus\Coins_Check::getInstance()->execute();
    }
    
}
