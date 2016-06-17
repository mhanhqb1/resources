<?php

namespace Bus;

/**
 * Add or update info for Place Review Comment
 *
 * @package Bus
 * @created 2015-07-03
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class PlaceReviewComments_AddUpdate extends BusAbstract
{
    /** @var array $_required field require */
    protected $_required = array(
        'comment',       
    );
    
    /** @var array $_length Length of fields */
    protected $_length = array(
        'id' => array(1, 11),
        'place_review_id' => array(1, 11)
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'id',
        'place_review_id'
    );

    /**
     * Call function add_update() from model Place Review Comment
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Place_Review_Comment::add_update($data);
            return $this->result(\Model_Place_Review_Comment::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
