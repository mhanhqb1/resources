<?php

namespace Bus;

/**
 * Get list Follow Place (using array count)
 *
 * @package Bus
 * @created 2015-06-26
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class FollowPlaces_List extends BusAbstract
{
    /** @var array $_length Length of fields */
    protected $_length = array(
        'follow_place_id' => array(1, 11),
        'user_id'         => array(1, 11),
        'disable'         => 1
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'page',
        'limit',
        'follow_place_id',
        'user_id',
        'disable'
    );

    /**
     * Call function get_list() from model Follow Place
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Follow_Place::get_list($data);
            return $this->result(\Model_Follow_Place::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
