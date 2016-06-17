<?php

namespace Bus;

/**
 * Get list Help (using array count)
 *
 * @package Bus
 * @created 2015-07-08
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Helps_List extends BusAbstract
{
    /** @var array $_length Length of fields */
    protected $_length = array(
        'id'            => array(1, 11),
        'type_id'       => array(1, 11),
        'language_type' => 1,
        'disable'       => 1
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'page',
        'limit',
        'disable',
        'id',
        'type_id',
        'language_type'
    );

    /**
     * Call function get_list() from model Help
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Help::get_list($data);
            return $this->result(\Model_Help::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
