<?php

namespace Bus;

/**
 * Add or update info for Prefecture
 *
 * @package Bus
 * @created 2015-03-25
 * @version 1.0
 * @author Tran Xuan Khoa
 * @copyright Oceanize INC
 */
class Prefectures_AddUpdate extends BusAbstract
{
    /** @var array $_length Length of fields */
    protected $_length = array(
        'id'      => array(1, 11),
        'name'    => array(1, 32)
    );
    
    /** @var array $_number_format field number */
    protected $_number_format = array(
        'id'
    );

    /**
     * Call function add_update() from model Prefecture
     *
     * @author Tran Xuan Khoa
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Prefecture::add_update($data);
            return $this->result(\Model_Prefecture::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
