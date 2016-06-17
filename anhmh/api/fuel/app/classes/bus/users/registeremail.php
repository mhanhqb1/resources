<?php

namespace Bus;

/**
 * add register mail
 *
 * @package Bus
 * @created 2014-12-18
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Users_RegisterEmail extends BusAbstract
{
	protected $_required = array(
		'email',
		'password',		
	);

	protected $_email_format = array(
		'email'
	);

	protected $_number_format = array(
		'sex_id'
	);
    
    /** @var array $_length Length of fields */
    protected $_length = array(
        'password' => array(6, 40),
    );

	/**
	 * call function register_email() from model User Activation
	 *
	 * @created 2014-12-18
	 * @updated 2014-12-18
	 * @access public
	 * @author Le Tuan Tu
	 * @param $data
	 * @return bool
	 * @example
	 */
	public function operateDB($data)
	{
		try {
			$this->_response = \Model_User_Activation::register_email($data);
			return $this->result(\Model_User_Activation::error());
		} catch (\Exception $e) {
			$this->_exception = $e;
		}
		return false;
	}

}
