<?php

namespace Bus;

/**
 * update password by token
 *
 * @package Bus
 * @created 2015 -Apr -10
 * @version 1.0
 * @author Tuan Cao
 * @copyright Oceanize INC
 */
class Users_UpdatePassword extends BusAbstract
{
    protected $_required = array(
        'token',
        'password',
    );

    protected $_length = array(
        'password' => array(6, 40),
    );

    protected $_default_value = array(
        'regist_type' => 'forget_password'
    );

    /**
     * call function update_password() from model User.
     *
     * @created 2014-12-04
     * @updated 2014-12-04
     * @access public
     * @author Tuan Cao
     * @param $data
     * @return bool
     * @example
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_User::update_password($data);
            return $this->result(\Model_User::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }

}
