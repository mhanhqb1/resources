<?php

namespace Bus;

/**
 * Add place by Google Place Id
 *
 * @package Bus
 * @created 2015-06-30
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Places_AddFromGoogleMap extends BusAbstract
{
    /** @var array $_required field require */
    protected $_required = array(
        'google_place_id'
    );

    /** @var array $_length Length of fields */
    protected $_length = array(
        'login_user_id' => array(1, 11),
        'language_type' => 1
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'login_user_id',
        'language_type'
    );

    /** @var array $_default_value field default */
    protected $_default_value = array(
        'language_type' => 1
    );

    /**
     * Call function add_place_by_google_place_id() from model Place Image
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Place::add_place_by_google_place_id($data);
            return $this->result(\Model_Place::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
