<?php

namespace Bus;

/**
 * add or update info for admin
 *
 * @package Bus
 * @created 2014-11-20
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Admins_AddUpdate extends BusAbstract
{
    // check number
    protected $_number_format = array(
        'id'
    );

    // check length
    protected $_length = array(
        'id' => array(1, 11),
        'name' => array(0, 40),
        'login_id' => array(0, 40),
        'password' => array(0, 40)
    );

    /**
     * call function add_update() from model Admin
     *
     * @created 2014-11-20
     * @updated 2014-11-20
     * @access public
     * @author Le Tuan Tu
     * @param $data
     * @return bool
     * @example
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Admin::add_update($data);
            return $this->result(\Model_Admin::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }

}
