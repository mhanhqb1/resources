<?php

namespace Bus;

/**
 * <Settings_MultiUpdate - Model to operate to Settings's functions>
 *
 * @package Bus
 * @created 2014-12-15
 * @updated 2014-12-15
 * @version 1.0
 * @author <diennvt>
 * @copyright Oceanize INC
 */
class Settings_MultiUpdate extends BusAbstract
{
    protected $_required = array(
        'value',
    );
    /**
     * call function multi_update() from model News Site
     *
     * @created 2014-12-15
     * @updated 2014-12-15
     * @access public
     * @author <diennvt>
     * @param $data
     * @return bool
     * @example
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Setting::multi_update($data);
            return $this->result(\Model_Setting::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }

}
