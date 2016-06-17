<?php

namespace Bus;

/**
 * Update info for User
 *
 * @package Bus
 * @created 2015-04-23
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Users_UpdateProfile extends BusAbstract
{
    /** @var array $_required field require */
    protected $_required = array(
        'user_id',
    );

    /** @var array $_length Length of fields */
    protected $_length = array(
        'user_id'       => array(1, 11),
        'password'      => array(4, 255),
        'name'          => array(1, 64),
        'kana'          => array(1, 64),
        'sex'           => 1,
        'phone'         => array(1, 64),
        'email'         => array(1, 255),
        'prefecture_id' => array(1, 11),
        'address1'      => array(1, 128),
        'address2'      => array(1, 128),
        'is_magazine'   => 1,
        'visit_element' => array(1, 11)
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'user_id',
        'sex',
        'prefecture_id',
        'is_magazine',
        'visit_element'
    );
    
    /**
     * Validate katakana name
     *
     * @author Tran Xuan Khoa
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function checkDataFormat($data)
    {
        //Validate kana's format
        $field = 'email';

        if (!empty($data[$field])) {           
            $pattern = "/^[A-Za-z0-9._%+-]+@([A-Za-z0-9-]+\.)+([A-Za-z0-9]{2,4}|museum)$/";
            if (!preg_match($pattern, $data[$field])) {
                $this->_addError(self::ERROR_CODE_INVALED_PARAMETER, $field, $data[$field]);
                $this->_invalid_parameter = $field;
                return false;
            }
        }

        return true;
    }

    /** @var array $_date_format date */
    protected $_date_format = array(
        'birthday' => 'Y-m-d',
    );

    /**
     * Call function update_profile() from model User
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_User::update_profile($data);
            return $this->result(\Model_User::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
