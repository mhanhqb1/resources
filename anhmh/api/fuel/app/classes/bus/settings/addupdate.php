<?php

namespace Bus;

/**
 * <Settings_AddUpdate - Model to operate to Settings's functions>
 *
 * @package Bus
 * @created 2014-12-12
 * @updated 2014-12-12
 * @version 1.0
 * @author <diennvt>
 * @copyright Oceanize INC
 */
class Settings_AddUpdate extends BusAbstract
{
    protected $_required = array(
        'name',
        'type'
    );
    //check length
    protected $_length = array(
        'id' => array(1, 11),
        'name' => array(0, 100),
        'type' => array(0, 10),
    );
    
    //check number
    protected $_number_format = array(
        'id',
    );
    /**
     * call function add_update() from model News Site
     *
     * @created 2014-12-12
     * @updated 2014-12-12
     * @access public
     * @author <diennvt>
     * @param $data
     * @return bool
     * @example
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Setting::add_update($data);
            return $this->result(\Model_Setting::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }

}
