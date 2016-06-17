<?php

namespace Bus;

/**
 * User profile
 *
 * @package Bus
 * @created 2015-07-01
 * @version 1.0
 * @author Caolp
 * @copyright Oceanize INC
 */
class Users_Profile extends BusAbstract
{
    /** @var array $_required field require */
    protected $_required = array(
        'user_id',
    );

    /** @var array $_length Length of fields */
    protected $_length = array(

    );
    
    /** @var array $_email_format field email */
    protected $_number_format = array(
        'login_user_id',
        'user_id',
        'page',
        'limit'
    );
    
    /**
     * Call function get_profile() from model User
     *
     * @author Caolp
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_User::get_profile($data);
            return $this->result(\Model_User::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}