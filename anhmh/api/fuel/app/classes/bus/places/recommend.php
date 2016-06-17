<?php

namespace Bus;

/**
 * Get Place's recommend  (using array count)
 *
 * @package Bus
 * @created 2015-07-08
 * @version 1.0
 * @author diennvt
 * @copyright Oceanize INC
 */
class Places_Recommend extends BusAbstract
{
    /** @var array $_required  of fields */
    protected $_required = array(              
       
    );

    /** @var array $_length Length of fields */
    protected $_length = array(
        'login_user_id' => array(1, 11),
        'language_type' => 1,
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'limit',
        'login_user_id'
    );
    
    /** @var array $_default_value field default */
    protected $_default_value = array(
        'language_type' => '1',        
    );

    /**
     * Call function get_recommend() from model Place 
     *
     * @author diennvt
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Place::get_recommend($data);
            return $this->result(\Model_Place::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
