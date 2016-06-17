<?php

namespace Bus;

/**
 * Check read for Notices
 *
 * @package Bus
 * @created 2015-07-09
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Notices_IsRead extends BusAbstract
{
    /** @var array $_required field require */
    protected $_required = array(
        'id',
        'is_read',
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'is_read'
    );

    /** @var array $_length Length of fields */
    protected $_length = array(
        'is_read' => 1
    );

    /**
     * Call function is_read() from model Question
     *
     * @author Le Tuan Tu
     * @param $data
     * @return bool True if update successfully or otherwise.
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Notice::is_read($data);
            return $this->result(\Model_Notice::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
