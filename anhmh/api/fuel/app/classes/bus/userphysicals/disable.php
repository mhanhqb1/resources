<?php

namespace Bus;

/**
 * Disable/Enable User Physical
 *
 * @package Bus
 * @created 2015-06-29
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class UserPhysicals_Disable extends BusAbstract
{
    /** @var array $_required field require */
    protected $_required = array(
        'id',
        'disable'
    );

    /** @var array $_length Length of fields */
    protected $_length = array(
        'disable' => 1
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'disable'
    );

    /**
     * Call function disable() from model User Physical
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_User_Physical::disable($data);
            return $this->result(\Model_User_Physical::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
