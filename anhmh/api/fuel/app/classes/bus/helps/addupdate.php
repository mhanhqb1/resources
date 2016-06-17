<?php

namespace Bus;

/**
 * Add or update info for Help
 *
 * @package Bus
 * @created 2015-07-08
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Helps_AddUpdate extends BusAbstract
{
    /** @var array $_length Length of fields */
    protected $_length = array(
        'id'            => array(1, 11),
        'language_type' => 1,
        'title'         => array(1, 255),
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'id',
        'type_id',
        'language_type'
    );

    /**
     * Call function add_update() from model Help
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Help::add_update($data);
            return $this->result(\Model_Help::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
