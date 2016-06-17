<?php

namespace Bus;

/**
 * Get all Tags (without array count)
 *
 * @package Bus
 * @created 2015-03-20
 * @version 1.0
 * @author Hoang Gia Thong
 * @copyright Oceanize INC
 */
class Tags_All extends BusAbstract
{
    /** @var array $_length Length of fields */
    protected $_length = array(
        'disable' => 1
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'disable'
    );

    /**
     * Call function get_all() from model Tags
     *
     * @author Hoang Gia Thong
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Tag::get_all();
            return $this->result(\Model_Tag::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
