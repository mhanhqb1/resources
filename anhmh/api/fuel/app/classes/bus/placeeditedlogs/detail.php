<?php

namespace Bus;

/**
 * Get detail Place_Edited_Log
 *
 * @package Bus
 * @created 2015-06-29
 * @version 1.0
 * @author Caolp
 * @copyright Oceanize INC
 */
class PlaceEditedLogs_Detail extends BusAbstract
{
    /** @var array $_required field require */
    protected $_required = array(
        'id',
        'place_id',
    );

    /** @var array $_length Length of fields */
    protected $_length = array(
        'id' => array(1, 11)
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'id'
    );

    /**
     * Call function get_detail() from model Place_Edited_Log
     *
     * @author Caolp
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Place_Edited_Log::get_detail($data);
            return $this->result(\Model_Place_Edited_Log::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
