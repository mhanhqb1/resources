<?php

namespace Bus;

/**
 * Disable/Enable a Place Pin
 *
 * @package Bus
 * @created 2015-06-30
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class PlacePins_Disable extends BusAbstract
{
    /** @var array $_length Length of fields */
    protected $_length = array(
        'id'       => array(1, 11),
        'place_id' => array(1, 11),
        'user_id'  => array(1, 11),
        'disable'  => 1
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'place_id',
        'user_id',
        'disable'
    );

    /**
     * Call function disable() from model Place Pin
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Place_Pin::disable($data);
            return $this->result(\Model_Place_Pin::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
