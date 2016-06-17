<?php

namespace Bus;

/**
 * Get all User Physical (without array count)
 *
 * @package Bus
 * @created 2015-06-29
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class UserPhysicals_All extends BusAbstract
{
    /** @var array $_length Length of fields */
    protected $_length = array(
        'type_id'       => array(1, 11),
        'language_type' => 1
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'type_id',
        'language_type'
    );

    /**
     * Call function get_all() from model User Physical
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_User_Physical::get_all($data);
            return $this->result(\Model_User_Physical::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
