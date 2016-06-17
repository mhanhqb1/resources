<?php

namespace Bus;

/**
 * Get all Place Favorite (without array count)
 *
 * @package Bus
 * @created 2015-07-01
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class PlaceFavorites_Top extends BusAbstract
{
    /** @var array $_length Length of fields */
    protected $_length = array(
        'login_user_id' => array(1, 11)
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'limit',
        'login_user_id'
    );

    /**
     * Call function get_all() from model Place Favorite
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Place_Favorite::get_top($data);
            return $this->result(\Model_Place_Favorite::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
