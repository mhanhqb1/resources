<?php

namespace Bus;

/**
 * Get all Place Category (without array count)
 *
 * @package Bus
 * @created 2015-06-29
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class PlaceCategories_All extends BusAbstract
{
    /** @var array $_length Length of fields */
    protected $_length = array(
        'type_id' => array(1, 11),
        'language_type' => 1
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'type_id',
        'language_type'
    );

    /** @var array $_default_value default value */
    protected $_default_value = array(      
        'language_type' => 1
    );
    
    /**
     * Call function get_all() from model Place Category
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Place_Category::get_all($data);
            return $this->result(\Model_Place_Category::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
