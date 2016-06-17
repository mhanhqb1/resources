<?php

namespace Bus;

/**
 * Update info for Place 
 *
 * @package Bus
 * @created 2015-06-29
 * @version 1.0
 * @author Caolp
 * @copyright Oceanize INC
 */
class Places_Update extends BusAbstract
{
    /** @var array $_required field require */
    protected $_required = array(
    );
    
    /** @var array $_length Length of fields */
    protected $_length = array(
        'id' => array(1, 11),
        'place_category_type_id' => array(1, 11),
        'place_sub_category_type_id' => array(1, 11),
        'google_place_id' => array(1, 256),
        'google_category_name' => array(1, 256),
        'name' => array(1, 100),
        'name_kana' => array(1, 200),
        'entrance_steps' => array(1, 11),        
        'created' => array(1, 11),
        'updated' => array(1, 11),
        'disable' => 1
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'id',
        'place_category_type_id',
        'place_sub_category_type_id',
        'review_point',
        'entrance_steps',
        'count_parking',
        'count_wheelchair_parking',
        'count_wheelchair_rent',
        'count_babycar_rent',
        'count_elevator',
        'count_wheelchair_wc',
        'count_ostomate_wc',
        'count_nursing_room',
        'count_smoking_room',
        'count_plug',
        'count_wifi',
        'count_follow',
        'count_favorite',
    );
    
    /** @var array $_number_format default_value */   
    protected $_default_value = array(      
        'entrance_steps' => 0,
        'is_flat' => 0,
        'is_spacious' => 0,
        'is_silent' => 0,
        'is_bright' => 0,
        'is_universal_manner' => 0,
        'count_parking' => 0,
        'count_wheelchair_parking' => 0,
        'count_wheelchair_rent' => 0,
        'count_babycar_rent' => 0,
        'count_elevator' => 0,
        'count_wheelchair_wc' => 0,
        'count_ostomate_wc' => 0,
        'count_nursing_room' => 0,
        'count_smoking_room' => 0,
        'count_plug' => 0,
        'count_wifi' => 0,
        'count_follow' => 0,
        'count_favorite' => 0,
        'with_assistance_dog' => 0,
        'with_assistance_dog' => 0,
        'with_credit_card' => 0,
        'with_emoney' => 0,       
    );    
    
    /** @var array $_japanese_format field kana */
    protected $_japanese_format = array(
        'name_kana'
    );
    
    /** @var array $_url_format field url */
    protected $_url_format = array(
        'source_url'
    );

    /**
     * Call function add_update() from model Place 
     *
     * @author Caolp
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Place::updatePlace($data);
            return $this->result(\Model_Place::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
