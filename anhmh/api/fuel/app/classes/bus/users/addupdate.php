<?php

namespace Bus;

/**
 * Add and update info for User
 *
 * @package Bus
 * @created 2015-03-19
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Users_AddUpdate extends BusAbstract
{
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
        'image_path'            => array(1, 255),
        'count_follow'          => array(1, 11),
        'count_follower'        => array(1, 11),
        'disable_by_user'       => 1,
        'is_ios'                => 1,
        'is_android'            => 1,
        'is_web'                => 1,
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'sex_id',
        'user_physical_type_id',
        'count_follow',
        'count_follower',
        'disable_by_user',
        'is_ios',
        'is_android',
        'is_web'
    );

    /** @var array $_default_value field default */
    protected $_default_value = array(
        'sex_id'                => 0,
        'user_physical_type_id' => 0,
        'count_follow'          => 0,
        'count_follower'        => 0,
        'disable_by_user'       => 0,
        'is_ios'                => 0,
        'is_android'            => 0,
        'is_web'                => 0
    );

    /** @var array $_date_format date */
    protected $_date_format = array(
        'birthday' => 'Y-m-d',
    );

    /**
     * Call function add_update() from model User
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_User::add_update($data);
            return $this->result(\Model_User::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
