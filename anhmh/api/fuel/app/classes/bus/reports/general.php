<?php

namespace Bus;

/**
 * get general report
 *
 * @package Bus
 * @created 2014-12-29
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Reports_General extends BusAbstract
{
    //check date
    protected $_date_format = array(
        'date_from' => 'Y-m-d',
        'date_to' => 'Y-m-d'
    );
	/**
	 * get general report
	 *
	 * @created 2014-12-29
	 * @updated 2014-12-29
	 * @access public
	 * @author Le Tuan Tu
	 * @param $data
	 * @return bool
	 * @example
	 */
	public function operateDB($data)
	{
		try {
			$this->_response = \Model_Report::general($data);
			return $this->result(\Model_Report::error());
		} catch (\Exception $e) {
			$this->_exception = $e;
		}
		return false;
	}

}
