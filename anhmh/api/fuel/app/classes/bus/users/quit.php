<?php

namespace Bus;

/**
 * Cancel user
 *
 * @package Bus
 * @created 2015-05-25
 * @version 1.0
 * @author truongnn
 * @copyright Oceanize INC
 */
class Users_Quit extends BusAbstract
{
	/** @var array $_required require of fields */
    protected $_required = array(
        'login_user_id'
    );
    
     /** @var array $_length Length of fields */
    protected $_length = array(
        'login_user_id'    => array(1, 11)
    );
    
     /** @var array $_number_format field number */
    protected $_number_format = array(
        'login_user_id'
    );
    
    /**
     * Call function quite() from model Order
     *
     * @author truongnn
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_User::quit($data);
            return $this->result(\Model_User::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
