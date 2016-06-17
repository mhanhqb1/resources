<?php

namespace Bus;

/**
 * Unregister user notifications
 *
 * @package Bus
 * @created 2015-01-05
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class UserNotifications_Unregister extends BusAbstract
{
	protected $_required = array(		
		'regid',		
	);
    
	protected $_length = array(		
		'user_id' => array(1, 11),
	);

	protected $_number_format = array(		
		'user_id',
	);

	/**
	 * call function unregister() from model User Notification
	 *	
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
			$this->_response = \Model_User_Notification::unregister($data);
			return $this->result(\Model_User_Notification::error());
		} catch (\Exception $e) {
			$this->_exception = $e;
		}
		return false;
	}

}
