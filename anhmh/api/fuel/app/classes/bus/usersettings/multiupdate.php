<?php

namespace Bus;

/**
 * <UserSettings_MultiUpdate - Model to operate to UserSettings's functions>
 *
 * @package Bus
 * @created 2014-12-12
 * @updated 2014-12-12
 * @version 1.0
 * @author <diennvt>
 * @copyright Oceanize INC
 */
class UserSettings_MultiUpdate extends BusAbstract
{
    protected $_required = array(
        'value'
    );
    /**
     * call function multi_update()
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
            $this->_response = \Model_User_Setting::multi_update($data);
            return $this->result(\Model_User_Setting::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }

}
