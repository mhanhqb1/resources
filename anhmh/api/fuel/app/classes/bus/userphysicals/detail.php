<?php

namespace Bus;

/**
 * Get detail User Physical
 *
 * @package Bus
 * @created 2015-06-29
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class UserPhysicals_Detail extends BusAbstract
{
    /** @var array $_required field require */
    protected $_required = array(
        'id'
    );

    /** @var array $_length Length of fields */
    protected $_length = array(
        'id' => array(1, 11)
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'id'
    );

    /**
     * Call function get_detail() from model User Physical
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_User_Physical::get_detail($data);
            return $this->result(\Model_User_Physical::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
