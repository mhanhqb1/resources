<?php

namespace Bus;

/**
 * Get list Follow User (using array count)
 *
 * @package Bus
 * @created 2015-06-26
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class FollowUsers_List extends BusAbstract
{
    /** @var array $_length Length of fields */
    protected $_length = array(
        'follow_user_id' => array(1, 11),
        'login_user_id'  => array(1, 11),
        'disable'        => 1
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'page',
        'limit',
        'follow_user_id',
        'login_user_id',
        'disable'
    );

    /**
     * Call function get_list() from model Follow User
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            if (empty($param['user_id']) && !empty($param['login_user_id'])) {
                $param['user_id'] = $param['login_user_id'];
            }
            $this->_response = \Model_Follow_User::get_list($data);
            return $this->result(\Model_Follow_User::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
    
}
