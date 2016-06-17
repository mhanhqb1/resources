<?php

namespace Bus;

/**
 * <AdminSettings_All - Model to operate to UserSettings's functions>
 *
 * @package Bus
 * @created 2014-12-22
 * @updated 2014-12-22
 * @version 1.0
 * @author <tuancd>
 * @copyright Oceanize INC
 */
class AdminSettings_All extends BusAbstract
{
    // check require
    protected $_required = array(
        'admin_id',
    );

    // check number
    protected $_number_format = array(
        'page',
        'limit',
        'admin_id'
    );

    // check length
    protected $_length = array(
        'admin_id' => array(1, 40),
        'name' => array(0, 100),
        'data_type' => array(0, 10),
        'disable' => 1
    );

    /**
     * call function get_all()
     *
     * @created 2014-12-22
     * @updated 2014-12-22
     * @access public
     * @author <tuancd>
     * @param $data
     * @return bool
     * @example
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Admin_Setting::get_all($data);
            return $this->result(\Model_Admin_Setting::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }

}
