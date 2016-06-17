<?php

namespace Bus;

/**
 * Disable/Enable list Prefectures
 *
 * @package Bus
 * @created 2015-03-25
 * @version 1.0
 * @author Tran Xuan Khoa
 * @copyright Oceanize INC
 */
class Prefectures_Disable extends BusAbstract
{
    /** @var array $_required field require */
    protected $_required = array(
        'id'
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
     * Validate list of id format: d,d,d,d
     *
     * @author Tran Xuan Khoa
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function checkDataFormat($data) 
    {
        //Validate id's format
        $field = 'id';
        if (!empty($data[$field]) 
            && !preg_match ('/^\d(?:,\d)*$/', $data[$field])) {//id's format: digital,digital,digital
                $this->_addError(self::ERROR_CODE_INVALED_PARAMETER, $field, $data[$field]);
                $this->_invalid_parameter = $field;
                return false;
        }
        
        return true;
    }

    /**
     * Call function disable() from model Prefecture
     *
     * @author Tran Xuan Khoa
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Prefecture::disable($data);
            return $this->result(\Model_Prefecture::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
