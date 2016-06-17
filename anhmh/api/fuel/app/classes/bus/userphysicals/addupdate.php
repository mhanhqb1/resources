<?php

namespace Bus;

/**
 * Add or update info for User Physical
 *
 * @package Bus
 * @created 2015-06-29
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class UserPhysicals_AddUpdate extends BusAbstract
{
    /** @var array $_length Length of fields */
    protected $_length = array(
        'id'            => array(1, 11),
        'type_id'       => array(1, 11),
        'name'          => array(1, 100),
        'language_type' => 1
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'id',
        'type_id',
        'language_type'
    );

    /**
     * Call function add_update() from model User Physical
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_User_Physical::add_update($data);
            return $this->result(\Model_User_Physical::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
