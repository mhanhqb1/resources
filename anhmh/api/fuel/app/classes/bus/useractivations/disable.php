<?php

namespace Bus;

/**
 * <Users_Disable - API to disable or enable a Users>
 *
 * @package Bus
 * @created 2014-11-20
 * @version 1.0
 * @author <diennvt>
 * @copyright Oceanize INC
 */
class UserActivations_Disable extends BusAbstract
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
            $this->_response = \Model_User_Activation::disable($data);
            return $this->result(\Model_User_Activation::error());
        } catch (\Exception $e)
        {
            $this->_exception = $e;
        }
        return false;
    }

}
