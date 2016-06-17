<?php

namespace Bus;

/**
 * Get all Place Review Comment by Place Review Id (using array count)
 *
 * @package Bus
 * @created 2015-07-03
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class PlaceReviewComments_ListByPlaceReviewId extends BusAbstract
{
    /** @var array $_length Length of fields */
    protected $_length = array(
        'place_review_id' => array(1, 11)
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'page',
        'limit',
        'place_review_id'
    );

    /**
     * Call function get_all_comment_by_place_review_id() from model Place Review Comment
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Place_Review_Comment::get_all_comment_by_place_review_id($data);
            return $this->result(\Model_Place_Review_Comment::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
