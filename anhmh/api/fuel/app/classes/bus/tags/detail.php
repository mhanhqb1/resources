<?php

namespace Bus;

/**
 * Get detail Tags
 *
 * @package Bus
 * @created 2015-03-20
 * @version 1.0
 * @author Hoang Gia Thong
 * @copyright Oceanize INC
 */
class Tags_Detail extends BusAbstract
{
    /** @var array $_required field require */
    protected $_required = array(
        'id'
    );

    /** @var array $_length Length of fields */
    protected $_length = array(
        'id'     => array(1, 11),        
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'id',   
    );

    /**
     * Call function get_detail() from model Tags
     *
     * @author Hoang Gia Thong
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Tag::get_detail($data);
            return $this->result(\Model_Tag::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
