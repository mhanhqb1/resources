<?php

namespace Bus;

/**
 * Add or update info for Place Information
 *
 * @package Bus
 * @created 2015-06-29
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class PlaceInformations_AddUpdate extends BusAbstract
{
    /** @var array $_required field require */
    protected $_required = array(
        'login_user_id',        
        'name',
        'language_type',        
    );
    
    /** @var array $_length Length of fields */
    protected $_length = array(
        'id'              => array(1, 11),
        'place_id'        => array(1, 11),
        'name'            => array(1, 100),
        'name_kana'       => array(0, 200),
        'address'         => array(0, 256),
        'tel'             => array(0, 24),
        'station_near_by' => array(0, 256),
        'business_hours'  => array(0, 256),
        'regular_holiday' => array(0, 256),
        'language_type'   => 1
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'id',
        'place_id',
        'language_type'
    );

    /** @var array $__hira_format field hiragana */
    protected $_hira_format = array(
        'name_kana'
    );

    /** @var array $_default_value default value */
    protected $_default_value = array(      
        'language_type' => 1
    );
    
    /**
     * Call function add_update() from model Place Information
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Place_Information::add_update($data);
            return $this->result(\Model_Place_Information::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
