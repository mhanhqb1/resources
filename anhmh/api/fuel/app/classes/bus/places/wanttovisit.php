<?php

namespace Bus;

/**
 * Set want to visit with place
 *
 * @package Bus
 * @created 2015-06-30
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Places_WantToVisit extends BusAbstract
{
    /** @var array $_required field require */
    protected $_required = array(       
        'login_user_id'
    );

    /** @var array $_length Length of fields */
    protected $_length = array(
        'place_id' => array(1, 11),
        'login_user_id' => array(1, 11)
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'place_id',
        'login_user_id'
    );

    /**
     * Call function want_to_visit() from model Place
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Place::want_to_visit($data);
            return $this->result(\Model_Place::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }

}