<?php

namespace Bus;

/**
 * Add info for Place Review Like
 *
 * @package Bus
 * @created 2015-07-10
 * @version 1.0
 * @author Caolp
 * @copyright Oceanize INC
 */
class PlaceReviewCommentLikes_Add extends BusAbstract
{
    /** @var array $_required field require */
    protected $_required = array(
        'place_review_comment_id',
        'login_user_id'
    );

    /** @var array $_length Length of fields */
    protected $_length = array(
        'place_review_comment_id' => array(1, 11),
        'login_user_id'   => array(1, 11)
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'place_review_comment_id',
        'login_user_id'
    );

    /**
     * Call function add() from model Place Review Like
     *
     * @author Caolp
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Place_Review_Comment_Like::add($data);
            return $this->result(\Model_Place_Review_Comment_Like::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }

}