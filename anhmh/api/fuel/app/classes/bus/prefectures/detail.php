<?php

namespace Bus;

/**
 * Get detail Prefecture
 *
 * @package Bus
 * @created 2015-03-25
 * @version 1.0
 * @author Tran Xuan Khoa
 * @copyright Oceanize INC
 */
class Prefectures_Detail extends BusAbstract
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
     * Call function get_detail() from model Prefecture
     *
     * @author Tran Xuan Khoa
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Prefecture::get_detail($data);
            return $this->result(\Model_Prefecture::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
