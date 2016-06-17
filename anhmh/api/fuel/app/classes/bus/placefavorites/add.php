<?php

namespace Bus;

/**
 * Add info for Place Favorite
 *
 * @package Bus
 * @created 2015-06-26
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class PlaceFavorites_Add extends BusAbstract
{
    /** @var array $_required field require */
    protected $_required = array(        
        'login_user_id'
    );

    /** @var array $_length Length of fields */
    protected $_length = array(
        'place_id' => array(1, 11),
        'login_user_id' => array(1, 11),
        'favorite_type' => 1
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'place_id',
        'login_user_id',
        'favorite_type'
    );
    
    /** @var array $_default_value field default */
    protected $_default_value = array(
        'language_type' => 1,
        'favorite_type' => 1
    );

    /**
     * Call function add() from model Place Favorite
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Place_Favorite::add($data);
            return $this->result(\Model_Place_Favorite::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }

}