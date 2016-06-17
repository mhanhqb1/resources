<?php

namespace Bus;

/**
 * Check new Point
 *
 * @package Bus
 * @created 2016-03-21
 * @version 1.0
 * @author KienNH
 * @copyright Oceanize INC
 */
class Coins_Check extends BusAbstract {
    
    /** @var array $_required field require */
    protected $_required = array(
        'login_user_id',          
    );

    /** @var array $_length Length of fields */
    protected $_length = array(
        'login_user_id' => array(1, 11),
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'login_user_id',
    );

    /**
     * 
     * @param type $data
     * @return boolean
     */
    public function operateDB($data){
        try {
            $this->_response = \Model_User_Point_Log::check($data);
            return $this->result(\Model_User_Point_Log::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
