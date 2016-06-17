<?php

namespace Bus;

/**
 * check token in model user activation
 *
 * @package Bus
 * @created 2014-12-04
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class UserActivations_Check extends BusAbstract
{
    protected $_required = array(
        'token',      
        'regist_type'
    );
    
    //check length
    protected $_length = array(
        'token' => array(0, 255),        
        'regist_type' => array(0, 20),
    );
    
    //check number
    protected $_number_format = array(
        'expire_date'
    );

    protected $_default_value = array(
        'regist_type' => 'forget_password'
    );
    
    /**
     * call function check_token() from model User Activation
     *
     * @created 2014-12-04
     * @updated 2014-12-04
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
            $this->_response = \Model_User_Activation::check_token($data);
            return $this->result(\Model_User_Activation::error());
        } catch (\Exception $e)
        {
            $this->_exception = $e;
        }
        return false;
    }

}
