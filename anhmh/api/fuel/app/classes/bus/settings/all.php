<?php

namespace Bus;

/**
 * <Settings_All - Model to operate to Settings's functions>
 *
 * @package Bus
 * @created 2014-12-12
 * @updated 2014-12-12
 * @version 1.0
 * @author <diennvt>
 * @copyright Oceanize INC
 */
class Settings_All extends BusAbstract {

    protected $_required = array(
        'type',
    );
    //check length
    protected $_length = array(
        'type' => array(0, 10),
    );
    /**
     * call function get_all()
     *
     * @created 2014-11-28
     * @updated 2014-11-28
     * @access public
     * @author Le Tuan Tu
     * @param $data
     * @return bool
     * @example
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Setting::get_all($data);
            return $this->result(\Model_Setting::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }

}
