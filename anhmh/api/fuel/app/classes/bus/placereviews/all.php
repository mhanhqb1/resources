<?php

namespace Bus;

/**
 * Get all Place Review (without array count)
 *
 * @package Bus
 * @created 2015-06-29
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class PlaceReviews_All extends BusAbstract
{
    /** @var array $_length Length of fields */
    protected $_length = array(
        'user_id'       => array(1, 11),
        'place_id'      => array(1, 11),
        'language_type' => 1
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'user_id',
        'place_id',
        'language_type'
    );

    /**
     * Call function get_all() from model Place Review
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Place_Review::get_all($data);
            return $this->result(\Model_Place_Review::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
