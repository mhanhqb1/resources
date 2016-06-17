<?php

use Lib\Util;
/**
 * Model_User_Activation - Model to operate to User_Activation's functions.
 * 
 * @package Model
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Model_User_Activation extends Model_Abstract {

    protected static $_properties = array(
        'id',
        'user_id',
        'email',
        'password',
        'token',
        'expire_date',
        'sex_id',
        'regist_type',
        'os',
        'disable',
        'created',
        'updated',
    );
    protected static $_observers = array(
        'Orm\Observer_CreatedAt' => array(
            'events' => array('before_insert'),
            'mysql_timestamp' => false,
        ),
        'Orm\Observer_UpdatedAt' => array(
            'events' => array('before_update'),
            'mysql_timestamp' => false,
        ),
    );
    protected static $_table_name = 'user_activations';

    /**
     * Get list user profile.
     *
     * @author Le Tuan Tu
     * @param array $param Input data.
     * @return array Returns array(total, data).
     */
    public static function get_list($param) {
        $query = DB::select()->from(self::$_table_name);
        if (!empty($param['id'])) {
            $query->where('id', '=', $param['id']);
        }
        if (!empty($param['email'])) {
            $query->where('email', 'LIKE', "%{$param['email']}%");
        }
        if (!empty($param['page']) && !empty($param['limit'])) {
            $offset = ($param['page'] - 1) * $param['limit'];
            $query->limit($param['limit'])->offset($offset);
        }
        if (!empty($param['sort'])) {
            // KienNH 2016/04/20 check valid sort
            if (!self::checkSort($param['sort'])) {
                self::errorParamInvalid('sort');
                return false;
            }
            
            $sortExplode = explode('-', $param['sort']);
            if ($sortExplode[0] == 'created') {
                $sortExplode[0] = self::$_table_name . '.created';
            }
            $query->order_by($sortExplode[0], $sortExplode[1]);
        } else {
            $query->order_by(self::$_table_name . '.created', 'DESC');
        }
        $data = $query->execute(self::$slave_db)->as_array();
        $total = !empty($data) ? DB::count_last_query(self::$slave_db) : 0;
        return array($total, $data);
    }

    /**
     * Add or update info for user profile.
     *
     * @author Le Tuan Tu
     * @param array $param Input data.
     * @return int|bool Returns the integer or the boolean.
     */
    public static function add_update($param) {
        $id = !empty($param['id']) ? $param['id'] : 0;
        $activation = new self;
        if (!empty($id)) {
            $activation = self::find($id);
            if (empty($activation)) {
                return false;
            }
        } else {
            $activation->set('disable', 1);
        }
        if (!empty($param['user_id'])) {
            $activation->set('user_id', $param['user_id']);
        }
        if (!empty($param['email'])) {
            $activation->set('email', $param['email']);
        }
        if (!empty($param['password'])) {
            $activation->set('password', Util::encodePassword($param['password'], $param['email']));
        }
        if (!empty($param['token'])) {
            $activation->set('token', $param['token']);
        }
        if (!empty($param['expire_date'])) {
            $activation->set('expire_date', $param['expire_date']);
        }
        if (!empty($param['regist_type'])) {
            $activation->set('regist_type', $param['regist_type']);
        }
        if ($activation->save()) {
            if (empty($activation->id)) {
                $activation->id = self::cached_object($activation)->_original['id'];
            }
            return !empty($activation->id) ? $activation->id : 0;
        }
        return false;
    }

    /**
     * Function to disable or enable a user.
     *
     * @author Le Tuan Tu
     * @param array $param Input data.
     * @throws Exception If the provided is not of type array.
     * @return int bool Returns the boolean.
     */
    public static function disable($param) {
        if (empty($param['id'])) {
            return false;
        }
        $ids = explode(',', $param['id']);
        foreach ($ids as $id) {
            $user = self::find($id);
            if (empty($user)) {
                return false;
            }
            $user->set('disable', $param['disable']);
            if (!$user->update()) {
                return false;
            }
        }
        return true;
    }

    /**
     * Check token from model user activation.
     *
     * @author Le Tuan Tu
     * @param array $param Input data.
     * @return int Returns the integer.
     */
    public static function check_token($param) {
        $query = DB::select()
                ->from(self::$_table_name)
                ->where('token', '=', $param['token'])
                ->where('regist_type', '=', $param['regist_type']);
        $data = $query->execute(self::$slave_db)->offsetGet(0);
        if (empty($data)) {
            self::errorNotExist('token');
            return false;
        }
        if (!empty($data['disable']) && $data['disable'] == '1') {
            self::errorOther(self::ERROR_CODE_OTHER_1, 'token', 'Token has already been used');
            return false;
        }
        if (intval($data['expire_date']) < time()) {
            self::errorOther(self::ERROR_CODE_OTHER_2, 'token', 'Token has been expired');
            return false;
        }
        return true;
    }
    

    /**
     * Add register mail, password, generate token, expire date and register type to database.
     *
     * @author Le Tuan Tu
     * @param array $param Input data.
     * @return bool Returns the boolean.
     */
    public static function register_email($param) {
        $param['regist_type'] = 'register_user';
        if (empty($param['sex_id'])) {
            $param['sex_id'] = '0';
        }   
        $user = Model_User::find('first', array(
            'where' => array(
                'email' => $param['email']
            )
        ));
        if (!empty($user)) {
            \LogLib::info('Duplicate email', __METHOD__, $param);
            self::errorDuplicate('email', $param['email']);
            return false;
        }
        $userActivation = self::find('first', array(
            'where' => array(
                'email' => $param['email'],
                'regist_type' => $param['regist_type'],
                'disable' => '0'
            )
        ));
        if (!empty($userActivation)) {
            \LogLib::info('Duplicate email in user_activations', __METHOD__, $param);
            self::errorOther(self::ERROR_CODE_OTHER_1, 'email', "Email have been already registered and waiting activation");
            
            // KienNH, 2016/01/19, begin
            // Update password, expire_date
            $userActivation->set('password', Util::encodePassword($param['password'], $param['email']));
            $userActivation->set('expire_date', \Config::get('register_token_expire'));
            if ($userActivation->update()) {
                // Re-send email
                $param = array(
                    'email' => $param['email'],
                    'token' => $userActivation['token'],
                    'language_type' => !empty($param['language_type']) ? $param['language_type'] : 1
                );
                if (!\Lib\Email::sendRegisterEmail($param)) {
                    \LogLib::warning('Can not send register email', __METHOD__, $param);
                }
            }
            // KienNH end
            
            return false;
        }
        $param['token'] = \Lib\Str::generate_token();
        $userActivation = new self;
        $userActivation->set('user_id', '0');
        $userActivation->set('email', $param['email']);
        $userActivation->set('password', Util::encodePassword($param['password'], $param['email']));
        $userActivation->set('sex_id', $param['sex_id']);
        $userActivation->set('token', $param['token']);
        $userActivation->set('expire_date', \Config::get('register_token_expire'));
        $userActivation->set('regist_type', $param['regist_type']);
        $userActivation->set('os', $param['os']);
        if (!$userActivation->create()) {
            \LogLib::info('Can not insert user_activations', __METHOD__, $param);
            self::errorOther(self::ERROR_CODE_OTHER_1, 'email', "Can not insert user_activations");// KienNH, 2016/01/19, add error
            return false;
        }
        $param = array(
            'email' => $param['email'],
            'token' => $param['token'],
            'language_type' => !empty($param['language_type']) ? $param['language_type'] : 1
        );
        if (!\Lib\Email::sendRegisterEmail($param)) {
            \LogLib::warning('Can not send register email', __METHOD__, $param);
            self::errorOther(self::ERROR_CODE_OTHER_1, 'email', "Can not send register email");// KienNH, 2016/01/19, add error
            return false;
        }
        return true;
    }

    /**
     * Resend register email.
     *
     * @author Le Tuan Tu
     * @param array $param Input data.
     * @return bool Returns the boolean.
     */
    public static function resend_register_email($param) {
        $option['where'] = array(
            'email' => $param['email'],
            'disable' => '0',
            array(
                array('regist_type', \Config::get('user_activations_type')['register_user']),
                'or' => array(
                    array('regist_type', \Config::get('user_activations_type')['register_recruiter'])
                )
            )
        );
        $userActivation = self::find('first', $option);
        if (!empty($userActivation)) {
            $token = $userActivation->get('token');
            // update new expire_date
            $userActivation->set('expire_date', \Config::get('register_token_expire'));
            if (!$userActivation->update()) {
                \LogLib::info('Can not update user_activations', __METHOD__, $param);
                return false;
            }
            $param = array(
                'email' => $param['email'],
                'token' => $token,
                'language_type' => !empty($param['language_type']) ? $param['language_type'] : 1
            );
            if (!\Lib\Email::sendRegisterEmail($param)) {
                \LogLib::warning('Can not send register email', __METHOD__, $param);
                return false;
            }
        } else {
            \LogLib::info('Not exist email in user_activations', __METHOD__, $param);
            self::errorNotExist('email', $param['email']);
            return false;
        }
        return true;
    }

    /**
     * Check token, insert to User, User Profile, update disable in User Activation.
     *
     * @author Le Tuan Tu
     * @param array $param Input data.
     * @return bool Returns the boolean.
     */
    public static function register_active($param) {

        \LogLib::info('Start register_active', __METHOD__, $param);        
        $userActivation = self::find('first', array(
            'where' => array(
                array('token', "=", $param['token']),
                array('expire_date', ">", time()),
                array('disable', "=", 0),
            )
        ));
        if (empty($userActivation)) {
            \LogLib::info('Token is invalid', __METHOD__, $param);
            self::errorNotExist('token', $param['token']);
            return false;
        } else {
            $loginUser = Model_User::register_by_mobile(
                array(
                    'email' => $userActivation->get('email'),
                    'password' => $userActivation->get('password'),
                    'os' => $userActivation->get('os'),
                    'language_type' => !empty($param['language_type']) ? $param['language_type'] : 1
                )               
            );
            if (!empty(self::error())) {                
                return false;
            }
            $userActivation->set('disable', '1');
            $userActivation->save();
            return $loginUser;           
        }
        self::errorParamInvalid('token');
        return false;
    }

}
