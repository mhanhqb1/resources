<?php

namespace Bus;

/**
 * <Users_FbLogin - Login facebook for user>
 *
 * @package Bus
 * @created 2014-12-25
 * @version 1.0
 * @author <diennvt>
 * @copyright Oceanize INC
 */
class Users_FbLogin extends BusAbstract {

    protected $_required = array(
        'email', // email which is registered facebook
        'id'//id of facebook
    );
    
    protected $_email_format = array(
        'email',
    );

    public function operateDB($data) {
        try {
            \Package::load('facebook');
            if (!empty($data['email'])) {
                $result = \Model_User::login_facebook($data);               
                if (!empty($result)) {  
                    $result['token'] = \Model_Authenticate::addupdate(array(
                        'user_id' => $result['id'],
                        'regist_type' => 'user'
                    ));
                    $this->_response = $result;
                }
                else {
                    $this->_response = false;
                }
            }
            //$this->_response = \Model_User::login_facebook($data);
            return $this->result(\Model_User::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }

}
