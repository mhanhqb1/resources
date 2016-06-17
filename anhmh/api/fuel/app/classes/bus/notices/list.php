<?php

namespace Bus;

/**
 * Get list Notice (using array count)
 *
 * @package Bus
 * @created 2015-07-09
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Notices_List extends BusAbstract
{
    /** @var array $_length Length of fields */
    protected $_length = array(
        'language_type' => 1
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'page',
        'limit',
        'language_type'
    );

    /** @var array $_default_value default value */
    protected $_default_value = array(
        'language_type' => 1
    );

    /**
     * Call function get_list() from model Notice
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Notice::get_list($data);
            return $this->result(\Model_Notice::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
