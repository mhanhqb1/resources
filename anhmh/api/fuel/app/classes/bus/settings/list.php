<?php

namespace Bus;

/**
 * <Settings_List - Model to operate to Settings's functions>
 *
 * @package Bus
 * @created 2014-12-12
 * @updated 2014-12-12
 * @version 1.0
 * @author <diennvt>
 * @copyright Oceanize INC
 */
class Settings_List extends BusAbstract
{

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
     * call function get_list() 
     *
     * @created 2014-12-12
     * @updated 2014-12-12
     * @access public
     * @author Dien Nguyen
     * @param $data
     * @return bool
     * @example
     */
    public function operateDB($data)
    {
        try
        {
            $this->_response = \Model_Setting::get_list($data);
            return $this->result(\Model_Setting::error());
        } catch (\Exception $e)
        {
            $this->_exception = $e;
        }
        return false;
    }

}
