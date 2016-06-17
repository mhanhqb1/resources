<?php

namespace Bus;

/**
 * add info for authenticates
 *
 * @package Bus
 * @created 2014-12-25
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Authenticates_Add extends BusAbstract
{
	// check require
	protected $_required = array(
		'user_id',
		'regist_type'
	);

	// check number
	protected $_number_format = array(
		'user_id'
	);

	// check length
	protected $_length = array(
		'user_id' => array(1, 11),
		'regist_type' => array(0, 20)
	);

	/**
	 * call function add() from model authenticate
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
			$this->_response = \Model_Authenticate::add($data);
			return $this->result(\Model_Authenticate::error());
		} catch (\Exception $e) {
			$this->_exception = $e;
		}
		return false;
	}

}
