<?php

namespace Bus;

/**
 * add guest login
 *
 * @package Bus
 * @created 2015-02-02
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Users_GuestLogin extends BusAbstract
{  
    // check length
    protected $_length = array( 
        'device_id' => array(0, 255)
    );

    /**
     * call function guest_login() from model User Guest Id
     *
     * @created 2015-02-02
     * @updated 2015-02-02
     * @access public
     * @author Le Tuan Tu
     * @param $data
     * @return bool
     * @example
     */
    public function operateDB($data)
    {
        try {
            $result['id'] = \Model_User_Guest_Id::guest_login($data);
            if (!empty($result['id'])) {
                $result['token'] = \Model_Authenticate::addupdate(array(
                    'user_id' => $result['id'],
                    'regist_type' => 'guest'
                ));
                $this->_response = $result;
            }
            return $this->result(\Model_User_Guest_Id::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
