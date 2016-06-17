<?php

namespace Bus;

/**
 * Get list User Coin's ranking
 *
 * @package Bus
 * @created 2016-03-23
 * @version 1.0
 * @author KienNH
 * @copyright Oceanize INC
 */
class Coins_Ranking extends BusAbstract {
    
    public function operateDB($data) {
        try {
            $this->_response = \Model_User_Point_Get_Total_Ranking::get_ranking($data);
            return $this->result(\Model_User_Point_Get_Total_Ranking::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
    
}
