<?php

namespace Bus;

/**
 * <UserSettings_AddUpdate - Model to operate to UserSettings's functions>
 *
 * @package Bus
 * @created 2014-12-12
 * @updated 2014-12-12
 * @version 1.0
 * @author <diennvt>
 * @copyright Oceanize INC
 */
class UserSettings_AddUpdate extends BusAbstract
{
    protected $_required = array(
        'user_id',
        'value'
    );
    
    protected $_length = array(
        'user_id' => array(1, 11),
        'setting_id' => array(1, 11),
    );
    
    protected $_number_format= array(
        'user_id',
        'setting_id',
    );

    /**
     * call function add_update()
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
            $this->_response = \Model_User_Setting::add_update($data);
            return $this->result(\Model_User_Setting::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }

}
