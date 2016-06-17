<?php

namespace Bus;

/**
 * Check user's password
 *
 * @package Bus
 * @created 2015-05-25
 * @version 1.0
 * @author truongnn
 * @copyright Oceanize INC
 */
class Users_CheckPassword extends BusAbstract
{
	/** @var array $_required require of fields */
    protected $_required = array(
        'email',
        'password'
    );

    /** @var array $_email_format field email */
    protected $_email_format = array(
        'email'
    );

    /**
     * Call function checkPassword() from model Order
     *
     * @author diennvt
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_User::check_password($data);
            return $this->result(\Model_User::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
