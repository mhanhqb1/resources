<?php

namespace Bus;

/**
 * <Settings_Disable - Model to operate to Settings's functions>
 *
 * @package Bus
 * @created 2014-12-12
 * @updated 2014-12-12
 * @version 1.0
 * @author <diennvt>
 * @copyright Oceanize INC
 */
class Settings_Disable extends BusAbstract
{

    protected $_required = array(
        'id',
        'disable',
    );
    //check length
    protected $_length = array(
        'disable' => 1,
    );
    //check number
    protected $_number_format = array(
        'disable'
    );

    public function operateDB($data)
    {
        try
        {
            $this->_response = \Model_Setting::disable($data);
            return $this->result(\Model_Setting::error());
        } catch (\Exception $e)
        {
            $this->_exception = $e;
        }
        return false;
    }

}
