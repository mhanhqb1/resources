<?php

namespace Bus;

/**
 * Get all Place Sub Category (without array count)
 *
 * @package Bus
 * @created 2015-07-01
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class PlaceSubCategories_All extends BusAbstract
{
    /** @var array $_length Length of fields */
    protected $_length = array(
        'type_id'          => array(1, 11),
        'category_type_id' => array(1, 11),
        'language_type'    => 1
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'type_id',
        'language_type',
        'category_type_id'
    );

    /**
     * Call function get_all() from model Place Sub Category
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Place_Sub_Category::get_all($data);
            return $this->result(\Model_Place_Sub_Category::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
