<?php

namespace Bus;

/**
 * Get detail Place Sub Category by Google name
 *
 * @package Bus
 * @created 2015-07-01
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class PlaceSubCategories_DetailByGoogleName extends BusAbstract
{
    /** @var array $_required field require */
    protected $_required = array(
        'google_name'
    );

    /** @var array $_length Length of fields */
    protected $_length = array(        
        'language_type' => 1
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'language_type'
    );

    /** @var array $_default_value field default */
    protected $_default_value = array(
        'language_type' => '1'
    );

    /**
     * Call function get_detail() from model Place Sub Category
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Place_Sub_Category::get_detail_by_google_name($data);
            return $this->result(\Model_Place_Sub_Category::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
