<?php

namespace Bus;

/**
 * Add info for Follow User
 *
 * @package Bus
 * @created 2015-06-26
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class FollowUsers_Add extends BusAbstract
{
    /** @var array $_required field require */
    protected $_required = array(
        'login_user_id',
        'follow_user_id'
    );

    /** @var array $_length Length of fields */
    protected $_length = array(
        'login_user_id'  => array(1, 11),
        'follow_user_id' => array(1, 11)
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'login_user_id',
        'follow_user_id'
    );

    /**
     * Call function add() from model Follow User
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Follow_User::add($data);
            return $this->result(\Model_Follow_User::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }

}