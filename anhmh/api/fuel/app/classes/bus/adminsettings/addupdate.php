<?php

namespace Bus;

/**
 * <UserSettings_AddUpdate - Model to operate to UserSettings's functions>
 *
 * @package Bus
 * @created 2014-12-22
 * @updated 2014-12-22
 * @version 1.0
 * @author <tuancd>
 * @copyright Oceanize INC
 */
class AdminSettings_AddUpdate extends BusAbstract
{
    // check require
    protected $_required = array(       
        'value'
    );

    // check number
    protected $_number_format = array(
        'admin_id'
    );

    // check length
    protected $_length = array(
        'admin_id' => array(1, 11),
    );

    /**
     * call function add_update()
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
            $this->_response = \Model_Admin_Setting::add_update($data);
            return $this->result(\Model_Admin_Setting::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }

}
