<?php

namespace Bus;

use Lib\Util;

/**
 * Register User
 *
 * @package Bus
 * @created 2015-06-25
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Mobile_Users_Register extends BusAbstract
{
    /** @var array $_required field require */
    protected $_required = array(
        'email',
        'password'
    );

    /** @var array $_email_format field email */
    protected $_email_format = array(
        'email'
    );

    /** @var array $_length Length of fields */
    protected $_length = array(
        'email'                 => array(1, 255),
        'password'              => array(4, 255),
        'name'                  => array(1, 64),
        'sex_id'                => 1,
        'zipcode'               => array(1, 50),
        'user_physical_type_id' => array(1, 11),
        'is_ios'                => 1,
        'is_android'            => 1,
        'is_web'                => 1,
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'sex_id',
        'user_physical_type_id',
        'is_ios',
        'is_android',
        'is_web'
    );

    /** @var array $_default_value field default */
    protected $_default_value = array(
        'sex_id'                => 0,
        'user_physical_type_id' => 0,
        'is_ios'                => 0,
        'is_android'            => 0,
        'is_web'                => 0
    );

    /** @var array $_date_format date */
    protected $_date_format = array(
        'birthday' => 'Y-m-d',
    );

    /**
     * Call function register_by_mobile() from model User
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_User::register_by_mobile($data);
            return $this->result(\Model_User::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }

}
