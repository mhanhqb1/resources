<?php

namespace Bus;

/**
 * Get all Place Favorite (without array count)
 *
 * @package Bus
 * @created 2015-07-01
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class PlaceFavorites_All extends BusAbstract
{
    /** @var array $_required field require */
    protected $_required = array(
        'login_user_id',
        'limit',
        'favorite_type'
    );

    /** @var array $_length Length of fields */
    protected $_length = array(
        'login_user_id'    => array(1, 11),
        'favorite_type'    => 1,
        'category_type_id' => array(1, 11),
        'language_type'    => 1
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'limit',
        'login_user_id',
        'language_type',
        'favorite_type',
        'category_type_id'
    );

    /** @var array $_default_value field default */
    protected $_default_value = array(
        'language_type' => 1
    );

    /**
     * Call function get_all() from model Place Favorite
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Place_Favorite::get_all($data);
            return $this->result(\Model_Place_Favorite::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
