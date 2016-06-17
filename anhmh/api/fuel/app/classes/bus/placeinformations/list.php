<?php

namespace Bus;

/**
 * Get list Place Information (using array count)
 *
 * @package Bus
 * @created 2015-06-29
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class PlaceInformations_List extends BusAbstract
{
    /** @var array $_length Length of fields */
    protected $_length = array(
        'place_id'      => array(1, 11),
        'name'          => array(1, 100),
        'name_kana'     => array(0, 200),
        'address'       => array(0, 256),
        'tel'           => array(0, 24),
        'language_type' => 1,
        'disable'       => 1
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'page',
        'limit',
        'disable',
        'place_id'
    );

    /**
     * Call function get_list() from model Place Information
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Place_Information::get_list($data);
            return $this->result(\Model_Place_Information::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
