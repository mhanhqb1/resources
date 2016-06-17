<?php

namespace Bus;

/**
 * Disable/Enable a Follow User
 *
 * @package Bus
 * @created 2015-06-26
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class FollowUsers_Disable extends BusAbstract
{
    /** @var array $_length Length of fields */
    protected $_length = array(
        'id'             => array(1, 11),
        'follow_user_id' => array(1, 11),
        'login_user_id'  => array(1, 11),
        'disable'        => 1
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'follow_user_id',
        'login_user_id',
        'disable'
    );

    /**
     * Call function disable() from model Follow User
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Follow_User::disable($data);
            return $this->result(\Model_Follow_User::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
