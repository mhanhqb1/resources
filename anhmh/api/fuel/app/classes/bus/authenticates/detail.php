<?php

namespace Bus;

/**
 * get detail authenticates
 *
 * @package Bus
 * @created 2014-12-25
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Authenticates_Detail extends BusAbstract
{
	// check require
	protected $_required = array(
		'token',
	);

	// check length
	protected $_length = array(
		'token' => array(0, 40)
	);

	/**
	 * get detail authenticates by token
	 *
	 * @created 2014-12-25
	 * @updated 2014-12-25
	 * @access public
	 * @author Le Tuan Tu
	 * @param $data
	 * @return bool
	 * @example
	 */
	public function operateDB($data)
	{
		try {
			$this->_response = \Model_Authenticate::get_detail($data);
			return $this->result(\Model_Authenticate::error());
		} catch (\Exception $e) {
			$this->_exception = $e;
		}
		return false;
	}

}
