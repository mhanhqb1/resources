<?php

namespace Bus;

/**
 * update password for admin
 *
 * @package Bus
 * @created 2015-01-22
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Admins_UpdatePassword extends BusAbstract
{
    protected $_required = array(
        'id',
        'password'
    );

    protected $_length = array(
        'password' => array(6, 40),
    );

    /**
     * call function update_password() from model Admins
     *
     * @created 2015-01-22
     * @updated 2015-01-22
     * @access public
     * @author Le Tuan Tu
     * @param $data
     * @return bool
     * @example
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Admin::update_password($data);
            return $this->result(\Model_Admin::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }

}
