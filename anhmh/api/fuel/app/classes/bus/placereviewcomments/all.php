<?php

namespace Bus;

/**
 * Get all Place Review Comment (without array count)
 *
 * @package Bus
 * @created 2015-07-03
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class PlaceReviewComments_All extends BusAbstract
{
    /** @var array $_length Length of fields */
    protected $_length = array(
        'user_id'         => array(1, 11),
        'place_review_id' => array(1, 11)
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'user_id',
        'place_review_id'
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
            $this->_response = \Model_Place_Review_Comment::get_all($data);
            return $this->result(\Model_Place_Review_Comment::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
