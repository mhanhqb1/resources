<?php

namespace Bus;

/**
 * Get all Help (without array count)
 *
 * @package Bus
 * @created 2015-07-08
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Adminnotices_All extends BusAbstract
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
     * Call function get_all() from model Help
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Admin_Notice::get_all($data);
            return $this->result(\Model_Admin_Notice::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
