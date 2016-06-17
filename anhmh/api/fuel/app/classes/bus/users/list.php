<?php

namespace Bus;

/**
 * Get list User (with array count)
 *
 * @package Bus
 * @created 2015-03-19
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Users_List extends BusAbstract
{
    /** @var array $_email_format field email */
    protected $_email_format = array(
        'email'
    );

    /** @var array $_length Length of fields */
    protected $_length = array(
        'id'                    => array(1, 11),
        'email'                 => array(1, 255),
        'name'                  => array(1, 64),
        'sex_id'                => 1,
        'zipcode'               => array(1, 50),
        'user_physical_type_id' => array(1, 11),
        'disable_by_user'       => 1,
        'is_ios'                => 1,
        'is_android'            => 1,
        'is_web'                => 1,
        'disable'               => 1
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'id',
        'sex_id',
        'user_physical_type_id',
        'disable_by_user',
        'is_ios',
        'is_android',
        'is_web',
        'page',
        'limit',
        'disable'
    );

    /**
     * Call function get_list() from model User
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_User::get_list($data);
            return $this->result(\Model_User::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
