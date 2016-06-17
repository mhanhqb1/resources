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
class UserSettings_Disable extends BusAbstract
{

    protected $_required = array(
        'id',
        'disable',
    );
    
    protected $_length = array(
        'disable' => 1,
    );
    
    protected $_number_format= array(
        'disable',
    );
    
    public function operateDB($data)
    {
        try
        {
            $this->_response = \Model_User_Setting::disable($data);
            return $this->result(\Model_User_Setting::error());
        }
        catch (\Exception $e)
        {
            $this->_exception = $e;
        }
        return false;
    }

}
