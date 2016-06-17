<?php

namespace Bus;

/**
 * Get History of Place Review
 *
 * @package Bus
 * @created 2016-03-24
 * @version 1.0
 * @author KienNH
 * @copyright Oceanize INC
 */
class PlaceReviews_History extends BusAbstract {
    
    /** @var array $_required field require */
    protected $_required = array(
        //'user_id',
        //'place_id'
    );

    /** @var array $_length Length of fields */
    protected $_length = array(
        'user_id' => array(1, 11),
        'place_id' => array(1, 11)
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'user_id',
        'place_id'
    );

    /**
     * Call function get_history() from model Place Review
     *
     * @author KienNH
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data) {
        try {
            $this->_response = \Model_Place_Review::get_history($data);
            return $this->result(\Model_Place_Review::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
