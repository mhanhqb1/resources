<?php

namespace Bus;

/**
 * <Users_Token - Add token to user>
 *
 * @package Bus
 * @created 2015-01-23
 * @version 1.0
 * @author <truongnn>
 * @copyright Oceanize INC
 */
class Users_Token extends BusAbstract {

    protected $_required = array(
        'user_id',
        'regist_type'
    );
    protected $_length = array(
        'user_id' => array(1, 11),
        'regist_type' => array(1, 20)
    );

    public function operateDB($data) {
        try {
            $this->_response = \Model_Authenticate::addupdate(array(
                    'user_id' => $data['user_id'],
                    'regist_type' => $data['regist_type']
                )
            );            
            return $this->result(\Model_User::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }

}
