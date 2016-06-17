<?php

namespace Bus;

/**
 * Disable/Enable a Place Review Like
 *
 * @package Bus
 * @created 2015-07-10
 * @version 1.0
 * @author Caplp
 * @copyright Oceanize INC
 */
class PlaceReviewCommentLikes_Disable extends BusAbstract
{
    /** @var array $_length Length of fields */
    protected $_length = array(
        'id'              => array(1, 11),
        'place_review_comment_id' => array(1, 11),
        'user_id'         => array(1, 11),
        'disable'         => 1
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'place_review_comment_id',
        'user_id',
        'disable'
    );

    /**
     * Call function disable() from model Place Review Like
     *
     * @author Caplp
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Place_Review_Comment_Like::disable($data);
            return $this->result(\Model_Place_Review_Comment_Like::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
