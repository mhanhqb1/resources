<?php

namespace Bus;

/**
 * Update info for Place Review
 *
 * @package Bus
 * @created 2015-06-29
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class PlaceReviewComments_Update extends BusAbstract
{
    /** @var array $_length Length of fields */
    protected $_length = array(
        'id'            => array(1, 11),       
    );
    
    /** @var array $_default_value default value */
    protected $_default_value = array(      
        'language_type' => 1
    );

    /**
     * Call function add_update() from model Place Review
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Place_Review_Comment::update_comment($data);
            return $this->result(\Model_Place_Review::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
