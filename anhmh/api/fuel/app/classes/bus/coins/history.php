<?php

namespace Bus;

/**
 * Get list Coin's history of User
 *
 * @package Bus
 * @created 2016-03-22
 * @version 1.0
 * @author KienNH
 * @copyright Oceanize INC
 */
class Coins_History extends BusAbstract {
    
    /** @var array $_length Length of fields */
    protected $_length = array(
        'user_id' => array(1, 11),
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'user_id',
    );
    
    public function operateDB($data) {
        try {
            $this->_response = \Model_User_Point_Log::get_history($data);
            return $this->result(\Model_User_Point_Log::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
    
}
