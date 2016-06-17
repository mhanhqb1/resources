<?php

namespace Bus;

/**
 * <Users_Forgetpassword - API to prpcess forgetpassword Users>
 *
 * @package Bus
 * @created 2014-12-18
 * @version 1.0
 * @author <tuancd>
 * @copyright Oceanize INC
 */
class Users_Forgetpassword extends BusAbstract {

    protected $_required = array(
        'email',
    );

    protected $_email_format = array(
        'email',
    );

    public function operateDB($data) {
        try {
            $this->_response = \Model_User::forget_password($data);
            return $this->result(\Model_User::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }

}
