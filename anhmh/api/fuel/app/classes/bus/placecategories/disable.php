<?php

namespace Bus;

/**
 * Disable/Enable Place Category
 *
 * @package Bus
 * @created 2015-06-29
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class PlaceCategories_Disable extends BusAbstract
{
    /** @var array $_required field require */
    protected $_required = array(
        'id',
        'disable'
    );

    /** @var array $_length Length of fields */
    protected $_length = array(
        'disable' => 1
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'disable'
    );

    /**
     * Call function disable() from model Place Category
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Place_Category::disable($data);
            return $this->result(\Model_Place_Category::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
