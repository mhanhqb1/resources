<?php

namespace Bus;

/**
 * Change password.
 *
 * @package Bus
 * @version 1.0
 * @copyright Oceanize INC
 */
class Users_ChangePassword extends BusAbstract
{
    protected $_required = array(
        'id',
        //'email',
        'password',
        //'password_old'
    );

    protected $_length = array(
        'password' => array(6, 40),
    );

    /**
     * call function change_password() from model User.
     *
     * @author truongnn
     * @param array $data Input array.
     * @return bool True if change password successfully or otherwise.
     */
    public function operateDB($data)
    {
        $authToken = \Model_Authenticate::check_token();
        if (!empty($authToken['regist_type'])) {
            $data['regist_type'] = $authToken['regist_type'];
        }
        try {
            $this->_response = \Model_User::change_password($data);
            return $this->result(\Model_User::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }

}
