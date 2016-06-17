<?php

namespace Bus;

/**
 * Search Place
 *
 * @package Bus
 * @created 2015-06-29
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Places_Search extends BusAbstract
{
    /** @var array $_required field require */
    protected $_required = array(
        'location'
    );

    /** @var array $_default_value field default */
    protected $_default_value = array(
        'language_type' => '1'
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
    
    /**
     * Call function get_detail() from model Place
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Place::get_search($data);
            return $this->result(\Model_Place::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
