<?php

namespace Bus;

/**
 * Add or update info for Place_Edited_Log
 *
 * @package Bus
 * @created 2015-06-29
 * @version 1.0
 * @author Caolp
 * @copyright Oceanize INC
 */
class PlaceEditedLogs_AddUpdate extends BusAbstract {

    /** @var array $_required field require */
    protected $_required = array(
        'user_id',
        'place_id',
        'name',       
    );

    /** @var array $_length Length of fields */
    protected $_length = array(
        'id' => array(1, 11),
        'user_id' => array(1, 11),
        'language_type' => 1,       
        'name' => array(1, 100),
        'name_kana' => array(1, 200),
        'entrance_steps' => array(1, 11),
        'is_flat' => 1,
        'is_spacious' => 1,
        'is_silent' => 1,
        'is_bright' => 1,
        'is_universal_manner' => 1,
        'count_parking' => array(1, 4),
        'count_wheelchair_parking' => array(1, 4),
        'count_wheelchair_rent' => array(1, 4),
        'count_babycar_rent' => array(1, 4),
        'count_elevator' => array(1, 4),
        'count_wheelchair_wc' => array(1, 4),
        'count_ostomate_wc' => array(1, 4),
        'count_nursing_room' => array(1, 4),
        'count_smoking_room' => array(1, 4),
        'count_plug' => array(1, 4),
        'count_wifi' => array(1, 4),
        'with_assistance_dog' => 1,
        'with_assistance_dog' => 1,
        'with_creadit_card' => 1,
        'with_emoney' => 1,
        'created' => array(1, 11),
        'updated' => array(1, 11),
        'disable' => 1
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'id',
        'user_id',
        'language_type',
        'place_category_type_id',
        'google_place_id',
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
    );
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
        'with_assistance_dog' => 0,
        'with_assistance_dog' => 0,
        'with_creadit_card' => 0,
        'with_emoney' => 0,
        'disable' => 0,
        'language_type' => 1,
    );

    /** @var array $_kana_format field kana */
    protected $_kana_format = array(
        'name_kana'
    );

    /**
     * Call function add_update() from model Place_Edited_Log
     *
     * @author Caolp
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data) {
        try {
            $this->_response = \Model_Place_Edited_Log::add($data);
            return $this->result(\Model_Place_Edited_Log::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }

}
