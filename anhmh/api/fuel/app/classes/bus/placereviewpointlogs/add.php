<?php

namespace Bus;

/**
 * Add info for Place View Point Log
 *
 * @package Bus
 * @created 2015-06-29
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class PlaceReviewPointLogs_Add extends BusAbstract
{
    /** @var array $_required field require */
    protected $_required = array(       
        'login_user_id',        
        'review_point'
    );

    /** @var array $_length Length of fields */
    protected $_length = array(
        'place_id'      => array(1, 11),
        'login_user_id' => array(1, 11),
        'review_point'  => 1
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'place_id',
        'login_user_id',
        'review_point'
    );

    /** @var array $_default_value default value */
    protected $_default_value = array(      
        'language_type' => 1
    );
    
    /**
     * Call function add() from model Place View Point Log
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Place_Review_Point_Log::add($data);
            return $this->result(\Model_Place_Review_Point_Log::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }

}