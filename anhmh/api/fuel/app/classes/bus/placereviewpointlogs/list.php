<?php

namespace Bus;

/**
 * Get list Place Review Point Log (using array count)
 *
 * @package Bus
 * @created 2015-06-29
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class PlaceReviewPointLogs_List extends BusAbstract
{
    /** @var array $_length Length of fields */
    protected $_length = array(
        'place_id' => array(1, 11),
        'user_id'  => array(1, 11),
        'disable'  => 1
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'page',
        'limit',
        'place_id',
        'user_id',
        'disable'
    );

    /**
     * Call function get_list() from model Place Review Point Log
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Place_Review_Point_Log::get_list($data);
            return $this->result(\Model_Place_Review_Point_Log::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}