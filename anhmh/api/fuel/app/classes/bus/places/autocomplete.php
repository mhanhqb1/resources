<?php

namespace Bus;

/**
 * Search Place
 *
 * @package Bus
 * @version 1.0
 * @author Quan
 * @copyright Oceanize INC
 */
class Places_Autocomplete extends BusAbstract
{
    /** @var array $_required field require */
    protected $_required = array(
        'input',
        'location'
    );

    /** @var array $_default_value field default */
    protected $_default_value = array(
        'language_type' => '1'
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'radius'
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
            $this->_response = \Model_Place::autocomplete($data);
            return $this->result(\Model_Place::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
