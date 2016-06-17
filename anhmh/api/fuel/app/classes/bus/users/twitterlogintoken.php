<?php

namespace Bus;

/**
 * <Users_TwitterToken - Login facebook for user>
 *
 * @package Bus
 * @created 2015-06-26
 * @version 1.0
 * @author <Caolp>
 * @copyright Oceanize INC
 */
class Users_TwitterLoginToken extends BusAbstract {

    protected $_required = array(
        'oauth_token',
        'oauth_token_secret',
    );

    public function operateDB($data) {
        try {
            \Package::load('twitter');
            $result = \Model_User::login_twitter_by_token($data);
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
