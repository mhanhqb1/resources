<?php

namespace Bus;

/**
 * Add info for Place Pin
 *
 * @package Bus
 * @created 2015-06-30
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class PlacePins_Add extends BusAbstract
{
    /** @var array $_required field require */
    protected $_required = array(
        'login_user_id',       
        'location',           
        'name',         
        'language_type',        
    );

    /** @var array $_length Length of fields */
    protected $_length = array(       
        'language_type' => 1,
        'place_category_type_id' => array(1, 11),
        'login_user_id' => array(1, 11),
        'name' => array(1, 100),
        'address' => array(1, 200),
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(      
        'place_category_type_id',
        'login_user_id',
    );

    /** @var array $_default_value default value */
    protected $_default_value = array(      
        'language_type' => 1
    );
    
    /**
     * Call function add() from model Place Pin
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Place_Pin::add($data);
            return $this->result(\Model_Place_Pin::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }

}