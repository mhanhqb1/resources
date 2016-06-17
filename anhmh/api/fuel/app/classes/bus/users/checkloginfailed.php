<?php
namespace Bus;

/**
 * Check login failed.
 *
 * @package Bus
 * @version 1.0
 * @copyright Oceanize INC
 */

class Users_CheckLoginFailed extends BusAbstract
{
    /**
     * call function check_login_failed() from model User.
     *
     * @author AnhMH
     * @param array $data Input array.
     * @return bool.
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_User::check_login_failed();
            return $this->result(\Model_User::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }

}