<?php

namespace Bus;

/**
 * Change default image of Spot
 *
 * @package Bus
 * @created 2016-05-16
 * @version 1.0
 * @author KienNH
 * @copyright Oceanize INC
 */
class PlaceImages_ChangeDefault extends BusAbstract {
    
    /** @var array $_required field require */
    protected $_required = array(
        'place_id',
        'image_id'
    );
    
    /** @var array $_length Length of fields */
    protected $_length = array(
        'place_id' => array(1, 11),
        'image_id' => array(1, 11),
    );
    
    /** @var array $_number_format field number */
    protected $_number_format = array(
        'place_id',
        'image_id',
    );
    
    /**
     * Call function change_default() from model Place Image
     *
     * @author KienNH
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Place_Image::change_default($data);
            return $this->result(\Model_Place_Image::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
    
}
