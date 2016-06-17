<?php

namespace Bus;

/**
 * Get detail Team
 *
 * @package Bus
 * @created 2015-07-01
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Teams_Detail extends BusAbstract
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
     * Call function get_detail() from model Team
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Team::get_detail($data);
            return $this->result(\Model_Team::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
