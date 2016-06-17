<?php

namespace Bus;

/**
 * add or update info for user profile
 *
 * @package Bus
 * @created 2014-11-25
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class UserActivations_AddUpdate extends BusAbstract
{

    //check length
    protected $_length = array(
        'id' => array(1, 11),
        'user_id' => array(0, 11),
        'password' => array(0, 40),
        'token' => array(0, 255),
        'expire_date' => array(1, 11),
        'regist_type' => array(0, 20),
    );
    //check number
    protected $_number_format = array(
        'id',
        'user_id',
        'expire_date'
    );
    //check email
    protected $_email_format = array(
        'email',
    );

    /**
     * call function add_update() from model User Profile
     *
     * @created 2014-11-25
     * @updated 2014-11-25
     * @access public
     * @author Le Tuan Tu
     * @param $data
     * @return bool
     * @example
     */
    public function operateDB($data)
    {
        try
        {
            $this->_response = \Model_User_Activation::add_update($data);
            return $this->result(\Model_User_Activation::error());
        } catch (\Exception $e)
        {
            $this->_exception = $e;
        }
        return false;
    }

}
