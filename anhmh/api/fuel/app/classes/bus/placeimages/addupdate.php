<?php

namespace Bus;

/**
 * Add or update info for Place Image
 *
 * @package Bus
 * @created 2015-06-29
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class PlaceImages_AddUpdate extends BusAbstract
{
    /** @var array $_length Length of fields */
    protected $_length = array(
        'id' => array(1, 11),
        'user_id' => array(1, 11),
        'place_id' => array(1, 11),
        'place_review_id' => array(1, 11),
        'image_path' => array(1, 255),
        'thm_image_path' => array(0, 255),
        'is_default' => 1,
        'is_review_default' => 1,
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'id',
        'user_id',
        'place_id',
        'place_review_id',
        'is_default',
        'is_review_default',
    );

    /**
     * Call function add_update() from model Place Image
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Place_Image::add_update($data);
            return $this->result(\Model_Place_Image::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
