<?php

namespace Bus;

/**
 * Add or update info for Place Category
 *
 * @package Bus
 * @created 2015-06-29
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class PlaceCategories_AddUpdate extends BusAbstract
{
    /** @var array $_length Length of fields */
    protected $_length = array(
        'id'            => array(1, 11),
        'type_id'       => array(1, 11),
        'name'          => array(1, 100),
        'language_type' => 1,
        'pin_icon'      => array(0, 256),
        'menu_icon'     => array(0, 256),
        'tab_icon'      => array(0, 256),
        'small_icon'    => array(0, 256)
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'id',
        'type_id',
        'language_type'
    );

    /**
     * Call function add_update() from model Place Category
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Place_Category::add_update($data);
            return $this->result(\Model_Place_Category::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
