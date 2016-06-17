<?php

namespace Bus;

/**
 * <Users_FbLoginToken - Login facebook for user>
 *
 * @package Bus
 * @created 2014-12-25
 * @version 1.0
 * @author <diennvt>
 * @copyright Oceanize INC
 */
class Users_FbLoginToken extends BusAbstract {

    protected $_required = array(
        'token',
    );

    public function operateDB($data) {
        try {
            \Package::load('facebook');       
            $result = \Model_User::login_facebook_by_token($data);
            if (!empty($result['id'])) {  
                $result['token'] = \Model_Authenticate::addupdate(array(
                    'user_id' => $result['id'],
                    'regist_type' => 'user'
                ));
            }
            $this->_response = $result;
            return $this->result(\Model_User::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }

}
