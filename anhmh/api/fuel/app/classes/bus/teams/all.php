<?php

namespace Bus;

/**
 * Get all Team (without array count)
 *
 * @package Bus
 * @created 2015-07-01
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Teams_All extends BusAbstract
{
    /** @var array $_length Length of fields */
    protected $_length = array(
        'type_id'          => array(1, 11),
        'section_id' => array(1, 11),
        'language_type'    => 1
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'type_id',
        'language_type',
        'section_id'
    );

    /**
     * Call function get_all() from model Team
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Team::get_all($data);
            return $this->result(\Model_Team::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
