<?php

namespace Bus;

/**
 * Add or update info for Place Sub Category
 *
 * @package Bus
 * @created 2015-07-01
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class PlaceSubCategories_AddUpdate extends BusAbstract
{
    /** @var array $_length Length of fields */
    protected $_length = array(
        'id'               => array(1, 11),
        'type_id'          => array(1, 11),
        'google_name'      => array(1, 256),
        'name'             => array(1, 256),
        'language_type'    => 1,
        'category_type_id' => array(1, 11)
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'id',
        'type_id',
        'language_type',
        'category_type_id'
    );

    /**
     * Call function add_update() from model Place Sub Category
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Place_Sub_Category::add_update($data);
            return $this->result(\Model_Place_Sub_Category::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}