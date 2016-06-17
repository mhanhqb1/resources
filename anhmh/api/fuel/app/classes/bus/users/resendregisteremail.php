<?php

namespace Bus;

/**
 * add resend register mail
 *
 * @package Bus
 * @created 2015-01-27
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Users_ResendRegisterEmail extends BusAbstract
{
    protected $_required = array(
        'email'
    );

    protected $_email_format = array(
        'email'
    );

    /**
     * call function resend_register_email() from model User Activation
     *
     * @created 2015-01-27
     * @updated 2015-01-27
     * @access public
     * @author Le Tuan Tu
     * @param $data
     * @return bool
     * @example
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_User_Activation::resend_register_email($data);
            return $this->result(\Model_User_Activation::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
