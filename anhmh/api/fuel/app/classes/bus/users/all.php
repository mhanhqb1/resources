<?php

namespace Bus;

/**
 * Get list User (without array count)
 *
 * @package Bus
 * @created 2015-04-01
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Users_All extends BusAbstract
{
    /**
     * Call function get_all() from model User
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_User::get_all($data);
            return $this->result(\Model_User::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
