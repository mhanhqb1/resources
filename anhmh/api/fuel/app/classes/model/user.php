<?php

use Fuel\Core\DB;
use Lib\Util;

/**
 * Any query in Model User
 *
 * @package Model
 * @created 2015-03-19
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Model_User extends Model_Abstract
{
    /** @var array $_properties field of table */
    protected static $_properties = array(
        'id',
        'app_id',
        'password',
        'name',
        'sex_id',
        'email',
        'birthday',
        'zipcode',
        'user_physical_type_id',
        'is_smoker',
        'image_path',
        'cover_image_path',
        'memo',
        'count_follow',
        'count_follower',
        'disable_by_user',
        'is_ios',
        'is_android',
        'is_web',
        'team_id',
        'created',
        'updated',
        'disable',
        'point_total',
        'point_get_total',
        'point_pay_total',
    );
    
    protected static $_observers  = array(
        'Orm\Observer_CreatedAt' => array(
            'events'          => array('before_insert'),
            'mysql_timestamp' => false,
        ),
        'Orm\Observer_UpdatedAt' => array(
            'events'          => array('before_update'),
            'mysql_timestamp' => false,
        ),
    );

    /** @var array $_table_name name of table */
    protected static $_table_name = 'users';

    /**
     * Add or update info for User
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return int|bool User id or false if error
     */
    public static function add_update($param)
    {
        $is_new = false;
        $id = !empty($param['id']) ? $param['id'] : 0;
        $user = new self;
        // check exist in case of updating
        if (!empty($id)) {
            $user = self::find($id);
            if (empty($user)) {
                self::errorNotExist('user_id');
                return false;
            }
        } else {
            $is_new = true;
            //check email if exist in case of adding new      
            if (!empty($param['email'])) {
                $option['where'] = array(
                    'email' => $param['email']
                );
                $profile = self::find('first', $option);
                if (!empty($profile)) {
                    \LogLib::info('Duplicate email in users', __METHOD__, $param);
                    self::errorDuplicate('email', $param['email']);
                    return false;
                }
            }
            // create user_id
            $user_guest = new Model_User_Guest_Id;
            $userId = $user_guest->add($param);
            if (self::error()) {
                return false;
            }
            $user->set('id', $userId);
            $user->set('email', '');
            $user->set('count_follow', 0);
            $user->set('count_follower', 0);
            $user->set('disable_by_user', 0);
            $user->set('is_ios', 0);
            $user->set('is_android', 0);
            $user->set('is_web', 0);
            switch ($param['os']) {
                case \Config::get('os')['ios']:
                    $user->set('is_ios', 1);
                    break;
                case \Config::get('os')['android']:
                    $user->set('is_android', 1);
                    break;
                default:
                    $user->set('is_web', 1);
            }
        }
        // set value
        if (empty($param['sex_id'])) {
            $param['sex_id'] = 0;
        }
        if (empty($param['user_physical_type_id'])) {
            $param['user_physical_type_id'] = 0;
        }
        if (empty($param['password']) && $is_new) {
            //generate password with 6 characters
            $param['password'] = Lib\Str::generate_password();
            $user->set('password', Lib\Util::encodePassword($param['password'], $param['email']));
        } elseif (isset($param['password']) && $param['password'] !== '') {
            $user->set('password', Lib\Util::encodePassword($param['password'], $param['email']));
        }
        $user->set('sex_id', $param['sex_id']);
        $user->set('user_physical_type_id', $param['user_physical_type_id']);
        if (isset($param['name'])) {
            $user->set('name', $param['name']);
        }
        if (isset($param['birthday']) && $param['birthday'] !== '') {
            $user->set('birthday', self::time_to_val($param['birthday']));
        }
        if (isset($param['email'])) {
            $user->set('email', $param['email']);
        }
        if (isset($param['image_path'])) {
            $user->set('image_path', $param['image_path']);
        }
        if (isset($param['zipcode'])) {
            $user->set('zipcode', $param['zipcode']);
        }
        if (isset($param['memo'])) {
            $user->set('memo', $param['memo']);
        }
        if (isset($param['team_id']) && $param['team_id'] !== '') {
            $user->set('team_id', $param['team_id']);
        }
        // save to database
        if ($user->save()) {
            if (empty($user->id)) {
                $user->id = self::cached_object($user)->_original['id'];
            }
            //sending email if add new
            if ($is_new == true) {
                $info = array(
                    'user_id'  => $user->id,
                    'email'    => $param['email'],
                    'password' => $param['password'],
                    'language_type' => !empty($param['language_type']) ? $param['language_type'] : 1
                );
                if (!\Lib\Email::sendCreateUser($info)) {
                    \LogLib::warning('Can not resend create user email', __METHOD__, $info);
                }
            }
            return !empty($user->id) ? $user->id : 0;
        }
        return false;
    }

    /**
     * Update info for User
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return int|bool User id or false if error
     */
    public static function update_profile($param)
    {
        $user = self::find($param['user_id']);
        if (empty($user)) {
            self::errorNotExist('user_id');
            return false;
        }
        
        // id check
        if (!self::isMyUserid($param['user_id'])){
            self::errorPermission('user_id');
            return false;
        }

        if (!empty($param['email'])) {
            $query = DB::select()
                ->from(self::$_table_name)
                ->where(self::$_table_name . '.id', '<>', $param['user_id'])
                ->where(self::$_table_name . '.email', '=', $param['email']);
            $checkEmail = $query->execute()->offsetGet(0);
            if (!empty($checkEmail)) {
                \LogLib::info('Check Duplicate email in users', __METHOD__, $param);
                self::errorDuplicate('email');
                return false;
            } else {
                $user->set('email', $param['email']);
            }
        }
        if (isset($param['password']) && $param['password'] !== '') {
            $user->set('password', Lib\Util::encodePassword($param['password'], $user->get('email')));
        } else {
            $param['password'] = preg_replace('/^[^\:\;]+\:\;/', '', Lib\Util::decodePassword($user->get('password')));
        }
        if (isset($param['name']) && $param['name'] !== '') {
            $user->set('name', $param['name']);
        }
        if (isset($param['kana']) && $param['kana'] !== '') {
            $user->set('kana', $param['kana']);
        }
        if (isset($param['sex']) && $param['sex'] !== '') {
            $user->set('sex', $param['sex']);
        }
        if (isset($param['phone']) && $param['phone'] !== '') {
            $user->set('phone', $param['phone']);
        }
        if (!empty($param['birthday'])) {
            $user->set('birthday', self::time_to_val($param['birthday']));
        }
        if (isset($param['prefecture_id'])) {
            $user->set('prefecture_id', $param['prefecture_id']);
        }
        if (isset($param['address1'])) {
            $user->set('address1', $param['address1']);
        }
        if (isset($param['address2'])) {
            $user->set('address2', $param['address2']);
        }
        if (isset($param['is_magazine']) && $param['is_magazine'] !== '') {
            $user->set('is_magazine', $param['is_magazine']);
        }
        if (isset($param['visit_element']) && $param['visit_element'] !== '') {
            $user->set('visit_element', $param['visit_element']);
        }
        if (isset($param['post_code']) && $param['post_code'] !== '') {
            $user->set('post_code', $param['post_code']);
        }
        if ($user->update()) {
            \LogLib::info('Save users information', __METHOD__, $user);
            return self::get_detail(array(
                'id' => $param['user_id']
            ));
        }
        return false;
    }

    /**
     * Update info for User
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return int|bool User id or false if error
     */
    public static function update_profile_by_mobile($param)
    {
        $user = self::find($param['login_user_id']);
        if (empty($user)) {
            self::errorNotExist('user_id', $param['login_user_id']);
            return false;
        }
        if (!empty($param['email'])) {
            $query = DB::select()
                ->from(self::$_table_name)
                ->where(self::$_table_name . '.id', '<>', $param['login_user_id'])
                ->where(self::$_table_name . '.email', '=', $param['email']);
            $checkEmail = $query->execute()->offsetGet(0);
            if (!empty($checkEmail)) {
                \LogLib::info('Duplicate email', __METHOD__, $param);
                self::errorDuplicate('email');
                return false;
            } else {
                $user->set('email', $param['email']);
            }
        }
        if (isset($param['password']) && $param['password'] !== '') {
            $user->set('password', Lib\Util::encodePassword($param['password'], $user->get('email')));
        }
        if (isset($param['name'])) {
            $user->set('name', $param['name']);
        }
        if (isset($param['sex_id']) && $param['sex_id'] !== '') {
            $user->set('sex_id', $param['sex_id']);
        }
        if (isset($param['zipcode'])) {
            $user->set('zipcode', $param['zipcode']);
        }
        if (!empty($param['birthday'])) {
            $user->set('birthday', self::time_to_val($param['birthday']));
        }
        if (!empty($param['user_physical_type_id'])) {
            $user->set('user_physical_type_id', $param['user_physical_type_id']);
        }
        if (isset($param['memo'])) {
            $user->set('memo', $param['memo']);
        }
        if (!empty($_FILES)) {            
            $uploadResult = \Lib\Util::uploadImage();
            if (empty($uploadResult['error'])) {
                if (isset($uploadResult['body']['image_path'])) {
                    $user->set('image_path', $uploadResult['body']['image_path']);
                }
                if (isset($uploadResult['body']['cover_image_path'])) {
                    $user->set('cover_image_path', $uploadResult['body']['cover_image_path']);
                }
            } else {
                self::setError($uploadResult['error']);
                return false;
            }
        }
        // KienNH, 2016/02/16: Begin Delete image
        if (!empty($param['delete_avatar_flg'])) {
            Util::deleteImage($user->get('image_path'));
            $user->set('image_path', NULL);
        }
        if (!empty($param['delete_cover_flg'])) {
            Util::deleteImage($user->get('cover_image_path'));
            $user->set('cover_image_path', NULL);
        }
        // KienNH end
        if ($user->update()) {
            \LogLib::info('Save users information', __METHOD__, $user);
            return self::get_detail(array(
                'id' => $param['login_user_id']
            ));
        }
        return false;
    }

    /**
     * Get list User (with array count)
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array List User
     */
    public static function get_list($param)
    {
        $query = DB::select(
                self::$_table_name . '.id',
                'app_id',
                'password',
                'name',
                'sex_id',
                'email',
                'birthday',
                'zipcode',
                'user_physical_type_id',
                'is_smoker',
                DB::expr("IFNULL(IF(image_path='',NULL,image_path), '" . \Config::get('no_image_user') . "') AS image_path"),
                DB::expr("IFNULL(IF(cover_image_path='',NULL,cover_image_path), '" . \Config::get('no_image_cover') . "') AS cover_image_path"),
                'count_follow',
                'count_follower',
                'disable_by_user',
                'is_ios',
                'is_android',
                'is_web',
                'memo',
                self::$_table_name . '.created',
                self::$_table_name . '.updated',
                self::$_table_name . '.disable',
                self::$_table_name . '.point_total',
                self::$_table_name . '.point_get_total',
                self::$_table_name . '.point_pay_total'
            )
            ->from(self::$_table_name);
        
        // KienNH, 2016/03/03 Begin search by follower
        if (!empty($param['followid']) && !empty($param['followerid'])) {
            $query->join(
            array(
                DB::expr("(SELECT user_id, follow_user_id
                    FROM follow_users
                    WHERE `disable` = 0
                    AND user_id = '{$param['followerid']}'
                    AND follow_user_id = '{$param['followid']}'
                )")
                , 'fusers')
            )->on(self::$_table_name . '.id', '=', 'fusers.user_id')
            ->or_on(self::$_table_name . '.id', '=', 'fusers.follow_user_id');
        } elseif (!empty($param['followid']) || !empty($param['followerid'])) {
            if (!empty($param['followid'])) {
                $query->join(
                array(
                    DB::expr("(SELECT DISTINCT user_id AS u_id
                        FROM follow_users
                        WHERE `disable` = 0
                        AND follow_user_id = '{$param['followid']}'
                    )")
                    , 'fusers')
                )->on(self::$_table_name . '.id', '=', 'fusers.u_id');
            } else {
                $query->join(
                array(
                    DB::expr("(SELECT DISTINCT follow_user_id AS u_id
                        FROM follow_users
                        WHERE `disable` = 0
                        AND user_id = '{$param['followerid']}'
                    )")
                    , 'fusers')
                )->on(self::$_table_name . '.id', '=', 'fusers.u_id');
            }
        }
        // KienNH end
        
        // filter by keyword
        if (!empty($param['id'])) {
            $query->where(self::$_table_name . '.id', '=', $param['id']);
        }
        if (!empty($param['name'])) {
            $query->where(self::$_table_name . '.name', 'like', "%{$param['name']}%");
        }
        if (!empty($param['email'])) {
            $query->where(self::$_table_name . '.email', '=', $param['email']);
        }
        if (isset($param['sex_id']) && $param['sex_id'] !== '') {
            $query->where(self::$_table_name . '.sex_id', '=', $param['sex_id']);
        }
        if (!empty($param['zipcode'])) {
            $query->where(self::$_table_name . 'zipcode', '=', $param['zipcode']);
        }
        if (isset($param['user_physical_type_id']) && $param['user_physical_type_id'] !== '') {
            $query->where(self::$_table_name . '.user_physical_type_id', '=', $param['user_physical_type_id']);
        }
        if (isset($param['is_ios']) && $param['is_ios'] !== '') {
            $query->where(self::$_table_name . '.is_ios', '=', $param['is_ios']);
        }
        if (isset($param['is_android']) && $param['is_android'] !== '') {
            $query->where(self::$_table_name . '.is_android', '=', $param['is_android']);
        }
        if (isset($param['is_web']) && $param['is_web'] !== '') {
            $query->where(self::$_table_name . '.is_web', '=', $param['is_web']);
        }
        if (isset($param['disable']) && $param['disable'] !== '') {
            $query->where(self::$_table_name . '.disable', '=', $param['disable']);
        }
        if (isset($param['disable_by_user']) && $param['disable_by_user'] !== '') {
            $query->where(self::$_table_name . '.disable_by_user', '=', $param['disable_by_user']);
        }
        // KienNH 2016/03/08 : add search by team_id
        if (!empty($param['team_id'])) {
            $query->where(self::$_table_name . '.team_id', '=', $param['team_id']);
        }
        // KienNH end
        if (!empty($param['sort'])) {
            // KienNH 2016/04/20 check valid sort
            if (!self::checkSort($param['sort'])) {
                self::errorParamInvalid('sort');
                return false;
            }
            
            $sortExplode = explode('-', $param['sort']);
            $query->order_by(self::$_table_name . '.' . $sortExplode[0], $sortExplode[1]);
        } else {
            $query->order_by(self::$_table_name . '.created', 'DESC');
        }
        if (!empty($param['page']) && !empty($param['limit'])) {
            $offset = ($param['page'] - 1) * $param['limit'];
            $query->limit($param['limit'])->offset($offset);
        }
        $query->group_by(self::$_table_name . '.id');
        // get data
        $data = $query->execute(self::$slave_db)->as_array();
        $total = !empty($data) ? DB::count_last_query(self::$slave_db) : 0;
        return array($total, $data);
    }

    /**
     * Get list User (with array count)
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array List User
     */
    public static function get_all($param)
    {
        $query = DB::select()
                ->from(self::$_table_name)
                ->where(self::$_table_name . '.disable', '0');
        if (!empty($param['id'])) {
            if (!is_array($param['id'])) {
                $param['id'] = array($param['id']);
            }
            $query->where(self::$_table_name . '.id', 'IN', $param['id']); 
        }
        $data = $query->execute(self::$slave_db)->as_array();
        return $data;
    }

    /**
     * Disable/Enable list User
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return bool Success or otherwise
     */
    public static function disable($param)
    {
        $ids = explode(',', $param['id']);
        foreach ($ids as $id) {
            $user = self::find($id);
            if ($user) {
                $user->set('disable', $param['disable']);
                if (!$user->save()) {
                    return false;
                }
            } else {
                self::errorNotExist('user_id');
                return false;
            }
        }
        return true;
    }

    /**
     * Get detail User
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array|bool Detail User or false if error
     */
    public static function get_detail($param)
    {
        $data = self::find($param['id']);
        if (empty($data)) {
            static::errorNotExist('user_id');
            return false;
        }
        return $data;
    }

    /**
     * Login User
     *
     * @author thailh
     * @param array $param Input data
     * @return array|bool Detail User or false if error
     */
    public static function get_login($param, $noCheckPassword = false)
    {
        if (self::check_login_failed() != 1) {
            static::errorOther(static::ERROR_CODE_OTHER_1, 'Blocked');
            return false;
        }
        // Get login failed
        $ipAddress = \Lib\Ip4filter::getClientIp();
        $loginFailed = Model_Loginfail::find('first', array(
            'where' => array(
                'ip_address' => $ipAddress
            )
        ));

        // Check email exist
        $checkEmail = self::find('first', array(
            'where' => array(
                'email' => $param['email']
            )
        ));
        if (empty($checkEmail)) {
            static::errorOther(static::ERROR_CODE_EMAIL_NOT_EXIST, 'Invalid Email');
            // update counter when login failed
            self::update_login_failed($ipAddress, $loginFailed);
            return false;
        }
        \LogLib::info('Login', __METHOD__, $param);
        $query = DB::select(
                array('users.id', 'id'),
                array('users.app_id', 'app_id'),
                array('users.name', 'name'),
                array('users.sex_id', 'sex_id'),
                array('users.email', 'email'),
                array('users.birthday', 'birthday'),
                array('users.zipcode', 'zipcode'),
                array('users.user_physical_type_id', 'user_physical_type_id'),
                array('users.is_smoker', 'is_smoker'),
                array('users.is_ios', 'is_ios'),
                array('users.is_android', 'is_android'),
                array('users.is_web', 'is_web'),
                array('users.team_id', 'team_id'),
                DB::expr("teams.name as team_name"),
                DB::expr("IFNULL(IF(users.image_path = '', NULL, users.image_path),'" . \Config::get('no_image_user') . "') AS image_path"),
                DB::expr("IFNULL(IF(users.cover_image_path = '', NULL, cover_image_path),'" . \Config::get('no_image_cover') . "') AS cover_image_path"),
                array('users.count_follow', 'count_follow'),
                array('users.count_follower', 'count_follower'),
                array('users.memo', 'memo'),
                array('users.disable', 'disable'),
                array('users.point_total', 'point_total'),
                array('users.point_get_total', 'point_get_total'),
                array('users.point_pay_total', 'point_pay_total')
            )
            ->from(self::$_table_name)
            ->join('teams', 'LEFT')
            ->on('teams.id', '=', self::$_table_name . '.team_id')
            ->where(self::$_table_name . '.email', $param['email']);
        if ($noCheckPassword === false) {
            $query->where(self::$_table_name . '.password', Lib\Util::encodePassword($param['password'], $param['email']));
        }
        $login = $query->execute()->offsetGet(0);

        if ($login) {
            if (empty($login['disable'])) {
                $login['token'] = Model_Authenticate::addupdate(array(
                    'user_id' => $login['id'],
                    'regist_type' => 'user'
                ));
                if (isset($param['os'])) {                    
                    if ($login['is_ios'] == 0 && $param['os'] == \Config::get('os')['ios']) {                        
                        $user = self::find($login['id']);
                        $user->set('is_ios', $login['is_ios'] = '1');
                        $user->save();
                    } elseif ($login['is_android'] == 0 && $param['os'] == \Config::get('os')['android']) {                     
                        $user = self::find($login['id']);
                        $user->set('is_android', $login['is_android'] = '1');
                        $user->save();
                    } elseif ($login['is_web'] == 0 && $param['os'] == \Config::get('os')['webos']) {
                        $user = self::find($login['id']);
                        $user->set('is_web', $login['is_web'] = '1');
                        $user->save();
                    }
                }
                if (!empty($loginFailed)) {
                    // reset counter when login success
                    $loginFailed->set('count', 0);
                    $loginFailed->set('updated', strtotime(date('Y-m-d H:i:s')));
                    $loginFailed->save();
                }
                return $login;
            }
            static::errorOther(static::ERROR_CODE_OTHER_1, 'User is disabled');
            // update counter when login failed
            self::update_login_failed($ipAddress, $loginFailed);
            return false;
        }
        static::errorOther(static::ERROR_CODE_AUTH_ERROR, 'Email/Password');
        // update counter when login failed
        self::update_login_failed($ipAddress, $loginFailed);
        return false;
    }

    /**
     * Function to register user.
     *
     * @author Hoang Gia Thong
     * @return array Returns the array.
     */
    public static function register($param)
    {
        //check email if exist in user_profiles (not for user_recruiter)
        $option['where'] = array(
            'email' => $param['email']
        );
        $profile = self::find('first', $option);
        if (!empty($profile)) {
            \LogLib::info('[Register user] Duplicate email in users', __METHOD__, $param);
            self::errorDuplicate('email', $param['email']);
            return false;
        }
        $user = new self;

        // set value
        if (!empty($param['name'])) {
            $user->set('name', $param['name']);
        }
        if (isset($param['kana']) && $param['kana'] !== '') {
            $user->set('kana', $param['kana']);
        }
        if (isset($param['sex']) && $param['sex'] !== '') {
            $user->set('sex', $param['sex']);
        } else {
            $user->set('sex', 0);
        }
        if (isset($param['birthday']) && $param['birthday'] !== '') {
            $user->set('birthday', self::time_to_val($param['birthday']));
        }
        if (isset($param['phone']) && $param['phone'] !== '') {
            $user->set('phone', $param['phone']);
        }
        if (isset($param['email']) && $param['email'] !== '') {
            $user->set('email', $param['email']);
        }
        if (isset($param['prefecture_id']) && $param['prefecture_id'] !== '') {
            $user->set('prefecture_id', $param['prefecture_id']);
        }
        if (isset($param['address1']) && $param['address1'] !== '') {
            $user->set('address1', $param['address1']);
        }
        if (isset($param['address2']) && $param['address2'] !== '') {
            $user->set('address2', $param['address2']);
        }
        if (isset($param['password']) && $param['password'] !== '') {
            $user->set('password', Util::encodePassword($param['password'], $param['email']));
        }
        if (isset($param['is_magazine']) && $param['is_magazine'] !== '') {
            $user->set('is_magazine', $param['is_magazine']);
        }
        if (isset($param['visit_element'])) {
            $user->set('visit_element', $param['visit_element']);
        }
        // save to database
        if ($user->save()) {
            if (empty($user->id)) {
                $user->id = self::cached_object($user)->_original['id'];
                $user->email = self::cached_object($user)->_original['email'];
                $user->name = self::cached_object($user)->_original['name']; //added by KhoaTX on 2015-05-22
            }

            // send email
            if (!\Lib\Email::sendRegisterEmail(array(
                'email'     => $user->email,
                'user_name' => $user->name,//added by KhoaTX on 2015-05-22
                'language_type' => !empty($param['language_type']) ? $param['language_type'] : 1
            ))
            ) {
                \LogLib::warning('Can not send register email', __METHOD__, $param);
            }

            //return !empty($user->id) ? $user->id : 0;
            // Return user login information
            \LogLib::info('[Register user] register ok', __METHOD__, $user->to_array());
            return self::get_login(array(
                'email'    => $user->get('email'),
                'password' => $param['password']
            ));
        }
        return false;
    }

    /**
     * Login facebook
     *
     * @author diennvt
     * @param array $facebookInfo Input data.
     * @param int $isCompany Input data or not input data.
     * @return bool Returns the boolean.
     */
    public static function login_facebook($facebookInfo, $param = array())
    {
        if (empty($facebookInfo['email']) && empty($facebookInfo['id'])) {
            self::errorNotExist('facebook_id_and_email');
            return false;
        }
        $param['facebook_birthday'] = isset($facebookInfo['birthday']) ? $facebookInfo['birthday'] : '';
        $param['facebook_email'] = isset($facebookInfo['email']) ? $facebookInfo['email'] : '';
        $param['facebook_id'] = isset($facebookInfo['id']) ? $facebookInfo['id'] : '';
        $param['facebook_name'] = isset($facebookInfo['name']) ? $facebookInfo['name'] : '';
        $param['facebook_first_name'] = isset($facebookInfo['first_name']) ? $facebookInfo['first_name'] : '';
        $param['facebook_last_name'] = isset($facebookInfo['last_name']) ? $facebookInfo['last_name'] : '';
        $param['facebook_username'] = isset($facebookInfo['username']) ? $facebookInfo['username'] : '';
        $param['facebook_gender'] = isset($facebookInfo['gender']) ? $facebookInfo['gender'] : '';
        $param['facebook_link'] = isset($facebookInfo['link']) ? $facebookInfo['link'] : '';
        $param['facebook_image'] = "http://graph.facebook.com/{$param['facebook_id']}/picture?type=large";
        $param['os'] = isset($facebookInfo['os']) ? $facebookInfo['os'] : '';

        if (!empty($param['facebook_email'])) {
            $facebook = Model_User_Facebook_Information::get_detail(array(
                    'facebook_email' => $param['facebook_email'],
                    'disable'        => 0
                )
            );
        } elseif (!empty($param['facebook_id'])) {
            $facebook = Model_User_Facebook_Information::get_detail(array(
                    'facebook_id' => $param['facebook_id'],
                    'disable'     => 0
                )
            );
        }
        if (!empty($facebook['facebook_id']) && $facebook['facebook_id'] != $param['facebook_id']) {
            if (Model_User_Facebook_Information::add_update(array(
                'id'          => $facebook['id'],
                'facebook_id' => $param['facebook_id'],
            ))
            ) {
                $facebook['facebook_id'] = $param['facebook_id'];
                \LogLib::info('Update facebook_id', __METHOD__, $param);
            }
        }

        $isNewUser = false; //use to differ first new login facebook or not
        if (!empty($facebook['user_id']) && !empty($facebook['facebook_id'])) {
            \LogLib::info('User used to login with facebook', __METHOD__, $facebook);
            $userId = $facebook['user_id'];
        } elseif (!empty($facebook['user_id']) && empty($facebook['facebook_id'])) {
            \LogLib::info('User used to login without facebook', __METHOD__, $facebook);
            $param['user_id'] = $facebook['user_id'];
            if (Model_User_Facebook_Information::add_update($param)) {
                \LogLib::info('Update facebook info', __METHOD__, $param);
                $userId = $facebook['user_id'];
            }
        } else {
            $isNewUser = true;
            \LogLib::info('First login using facebook', __METHOD__, $param);
            $param['email'] = $param['facebook_email'];
            $param['password'] = '';
            $param['name'] = $param['facebook_name'];
            $param['image_path'] = $param['facebook_image'];
            if (!empty($param['facebook_birthday'])) {
                $param['birthday'] = $param['facebook_birthday'];
            }
            if ($param['facebook_gender'] == 'male') {
                $param['sex_id'] = 1;
            } elseif ($param['facebook_gender'] == 'female') {
                $param['sex_id'] = 2;
            } else {
                $param['sex_id'] = 0;
            }
            $userId = Model_User::add_update($param);
            if ($userId > 0) {
                // Add user_facebook_information
                $param['user_id'] = $userId;
                if (Model_User_Facebook_Information::add_update($param)) {
                    \LogLib::info('Add facebook info', __METHOD__, $param);
                }
            }
        }
        if (!empty($userId)) {
            \LogLib::info('Return user info', __METHOD__, $param);
            $data = self::get_profile(array('user_id' => $userId));            
            if (!empty($data)) {
                $data['is_new_user'] = $isNewUser;
                return $data;
            }
        }
        \LogLib::info('User info unavailable', __METHOD__, $param);
        self::errorNotExist('fb_user_information');
        return false;
    }
    
    /**
     * Login facebook
     * 
     * @param array $facebookInfo
     * @param array $param
     * @return boolean | array
     */
    public static function login_facebook_new($facebookInfo, $param = array()) {
        // Check valid Facebook's info
        if (empty($facebookInfo['email']) && empty($facebookInfo['id'])) {
            self::errorNotExist('facebook_id_and_email');
            return false;
        }
        
        // Init
        $isNewUser = false;
        
        // Build param
        $param['facebook_birthday']     = isset($facebookInfo['birthday']) ? $facebookInfo['birthday'] : '';
        $param['facebook_email']        = isset($facebookInfo['email']) ? $facebookInfo['email'] : '';
        $param['facebook_id']           = isset($facebookInfo['id']) ? $facebookInfo['id'] : '';
        $param['facebook_name']         = isset($facebookInfo['name']) ? $facebookInfo['name'] : '';
        $param['facebook_first_name']   = isset($facebookInfo['first_name']) ? $facebookInfo['first_name'] : '';
        $param['facebook_last_name']    = isset($facebookInfo['last_name']) ? $facebookInfo['last_name'] : '';
        $param['facebook_username']     = isset($facebookInfo['username']) ? $facebookInfo['username'] : '';
        $param['facebook_gender']       = isset($facebookInfo['gender']) ? $facebookInfo['gender'] : '';
        $param['facebook_link']         = isset($facebookInfo['link']) ? $facebookInfo['link'] : '';
        $param['facebook_image']        = "http://graph.facebook.com/{$param['facebook_id']}/picture?type=large";
        $param['os']                    = isset($facebookInfo['os']) ? $facebookInfo['os'] : '';
        
        // Get User's info
        if (!empty($param['facebook_email'])) {
            // Get User's info from table users
            $user = self::find('first', array(
                'where' => array(
                    'email' => $param['facebook_email'],
                )
            ));
        } else {
            // Get User's info from table user_facebook_informations
            $facebook = Model_User_Facebook_Information::find('first', array(
                'where' => array(
                    'facebook_id' => $param['facebook_id'],
                )
            ));
            
            if (!empty($facebook)) {
                $user = self::find('first', array(
                    'where' => array(
                        'id' => $facebook['user_id']
                    )
                ));
            }
        }
        
        // Create new User
        if (empty($user)) {
            $isNewUser = true;
            
            $param['email'] = $param['facebook_email'];
            $param['password'] = '';
            $param['name'] = $param['facebook_name'];
            $param['image_path'] = $param['facebook_image'];
            
            if (!empty($param['facebook_birthday'])) {
                $param['birthday'] = $param['facebook_birthday'];
            }
            
            if ($param['facebook_gender'] == 'male') {
                $param['sex_id'] = 1;
            } elseif ($param['facebook_gender'] == 'female') {
                $param['sex_id'] = 2;
            } else {
                $param['sex_id'] = 0;
            }
            
            $userId = Model_User::add_update($param);
            
            // Write log
            $param['addupdate_user_id'] = $userId;
            \LogLib::info('Add/Update facebook info', __METHOD__, $param);
        } else {
            $userId = $user['id'];
            
            // Update email
            if (empty($user['email']) && !empty($param['facebook_email'])) {
                $user->set('email', $param['facebook_email']);
                
                // Write log
                \LogLib::info('Add user email from facebook', __METHOD__, $param);
            }
        }
        
        // Create or Update user_facebook_informations
        if (!empty($userId)) {
            $param['user_id'] = $userId;
            $facebook_info_id = Model_User_Facebook_Information::add_update($param);
            
            // Write log
            $param['addupdate_facebook_info_id'] = $facebook_info_id;
            \LogLib::info('Add/Update facebook info', __METHOD__, $param);
        }
        
        // Return data
        if (!empty($userId)) {
            $data = self::get_profile(array(
                'user_id' => $userId
            ));
            
            if (!empty($data)) {
                $data['is_new_user'] = $isNewUser;
                return $data;
            }
        }
        
        // Return common error
        self::errorNotExist('fb_user_information');
        return false;
    }

    /**
     * Login facebook
     *
     * @author diennvt
     * @param array $facebookInfo Input data.
     * @param int $isCompany Input data or not input data.
     * @return bool Returns the boolean.
     */
    public static function login_twitter($twitterInfo, $param = array())
    {
        if (empty($twitterInfo->id)) {
            self::errorNotExist('twitter_id');
            return false;
        }
        $param['tw_id'] = $twitterInfo->id;
        $param['tw_name'] = $twitterInfo->name;
        $param['tw_screen_name'] = $twitterInfo->screen_name;
        $param['tw_description'] = $twitterInfo->description;
        $param['tw_url'] = $twitterInfo->url;
        $param['tw_lang'] = $twitterInfo->lang;
        $param['tw_profile_image_url'] = $twitterInfo->profile_image_url;
        $param['tw_profile_image_url_https'] = $twitterInfo->profile_image_url_https;

        if (!empty($param['tw_id'])) {
            $twitter = Model_User_Twitter_Information::get_detail(array(
                    'tw_id'   => $param['tw_id'],
                    'disable' => 0
                )
            );
        }
        $isNewUser = false; //use to differ first new login twitter or not
        if (!empty($twitter['user_id']) && !empty($twitter['tw_id'])) {
            $userId = $twitter['user_id'];
        } elseif (!empty($twitter['user_id']) && empty($twitter['tw_id'])) {
            $param['user_id'] = $twitter['user_id'];
            if (Model_User_Twitter_Information::add_update($param)) {
                $userId = $twitter['user_id'];
            }
        } else {
            $isNewUser = true;
            $param['email'] = '';
            $param['password'] = '';
            $param['name'] = $param['tw_name'];
            $param['image_path'] = $param['tw_profile_image_url'];
            $userId = Model_User::add_update($param);
            if ($userId > 0) {
                // Add user_twitter_information
                $param['user_id'] = $userId;
                if (Model_User_Twitter_Information::add_update($param)) {
                    \LogLib::info('Add twitter info', __METHOD__);
                }
            }
        }
        if (!empty($userId)) {
            \LogLib::info('Return user info', __METHOD__);
            $data = self::get_profile(array('user_id' => $userId));  
            if (!empty($data)) {
                $data['is_new_user'] = $isNewUser;
                return $data;
            }
        }
        \LogLib::info('User info unavailable', __METHOD__, $param);
        self::errorNotExist('tw_user_information');
        return false;
    }

    /**
     * Login facebook by token.
     *
     * @author diennvt
     * @param array $param Input data.
     * @param int $isCompany Input data or not input data.
     * @return bool Returns the boolean.
     */
    public static function login_facebook_by_token($param)
    {
        @session_start();
        try {
            //\LogLib::info('test fblogim- Get token from cookie', __METHOD__, array(\Config::get('facebook.app_id'), \Config::get('facebook.app_secret')));
            FacebookSession::setDefaultApplication(\Config::get('facebook.app_id'), \Config::get('facebook.app_secret'));
            \LogLib::info('login_facebook_by_token - Get token from cookie', __METHOD__, $param);
            $session = new FacebookSession($param['token']);
            if (isset($session)) {
                \LogLib::info('login_facebook_by_token - Session is OK', __METHOD__, $param);
                $request = new FacebookRequest($session, 'GET', '/me');
                $response = $request->execute();
                $facebookInfo = (array)$response->getResponse();
                if (!empty($facebookInfo)) {
                    \LogLib::info('login_facebook_by_token - call login_facebook', __METHOD__, $facebookInfo);
                    $loginInfo = self::login_facebook($facebookInfo, $param);
                    $loginInfo['fb_token'] = $param['token'];
                    return $loginInfo;
                }
            } else {
                \LogLib::info('login_facebook_by_token - Session is not OK', __METHOD__, $param);
                return false;
            }
        } catch (FacebookRequestException $ex) {
            // When Facebook returns an error
            \LogLib::warning($ex->getRawResponse(), __METHOD__, $param);
            static::errorOther(self::ERROR_CODE_OTHER_1, '', $ex->getRawResponse());
            return false;
        } catch (\Exception $ex) {
            // When validation fails or other local issues
            \LogLib::warning($ex->getMessage(), __METHOD__, $param);
            static::errorOther(self::ERROR_CODE_OTHER_2, '', $ex->getMessage());
            return false;
        }
        \LogLib::info('login_facebook_by_token - There is no token from cookie', __METHOD__, $param);
        return false;
    }

    /**
     * Login twtter by token.
     *
     * @author caolp
     * @param array $param Input data.
     * @param int $isCompany Input data or not input data.
     * @return bool Returns the boolean.
     */
    public static function login_twitter_by_token($param)
    {
        @session_start();
        try {
            $twitter = \Social\Twitter::forge($param['oauth_token'], $param['oauth_token_secret']);
            \LogLib::info('login_twitter_by_token - Get info', __METHOD__, $param);
            if ($twitter) {
                \LogLib::info('login_twitter_by_token - Session is OK', __METHOD__);
                $twitterInfo = $twitter->get('account/verify_credentials', array(
                    //'include_email' => 'true'
                ));
                if (!empty($twitterInfo)) {
                    \LogLib::info('login_twitter_by_token - call login_twitter', __METHOD__, $twitterInfo);
                    $loginInfo = self::login_twitter($twitterInfo, $param);
                    $loginInfo['oauth_token'] = $param['oauth_token'];
                    $loginInfo['oauth_token_secret'] = $param['oauth_token_secret'];
                    return $loginInfo;
                }
            } else {
                \LogLib::info('login_twitter_by_token - Session is not OK', __METHOD__, $param);
                return false;
            }
        } catch (FacebookRequestException $ex) {
            // When Facebook returns an error
            \LogLib::warning($ex->getRawResponse(), __METHOD__, $param);
            static::errorOther(self::ERROR_CODE_OTHER_1, '', $ex->getRawResponse());
            return false;
        } catch (\Exception $ex) {
            // When validation fails or other local issues
            \LogLib::warning($ex->getMessage(), __METHOD__, $param);
            static::errorOther(self::ERROR_CODE_OTHER_2, '', $ex->getMessage());
            return false;
        }
        \LogLib::info('login_twitter_by_token - There is no token from cookie', __METHOD__, $param);
        return false;
    }

    /**
     * Function to processing forget password user.
     *
     * @author tuancd
     * @return array|bool Returns the array or the boolean.
     */
    public static function forget_password($param)
    {
        $conditions['where'] = array(
            'email'   => $param['email'],
            'disable' => 0
        );
        $user = self::find('first', $conditions);
        if (!empty($user)) {
            // get token for sending email and add/update            
            $param['user_id'] = $user->get('id');
            $param['name'] = $user->get('name');
            $option['where'] = array(
                'email' => $param['email'],
                'regist_type' => \Config::get('user_activations_type')['forget_password'],
            );
            //Check user is request forget password ??
            $user_activation = Model_User_Activation::find('first', $option);
            if (!empty($user_activation)) {
                $param['token'] = $user_activation->get('token');
                $user_activation->set('expire_date', \Config::get('register_token_expire'));
                $user_activation->set('disable', '0');
            } else {
                $param['token'] = \Lib\Str::generate_token();
                $user_activation = new Model_User_Activation();
                $user_activation->set('user_id', $user->get('id'));
                $user_activation->set('email', $user->get('email'));
                $user_activation->set('disable', '0');                
                $user_activation->set('regist_type', \Config::get('user_activations_type')['forget_password']);
                $user_activation->set('expire_date', \Config::get('register_token_expire'));
            }
            if (isset($param['os']) && $param['os'] != 'webos') { // get for mobile
                $param['token'] = \Lib\Str::generate_token_forget_password_for_mobile();
            }
            if (!empty($param['token'])) {
                $user_activation->set('token', $param['token']);
            }
            if (!$user_activation->save()) {
                \LogLib::warning('Can not insert/update user_activations', __METHOD__, $param);
                return false;
            }
            if (isset($param['os']) && $param['os'] != 'webos') {
                \Lib\Email::sendForgetPasswordEmailForMobile($param);
            } else {
                \Lib\Email::sendForgetPasswordEmail($param);
            }
            return true;
        }
        // Return email not exists in system
        static::errorNotExist('email', $param['email']);
        return false;
    }

    /**
     * Resend register email.
     *
     * @author tuancd
     * @param array $param Input data.
     * @return bool Returns the boolean.
     */
    public static function resend_forget_password($param)
    {
        $option['where'] = array(
            'email'       => $param['email'],
            'disable'     => '0',
            'regist_type' => \Config::get('user_activations_type')['forget_password']
        );
        $userActivation = \Model_User_Activation::find('first', $option);
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
            if (!\Lib\Email::sendForgetPasswordEmail($param)) {
                \LogLib::warning('Can not resend forgetpassword email', __METHOD__, $param);
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
     * Change password by user_id.
     *
     * @author Le Tuan Tu
     * @param array $param Input data.
     * @return bool Returns the boolean.
     */
    public static function change_password($param)
    {
        // id check
        if (!self::isMyUserid($param['id'])){
            self::errorPermission('id');
            return false;
        }

        $options['where'] = array(
            'id' => $param['id']
        );

        if (!(!empty($param['regist_type']) && $param['regist_type'] == 'admin')) {
            if (empty($param['email'])) {
                static::errorOther('1000', 'email', __('The email is required and must contain a value'));
            }

            if (empty($param['password_old'])) {
                static::errorOther('1000', 'password_old', __('The password_old is required and must contain a value'));
            }

            if (!empty(\Model_Abstract::$error_code_validation)) {
                return false;
            }

            $options['where']['password'] = Util::encodePassword($param['password_old'], $param['email']);
        }

        $user = self::find('first', $options);
        if (empty($user)) {
            static::errorOther('1021', 'password', __('Password not match. Please try again'));
            return false;
        } else {
            $user->set('password', Util::encodePassword($param['password'], $user['email']));
            if ($user->update()) {
                return true;
            }
        }
        return false;
    }

    /**
     * Update password by token.
     *
     * @author Le Tuan Tu
     * @param array $param Input data.
     * @return bool Returns the boolean.
     */
    public static function update_password($param)
    {
        // KienNH 2016/04/20 check valid token
        $check = Model_User_Activation::check_token($param);
        if (!$check) {
            return false;
        }
        // KienNH end
        
        $query = DB::select(
                array('user_activations.email', 'activation_email'), 
                array('user_activations.token', 'token'), 
                array('user_activations.regist_type', 'regist_type'), 
                array('user_activations.disable', 'activation_disable'), 
                array('user_activations.id', 'activation_id'), 
                array('user_activations.disable', 'activation_disable'), 
                self::$_table_name . '.*'
            )
            ->from('user_activations')
            ->join(self::$_table_name, 'LEFT')
            ->on('user_activations.email', '=', self::$_table_name . '.email')
            ->where('user_activations.token', '=', $param['token'])
            ->where('user_activations.regist_type', '=', $param['regist_type']);
        $data = $query->execute()->offsetGet(0);
        if (empty($data)) {
            self::errorNotExist('token');
            return false;
        }
        if (!empty($data['activation_disable']) && $data['activation_disable'] == '1') {
            self::errorOther(self::ERROR_CODE_OTHER_1, 'token', 'Token has already been used');
            return false;
        }        
        $user = self::find($data['id']);
        if ($user) {
            $user->set('password', Util::encodePassword($param['password'], $user->get('email')));
            if ($user->update()) {
                if (!\Model_User_Activation::disable(array(
                    'id' => $data['activation_id'],
                    'disable' => '1'
                ))
                ) {
                    \LogLib::warning('Can not update user_activations', __METHOD__, $param);
                    return false;
                }
                return self::get_login(array(
                    'email' => $user->get('email'),
                    'password' => $param['password']
                ));               
            }
        }               
        return false;
    }

    // /**
    //  * Update password by token.
    //  *
    //  * @author truongnn
    //  * @param array $param Input data.
    //  * @return int Returns 1 If exsit user, 0 otherwise .
    //  */
    // public static function check_password($param)
    // {
    //     $options['where'] = array(
    //         'email'    => $param['email'],
    //         'password' => Util::encodePassword($param['password'], $param['email'])
    //     );
    //     return !empty(Model_User::find('first', $options)) ? 1 : 0;
    // }

    /**
     * Cancel user.
     *
     * @author truongnn
     * @param array $param Input data.
     * @return bool Returns True if update successfully or false if otherwise.
     */
    public static function quit($param)
    {
        $user = self::find($param['login_user_id']);
        if (empty($user)) {
            self::errorNotExist('user_id');
            return false;
        }
        $param['email'] = $user->get('email');
        $param['name'] = $user->get('name');

        $user->set('email', md5($user->get('email')) . date('Ymd') . '@fastnail.town');
        $user->set('disable_by_user', 1);
        $user->set('disable', 1);
        $user->set('code', '');
        $user->set('password', '');
        $user->set('name', '');
        $user->set('kana', '');
        $user->set('phone', '');
        $user->set('birthday', null);
        $user->set('address1', '');
        $user->set('address2', '');
        $user->set('sex', 0);
        $user->set('visit_element', 0);
        $user->set('is_magazine', 0);
        $user->set('prefecture_id', 0);
        if ($user->update()) {
            // Sending email if cancel user successfully.
            if (!\Lib\Email::sendUserQuitEmail($param)) {
                \LogLib::warning('Can not resend cancel user email', __METHOD__);
                return false;
            }
        }
        return true;
    }

    /**
     * Register user by mobile
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return int|bool User id or false if error
     */
    public static function register_by_mobile($param)
    { 
        $user = self::find('first', array(
            'where' => array(
                'email' => $param['email']
            )
        ));
        if (!empty($user)) {
            \LogLib::info('Duplicate email', __METHOD__, $param);
            self::errorDuplicate('email', $param['email']);
            return false;
        }        
        // create user_id
        $user_guest = new Model_User_Guest_Id;
        $userId = $user_guest->add($param);
        if (self::error()) {
            return false;
        }
        $user = new self;
        $user->set('id', $userId);
        $user->set('email', $param['email']);
        if (isset($param['encode_password']) && $param['encode_password'] === true) {
            $user->set('password', Util::encodePassword($param['password'], $param['email']));
        } else {
            $user->set('password', $param['password']);
        }
        if (empty($param['sex_id'])) {
            $param['sex_id'] = 0;
        }
        if (empty($param['user_physical_type_id'])) {
            $param['user_physical_type_id'] = 0;
        }
        if (isset($param['name']) && $param['name'] !== '') {
            $user->set('name', $param['name']);
        }
        if (!empty($param['birthday'])) {
            $user->set('birthday', self::time_to_val($param['birthday']));
        }
        if (isset($param['zipcode'])) {
            $user->set('zipcode', $param['zipcode']);
        }
        if (isset($param['image_path'])) {
            $user->set('image_path', $param['image_path']);
        }
        $user->set('sex_id', $param['sex_id']);
        $user->set('user_physical_type_id', $param['user_physical_type_id']);
        $user->set('count_follow', 0);
        $user->set('count_follower', 0);
        $user->set('disable_by_user', 0);
        $user->set('is_ios', 0);
        $user->set('is_android', 0);
        $user->set('is_web', 0);
        switch ($param['os']) {
            case \Config::get('os')['ios']:
                $user->set('is_ios', 1);
                break;
            case \Config::get('os')['android']:
                $user->set('is_android', 1);
                break;
            default:
                $user->set('is_web', 1);
        }
        // save to database
        if ($user->save()) {
            if (empty($user->id)) {
                $user->id = self::cached_object($user)->_original['id'];
                $user->email = self::cached_object($user)->_original['email'];
                $user->name = self::cached_object($user)->_original['name'];
            }
            // send email
            if (!\Lib\Email::sendRegisterActiveEmail(array(
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'email' => $user->email,
                    'language_type' => !empty($param['language_type']) ? $param['language_type'] : 1
                ))
            ) {
                \LogLib::warning('Can not send register email', __METHOD__, $param);
            }
            return self::get_login(
                array(
                    'email' => $user->get('email'),
                    'password' => $param['password']
                ), 
                true
            );
        }
        return false;
    }

    /**
     * Search info user
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array List User's info
     */
    public static function search_info($param)
    {
        if (!empty($param['phone'])) {
            $param['phone'] = str_replace('-', '', $param['phone']);
        }
        if (empty($param['page'])) {
            $param['page'] = 1;
        }
        $query = DB::select(
            'name', 'phone', 'email'
        )
            ->from(self::$_table_name)
            ->where('disable', '=', '0')
            ->where(DB::expr("
                IFNULL(disable_by_user, 0) = 0
            "));
        // filter by keyword
        if (isset($param['name']) && $param['name'] !== '') {
            $query->where('name', 'like', "%{$param['name']}%");
        }
        if (isset($param['phone']) && $param['phone'] !== '') {
            $query->where('phone_search', 'like', "%{$param['phone']}%");
        }
        if (isset($param['email']) && $param['email'] !== '') {
            $query->where('email', 'like', "%{$param['email']}%");
        }
        if (!empty($param['sort'])) {
            // KienNH 2016/04/20 check valid sort
            if (!self::checkSort($param['sort'])) {
                self::errorParamInvalid('sort');
                return false;
            }
            
            $sortExplode = explode('-', $param['sort']);
            $query->order_by(self::$_table_name . '.' . $sortExplode[0], $sortExplode[1]);
        } else {
            $query->order_by(self::$_table_name . '.created', 'DESC');
        }
        if (!empty($param['page']) && !empty($param['limit'])) {
            $offset = ($param['page'] - 1) * $param['limit'];
            $query->limit($param['limit'])->offset($offset);
        }
        // get data
        $data = $query->execute(self::$slave_db)->as_array();
        $total = !empty($data) ? DB::count_last_query(self::$slave_db) : 0;
        return array($total, $data);
    }

    /**
     * Check email
     *
     * @author truongnn
     * @param array $param Input data.
     * @return int Returns 1 If exist user, 0 otherwise .
     */
    public static function check_email($param)
    {
        $options['where'] = array(
            'email' => $param['email']
        );
        return !empty(Model_User::find('first', $options)) ? 1 : 0;
    }

    /**
     * Get profile User
     *
     * @author Caolp
     * @param array $param Input data
     * @return array|bool Detail User or false if error
     */
    public static function get_profile($param)
    {
        if (empty($param['login_user_id'])) {
            $param['login_user_id'] = 0;
        }
        $user = DB::select(
                array('users.id', 'id'),
                array('users.app_id', 'app_id'),
                array('users.name', 'name'),
                array('users.sex_id', 'sex_id'),
                array('users.email', 'email'),
                array('users.birthday', 'birthday'),
                array('users.zipcode', 'zipcode'),
                array('users.user_physical_type_id', 'user_physical_type_id'),
                array('users.is_smoker', 'is_smoker'),
                array('users.is_ios', 'is_ios'),
                array('users.is_android', 'is_android'),
                array('users.is_web', 'is_web'),
                array('users.team_id', 'team_id'),
                DB::expr("teams.name as team_name"),
                DB::expr("IFNULL(IF(image_path='',NULL,image_path),'" . \Config::get('no_image_user') . "') AS image_path"),
                DB::expr("IFNULL(IF(cover_image_path='',NULL,cover_image_path),'" . \Config::get('no_image_cover') . "') AS cover_image_path"),
                array('users.count_follow', 'count_follow'),
                array('users.count_follower', 'count_follower'),
                array('users.memo', 'memo'),
                DB::expr("IF(ISNULL(follow_users.id),0,1) AS is_follow_user"),
                array('users.point_total', 'point_total'),
                array('users.point_get_total', 'point_get_total'),
                array('users.point_pay_total', 'point_pay_total')
            )
            ->from(self::$_table_name)
            ->join('teams', 'LEFT')
            ->on('teams.id', '=', self::$_table_name . '.team_id')
            ->join(DB::expr("
                (SELECT *
                FROM follow_users
                WHERE user_id = {$param['login_user_id']}
                    AND disable = 0) follow_users
            "), 'LEFT')
            ->on(self::$_table_name . '.id', '=', 'follow_users.follow_user_id')
            ->where(self::$_table_name . '.disable', '=', '0')
            ->where(self::$_table_name . '.id', '=', $param['user_id'])
            ->execute(self::$slave_db)
            ->offsetGet(0);        
        if (empty($user)) {
            static::errorNotExist('user_id', $param['user_id']);
            return false;
        }      
        if (!empty($param['get_place_pins'])) {           
            $user['place_pins'] = Model_Place_Pin::get_for_profile($param);
        }
        if (!empty($param['get_place_reviews'])) {       
            $user['place_reviews'] = Model_Place::get_for_profile($param); 
        }
        if (!empty($param['get_place_images'])) { 
            $user['place_images'] = Model_Place_Image::get_for_profile($param);                       
        }
        return $user;
    }
    
    /**
     * Get recommend
     *
     * @author Caolp
     * @param array $param Input data
     * @return array User's recommend
     */
    public static function get_recommend($param)
    {
        if (empty($param['login_user_id'])) {
            $param['login_user_id'] = 0;
        }
        $minReview = 1;
        $imageLimit = 5;
        $data = DB::select(
                self::$_table_name.'.id',
                self::$_table_name.'.app_id',
                self::$_table_name.'.name',
                self::$_table_name.'.sex_id',
                self::$_table_name.'.zipcode',                                
                self::$_table_name.'.team_id',                               
                self::$_table_name.'.count_follow',
                self::$_table_name.'.count_follower',
                self::$_table_name.'.user_physical_type_id',               
                DB::expr("IF(ISNULL(user_physicals.name),'',user_physicals.name) AS user_physical_type_name"),
                DB::expr("IF(ISNULL(follow_users.id),0,1) AS is_follow_user"),
                DB::expr("IFNULL(IF(image_path='',NULL,image_path),'" . \Config::get('no_image_user') . "') AS image_path"),
                DB::expr("IFNULL(IF(cover_image_path='',NULL,cover_image_path),'" . \Config::get('no_image_cover') . "') AS cover_image_path"),
                self::$_table_name.'.point_total',
                self::$_table_name.'.point_get_total',
                self::$_table_name.'.point_pay_total'
            )
            ->from(self::$_table_name)
            ->join(DB::expr("
                (SELECT *
                FROM user_physicals
                WHERE language_type = {$param['language_type']}
                    AND disable = 0) user_physicals
            "), 'LEFT')            
            ->on(self::$_table_name.'.user_physical_type_id', '=', 'user_physicals.type_id')
            ->join(DB::expr("
                (SELECT *
                FROM follow_users
                WHERE user_id = {$param['login_user_id']}
                    AND disable = 0) follow_users
            "), 'LEFT')
            ->on(self::$_table_name . '.id', '=', 'follow_users.follow_user_id')
            ->join(DB::expr("
                (
                    SELECT user_id, count(*) AS total_review
                    FROM place_reviews
                    WHERE disable = 0
                    GROUP BY user_id
                    HAVING count(*) >= {$minReview}
                ) place_reviews_total
            "), 'LEFT')
            ->on(self::$_table_name . '.id', '=', 'place_reviews_total.user_id')
            ->where(self::$_table_name.'.disable', '=', '0')
            ->where(self::$_table_name.'.id', '<>', $param['login_user_id'])
            ->where('place_reviews_total.total_review', '>=', $minReview)
            ->order_by('place_reviews_total.total_review', 'DESC')
            ->limit(20)->offset(0)
            ->execute(self::$slave_db)
            ->as_array();
        if (!empty($data)) {
            $userId = Lib\Arr::field($data, 'id');            
            // get place's images
            if (!empty($param['get_place_images'])) {
                $images = Model_Place_Image::get_all(
                    array (
                        'user_id' => $userId,
                        'disable' => 0
                    )
                );
                foreach ($data as &$row) {                
                    $row['place_images'] = Lib\Arr::filter($images, 'user_id', $row['id'], false, false);
                    if (count($row['place_images']) > $imageLimit) {
                        $row['place_images'] = array_slice($row['place_images'], 0, $imageLimit);
                    }               
                }
                unset($row);
            }
        }
        return $data;
    }
    
    /**
     * Update team
     *
     * @author Thai Lai
     * @param array $param Input data
     * @return int|bool User id or false if error
     */
    public static function update_team($param)
    {
        // update team
        if (!empty($param['name']) && empty($param['team_id']) && empty($param['section_id'])) {
            $team = Model_Team::find('first', array(
                'where' => array(
                    'name' => $param['name']
                )
            ));
            if (empty($team)) {
                self::errorNotExist('name');
                return false;
            }
            $param['team_id'] = $team->get('id');
        }
        if (empty($param['team_id']) && empty($param['name'])) {
            self::errorParamInvalid('team_id_or_name');
            return false; 
        }
        $user = Model_User::find($param['login_user_id']);
        // create new team when not found
        if (empty($param['team_id'])) {                  
            if (empty($param['name']) || empty($param['section_id'])) { // requied name and section_id
                self::errorParamInvalid('name_or_section_id');
                return false; 
            }
            $param['team_id'] = Model_Team::add_update(array(
                'login_user_id' => $param['login_user_id'],
                'name' => $param['name'],
                'section_id' => $param['section_id'],
                'language_type' => $param['language_type'],
            ));
            if (self::error()) {
                return false;
            }
        }
        if (empty($param['team_id'])) {
            self::errorNotExist('team_id');
            return false;
        }
        if (!empty($user->get('team_id')) 
            && $user->get('team_id') == $param['team_id']) {
            self::errorDuplicate('team_id');
            return false;
        }
        // leave team and join to new team, move point to new team            
        $newTeam = Model_Team::find($param['team_id']);
        if (empty($newTeam)) {
            self::errorNotExist('team_id');
            return false;
        }
        if (!empty($user->get('team_id'))) {
            $oldTeam = Model_Team::find($user->get('team_id'));            
        }
        $user_points = Model_User_Point::find('all', array(
            'where' => array(
                'user_id' => $param['login_user_id'],
                'disable' => '0'
            )
        ));
        if (!empty($user_points)) {
            // update team_id and calculate total point
            $totalPoint = 0;
            foreach ($user_points as $user_point) {
                $user_point->set('team_id', $param['team_id']);
                if ($user_point->save()) {
                    $totalPoint += $user_point->get('point');
                }
            }
            if ($totalPoint > 0) {   
                // add point for new team
                $newTeam->set('point', $newTeam->get('point') + $totalPoint);
                $newTeam->save();
                // substract point for old team  
                if (!empty($oldTeam)) {
                    if ($oldTeam->get('point') - $totalPoint > 0) {
                        $point = $oldTeam->get('point') - $totalPoint;
                    } else {
                        $point = 0;
                    }
                    $oldTeam->set('point', $point);
                    $oldTeam->save();
                }
            }
        }
        // change team
        $user->set('team_id', $param['team_id']);
        $user->save();  
        return $param['team_id'];      
    }

    /**
     * Check login failed
     *
     * @author AnhMH
     * @return int|bool 0 limit, 1 no limit or false if error
     */
    public static function check_login_failed()
    {
        $ipAddress = \Lib\Ip4filter::getClientIp();
        // get login failed info by ip_address
        $loginFailed = Model_Loginfail::find('first', array(
            'where' => array(
                'ip_address' => $ipAddress
            )
        ));
        if (empty($loginFailed)) {
            return 1;
        }
        $loginFailedReset = Config::get('api_loginfailed_reset');
        $updated = $loginFailed->get('updated');
        $hourFailedUpdated = date('H', $updated);
        $hourNow = date('H');
        // check reset counter
        if ($hourNow != $hourFailedUpdated || time() - $updated > $loginFailedReset*60) {
            return 1;
        }
        $count = $loginFailed->get('count');
        $loginFailedLimt = Config::get('api_loginfailed_limit');
        // check login failed limit
        if ($count < $loginFailedLimt) {
            return 1;
        }
        return 0;
    }

    /**
     * Update login failed
     *
     * @author AnhMH
     * @return int/bool count or false if error
     */
    public static function update_login_failed($ipAddress, $loginFailed)
    {
        if (empty($loginFailed)) {
            // add new
            if(Model_Loginfail::add($ipAddress)) {
                return 1;
            }
            return false;
        }
        // update
        $loginFailedUpdated = $loginFailed->get('updated');
        $hourFailedUpdated = date('H', $loginFailedUpdated);
        $hourNow = date('H');
        $loginFailedReset = Config::get('api_loginfailed_reset');
        // check reset counter
        if ($hourNow != $hourFailedUpdated || time() - $loginFailedUpdated > $loginFailedReset*60) {
            $count = 1;
        } else {
            $count = $loginFailed->get('count') + 1;
        }
        $loginFailed->set('count', $count);
        $loginFailed->set('updated', strtotime(date('Y-m-d H:i:s')));
        $loginFailed->save();
        return $count;
    }
}
