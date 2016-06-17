<?php

namespace Bus;

/**
 * Add or update info for Place Review
 *
 * @package Bus
 * @created 2015-06-29
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class PlaceReviews_AddUpdate extends BusAbstract
{
    /** @var array $_length Length of fields */
    protected $_length = array(
        'id'            => array(1, 11),
        'place_id'      => array(1, 11),
        'name'          => array(1, 100),
        'name_kana'     => array(0, 200),
        'language_type' => 1
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'id',
        'user_id',
        'place_id',
        'language_type'
    );

    /** @var array $_kana_format field kana */
    protected $_kana_format = array(
        'name_kana'
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
            $this->_response = \Model_Place_Review::add_update($data);
            return $this->result(\Model_Place_Review::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
