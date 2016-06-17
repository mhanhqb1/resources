<?php

namespace Bus;
use Lib\Util;

/**
 * get detail admin
 *
 * @package Bus
 * @created 2014-12-23
 * @version 1.0
 * @author <Tuancd>
 * @copyright Oceanize INC
 */
class Admins_Login extends BusAbstract
{
    // check require
    protected $_required = array(
        'login_id',
        'password'
    );

    // check length
    protected $_length = array(
        'login_id' => array(0, 40),
        'password' => array(0, 40)
    );

    /**
     * get detail admin by id or login_id
     *
     * @created 2014-12-23
     * @updated 2014-12-23
     * @access public
     * @author <Tuancd>
     * @param $data
     * @return bool
     * @example
     */
    public function operateDB($data) 
    {               
        try {            
            if (!empty($data['login_id']) && !empty($data['password'])) {
                $result = \Model_Admin::login($data);
                if (!empty($result)) {  
                    $result['token'] = \Model_Authenticate::addupdate(array(
                        'user_id' => $result['id'],
                        'regist_type' => 'admin'
                    ));
                    $this->_response = $result;
                } else {
                    \Model_Admin::errorNotExist('admin_infomation', 'information_of_admin');
                    $this->_response = false;
                }
            }
            return $this->result(\Model_Admin::error());
        } 
        catch (\Exception $e)
        {
            $this->_exception = $e;
        }
        return false;
    }

}
