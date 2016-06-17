<?php

namespace Bus;

/**
 * Disable/Enable list Tags
 *
 * @package Bus
 * @created 2015-03-20
 * @version 1.0
 * @author Hoang Gia Thong
 * @copyright Oceanize INC
 */
class Tags_Disable extends BusAbstract
{
    /** @var array $_required field require */
    protected $_required = array(
        'id',
        'disable'
    );

    /** @var array $_length Length of fields */
    protected $_length = array(
        'id'     => array(1, 11),
        'disable' => 1
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'id',
        'disable'
    );

    /**
     * Call function disable() from model Tags
     *
     * @author Hoang Gia Thong
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Tag::disable($data);
            return $this->result(\Model_Tag::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
