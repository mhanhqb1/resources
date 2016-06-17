<?php

namespace Bus;

/**
 * add or update info for register user notifications
 *
 * @package Bus
 * @created 2015-07-25
 * @version 1.0
 * @author thailh
 * @copyright Oceanize INC
 */
class UserNotifications_Register extends BusAbstract
{
    protected $_required = array(
		'login_user_id',
		'regid',
	);
    
	protected $_length = array(		
		'user_id' => array(1, 11),
	);

	protected $_number_format = array(		
		'user_id',
	);

	/**
	 * call function register() from model User Notification
	 *
	 * @created 2014-12-26
	 * @updated 2014-12-26
	 * @access public
	 * @author Le Tuan Tu
	 * @param $data
	 * @return bool
	 * @example
	 */
	public function operateDB($data)
	{
		try {
            if (!empty($data['login_user_id'])) {
                $data['user_id'] = $data['login_user_id'];
            }
			$this->_response = \Model_User_Notification::register($data);
			return $this->result(\Model_User_Notification::error());
		} catch (\Exception $e) {
			$this->_exception = $e;
		}
		return false;
	}

}
