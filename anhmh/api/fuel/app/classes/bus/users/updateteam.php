<?php

namespace Bus;

/**
 * Update info for User
 *
 * @package Bus
 * @created 2015-04-23
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Users_UpdateTeam extends BusAbstract
{
    /** @var array $_required field require */
    protected $_required = array(
        'login_user_id',
    );

    /** @var array $_length Length of fields */
    protected $_length = array(
        'login_user_id' => array(1, 11),
        'team_id' => array(1, 11),
        'section_id' => array(1, 11),
        'name' => array(1, 255),
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'login_user_id',
        'section_id',
        'team_id',        
    );

    /**
     * Call function update_profile() from model User
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_User::update_team($data);
            return $this->result(\Model_User::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
