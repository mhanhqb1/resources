<?php

namespace Bus;

/**
 * Get list Place Image (using array count)
 *
 * @package Bus
 * @created 2015-06-29
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class PlaceImages_List extends BusAbstract
{
    /** @var array $_required field require */
    protected $_required = array(
        //'place_id',        
    );
    
    /** @var array $_length Length of fields */
    protected $_length = array(
        'user_id'         => array(1, 11),
        'place_id'        => array(1, 11),
        'place_review_id' => array(1, 11),
        'image_path'      => array(0, 255),
        'thm_image_path'  => array(0, 255),
        'disable'         => 1
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'page',
        'limit',
        'disable',
        'place_id',
        'place_review_id',
        'user_id'
    );

    /**
     * Call function get_list() from model Place Image
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Place_Image::get_list($data);
            return $this->result(\Model_Place_Image::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
