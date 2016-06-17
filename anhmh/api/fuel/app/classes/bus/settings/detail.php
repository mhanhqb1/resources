<?php

namespace Bus;

/**
 * <Settings_Detail - Model to operate to Settings's functions>
 *
 * @package Bus
 * @created 2014-12-12
 * @updated 2014-12-12
 * @version 1.0
 * @author <diennvt>
 * @copyright Oceanize INC
 */
class Settings_Detail extends BusAbstract
{

    protected $_required = array(
        'id',
    );
    //check length
    protected $_length = array(
        'id' => array(1, 11),
    );
    //check number
    protected $_number_format = array(
        'id',
    );

    /**
     * get detail setting
     *
     * @created 2014-12-12
     * @updated 2014-12-12
     * @access public
     * @author <diennvt>
     * @param $data
     * @return bool
     * @example
     */
    public function operateDB($data)
    {
        try
        {
            $this->_response = \Model_Setting::get_detail($data);
            return $this->result(\Model_Setting::error());
        } catch (\Exception $e)
        {
            $this->_exception = $e;
        }
        return false;
    }

}
