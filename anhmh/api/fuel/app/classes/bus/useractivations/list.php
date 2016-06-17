<?php

namespace Bus;

/**
 * get list user profile
 *
 * @package Bus
 * @created 2014-11-25
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class UserActivations_List extends BusAbstract
{

    //check length
    protected $_length = array(
        'id' => array(1, 11),
    );
    //check number
    protected $_number_format = array(
        'id',
        'page',
        'limit'
    );
    //check email
    protected $_email_format = array(
        'email',
    );

    /**
     * call function get_list() from model User Profile
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
            $this->_response = \Model_User_Activation::get_list($data);
            return $this->result(\Model_User_Activation::error());
        } catch (\Exception $e)
        {
            $this->_exception = $e;
        }
        return false;
    }

}
