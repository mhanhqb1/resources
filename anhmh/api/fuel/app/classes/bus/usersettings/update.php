<?php

namespace Bus;

/**
 * Update info for User Setting
 *
 * @package Bus
 * @created 2015-07-10
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class UserSettings_Update extends BusAbstract
{
    /** @var array $_required field require */
    protected $_required = array(
        'name',
        'value'
    );

    /**
     * Call function add_update() from model Help
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_User_Setting::set_update($data);
            return $this->result(\Model_User_Setting::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
