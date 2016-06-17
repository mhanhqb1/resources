<?php

namespace Bus;

/**
 * Check email
 *
 * @package Bus
 * @created 2015-06-17
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Users_CheckEmail extends BusAbstract
{
    /** @var array $_required field require */
    protected $_required = array(
        'email',
    );
   
    protected $_email_format = array(
		'email'
	);
    
    /**
     * Call function check_email() from model User
     *
     * @author thailh
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_User::check_email($data);
            return $this->result(\Model_User::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
