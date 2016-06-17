<?php

namespace Bus;

/**
 * Update info for User
 *
 * @package Bus
 * @created 2015-06-09
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Mobile_Users_UpdateProfile extends BusAbstract
{
    /** @var array $_required field require */
    protected $_required = array(
        'login_user_id',
    );

    /** @var array $_length Length of fields */
    protected $_length = array(
        'login_user_id' => array(1, 11),
        'email' => array(1, 255),
        'password' => array(6, 40),
        'name' => array(1, 64),
        'sex_id' => 1,
        'zipcode' => 8,
        'user_physical_type_id' => array(1, 11),
    );

    /** @var array $_number_format field number */
     protected $_number_format = array(
        'login_user_id',
        'sex_id',
        'user_physical_type_id',
    );

    /** @var array $_date_format date */
    protected $_date_format = array(
        'birthday' => 'Y-m-d',
    );

    /**
     * Call function update_profile_by_mobile() from model User
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_User::update_profile_by_mobile($data);
            return $this->result(\Model_User::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
