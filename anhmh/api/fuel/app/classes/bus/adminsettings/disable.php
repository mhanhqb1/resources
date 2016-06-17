<?php

namespace Bus;

/**
 * <UserSettings_Disable - Model to operate to UserSettings's functions>
 *
 * @package Bus
 * @created 2014-12-12
 * @updated 2014-12-12
 * @version 1.0
 * @author <diennvt>
 * @copyright Oceanize INC
 */
class AdminSettings_Disable extends BusAbstract
{
    // check require
    protected $_required = array(
        'id',
        'disable',
    );

    // check number
    protected $_number_format = array(
        'disable'
    );

    // check length
    protected $_length = array(
        'disable' => 1
    );

    public function operateDB($data)
    {
        try
        {
            $this->_response = \Model_Admin_Setting::disable($data);
            return $this->result(\Model_Admin_Setting::error());
        }
        catch (\Exception $e)
        {
            $this->_exception = $e;
        }
        return false;
    }

}
