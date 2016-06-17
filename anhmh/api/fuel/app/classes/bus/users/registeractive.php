<?php

namespace Bus;

/**
 * add register active
 *
 * @package Bus
 * @created 2014-12-18
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Users_RegisterActive extends BusAbstract
{
	protected $_required = array(
		'token'
	);

	protected $_email_format = array(
		'email'
	);

	/**
	 * call function register_active() from model User
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
			$this->_response = \Model_User_Activation::register_active($data);
			return $this->result(\Model_User_Activation::error());
		} catch (\Exception $e) {
			$this->_exception = $e;
		}
		return false;
	}

}
