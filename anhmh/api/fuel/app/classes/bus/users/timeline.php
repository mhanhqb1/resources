<?php

namespace Bus;

/**
 * Get time line of User (with array count)
 *
 * @package Bus
 * @created 2015-07-02
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Users_Timeline extends BusAbstract
{
    /** @var array $_length Length of fields */
    protected $_length = array(
        'language_type' => 1
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'language_type'
    );

    /** @var array $_default_value field default */
    protected $_default_value = array(
        'language_type' => '1',       
    );

    /**
     * Call function get_list() from model User
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Place::get_for_timeline($data);          
            return $this->result(\Model_User::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
