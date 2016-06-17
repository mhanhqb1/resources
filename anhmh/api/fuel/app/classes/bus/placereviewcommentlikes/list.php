<?php

namespace Bus;

/**
 * Get list Place Review Like (using array count)
 *
 * @package Bus
 * @created 2015-07-10
 * @version 1.0
 * @author Caolp
 * @copyright Oceanize INC
 */
class PlaceReviewCommentLikes_List extends BusAbstract
{
    /** @var array $_length Length of fields */
    protected $_length = array(
        'place_review_comment_id' => array(1, 11),
        'user_id'         => array(1, 11),
        'disable'         => 1
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'page',
        'limit',
        'place_review_comment_id',
        'user_id',
        'disable'
    );

    /**
     * Call function get_list() from model Place Review Like
     *
     * @author Caolp
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Place_Review_Comment_Like::get_list($data);
            return $this->result(\Model_Place_Review_Comment_Like::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
