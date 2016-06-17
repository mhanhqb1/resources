<?php

/**
 * Any query in Model Follow User
 *
 * @package Model
 * @created 2015-06-26
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Model_Follow_User extends Model_Abstract
{
    /** @var array $_properties field of table */
    protected static $_properties = array(
        'id',
        'user_id',
        'follow_user_id',
        'created',
        'updated',
        'disable'
    );

    protected static $_observers = array(
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
    protected static $_table_name = 'follow_users';

    /**
     * Add info for Follow User
     *
     * @author Le Tuan Tu
     * @param array $param Input data.
     * @return int|bool Follow User id or false if error
     *
     */
    public static function add($param)
    {
        if ($param['login_user_id'] == $param['follow_user_id']) {
            static::errorParamInvalid('follow_user_id');
            return false;
        }
        $query = DB::select(
            array('users.id', 'follow_user_id'),
            array('follow_users.id', 'follow_id'),
            array('follow_users.user_id', 'login_user_id'),
            array('follow_users.disable', 'follow_disable')
        )
            ->from('users')
            ->join(
                DB::expr(
                    "(SELECT * FROM follow_users
                     WHERE user_id = {$param['login_user_id']}) AS follow_users"
                ),
                'LEFT'
            )
            ->on('users.id', '=', 'follow_users.follow_user_id')
            ->where('users.id', '=', $param['follow_user_id'])
            ->where('users.disable', '=', '0');
        $data = $query->execute()->offsetGet(0);
        if (empty($data['follow_user_id'])) {
            static::errorNotExist('follow_user_id');
            return false;
        }
        if (!empty($data['login_user_id']) && $data['follow_disable'] == 0) {
            static::errorDuplicate('login_user_id');
            return false;
        }
        $new = false;
        if (!empty($data['login_user_id']) && $data['follow_disable'] == 1) {
            $dataUpdate = array(
                'id'      => $data['follow_id'],
                'disable' => '0'
            );
        } else {
            $new = true;
            $dataUpdate = array(
                'user_id'        => $param['login_user_id'],
                'follow_user_id' => $data['follow_user_id']
            );
        }
        $favorite = new self($dataUpdate, $new);
        if ($favorite->save()) {
            if ($new == true) {
                $favorite->id = self::cached_object($favorite)->_original['id'];
            }
            // New follow, send message to device
            // KienNH, 2015/12/18: Add push message
            if ($favorite->get('disable') == 0) {
                $favorite->set('follow_user_id', $param['follow_user_id']);
                Model_Notice::add_push_message($favorite, $param);
            }
            // KienNH, end
            return $favorite->id;
        }
        return false;
    }

    /**
     * Get list Follow User (using array count)
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array List Follow User
     */
    public static function get_list($param)
    {
        $sql = "
            SELECT F.id,
                   A.id AS login_user_id,
                   A.name AS login_user_name,
                   B.id AS follow_user_id,
                   B.name AS follow_user_name
            FROM follow_users F,
                 users A,
                 users B
            WHERE F.user_id = A.id
                AND F.follow_user_id = B.id
                AND A.disable = 0
                AND B.disable = 0
        ";
        if (!empty($param['follow_user_id'])) {
            $sql .= "
                AND F.follow_user_id = {$param['follow_user_id']}
            ";
        }
        if (!empty($param['login_user_id'])) {
            $sql .= "
                AND F.user_id = {$param['login_user_id']}
            ";
        }
        if (isset($param['disable']) && $param['disable'] != '') {
            $sql .= "
                AND F.disable = {$param['disable']}
            ";
        }
        if (!empty($param['sort'])) {
            // KienNH 2016/04/20 check valid sort
            if(!self::checkSort($param['sort'])) {
                self::errorParamInvalid('sort');
                return false;
            }
            
            $sortExplode = explode('-', $param['sort']);
            $sql .= "
                AND F.disable = {$param['disable']}
                ORDER BY F.{$sortExplode[0]} {$sortExplode[1]}
            ";
        } else {
            $sql .= "
                ORDER BY F.updated DESC
            ";
        }
        if (!empty($param['page']) && !empty($param['limit'])) {
            $offset = ($param['page'] - 1) * $param['limit'];
            $sql .= "
                LIMIT {$offset}, {$param['limit']}
            ";
        }
        // get data
        $data = DB::query($sql)->execute(self::$slave_db)->as_array();
        $total = !empty($data) ? DB::count_last_query(self::$slave_db) : 0;
        return array('total' => $total, 'data' => $data);
    }

    /**
     * Disable/Enable a Follow User
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return bool Success or otherwise
     */
    public static function disable($param)
    {
        if (!isset($param['disable'])) {
            $param['disable'] = '1';
        }
        if (!empty($param['id'])) {
            $options['where'] = array(
                'id' => $param['id'],
            );
        } else {
            $options['where'] = array(
                'follow_user_id' => $param['follow_user_id'],
                'user_id'        => $param['login_user_id'],
                'disable'        => '0'
            );
        }
        $data = self::find('first', $options);
        if ($data) {
            $data->set('disable', $param['disable']);
            if ($data->update()) {
                $param['follow_user_id'] = $data->_data['follow_user_id'];
                $param['user_id'] = $data->_data['user_id'];
                return true;
            }
        } else {
            if (!empty($param['id'])) {
                static::errorNotExist('id');
            } else {
                static::errorNotExist('user_id');
            }
        }
        return false;
    }
    
    /**
     * Get all user following
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array List User
     */
    public static function get_all($param)
    {
        $query = DB::select(
                    'users.id',
                    'users.name',                            
                    DB::expr("IFNULL(IF(usersimage_path='',NULL,image_path),'" . \Config::get('no_image_user') . "') AS image_path"),
                    DB::expr("IFNULL(IF(cover_image_path='',NULL,cover_image_path),'" . \Config::get('no_image_cover') . "') AS cover_image_path"),
                    'count_follow',
                    'count_follower',
                    'memo',
                    self::$_table_name . '.user_id'
                )
                ->from(self::$_table_name)
                ->join('users')
                ->on(self::$_table_name. '.follow_user_id', '=', 'users.id')
                ->where('users.disable', '0')
                ->where(self::$_table_name . '.disable', '0');
        if (!empty($param['user_id'])) {
            if (!is_array($param['user_id'])) {
                $param['user_id'] = array($param['user_id']);
            }
            $query->where(self::$_table_name . '.user_id', 'IN', $param['user_id']); 
        }
        $data = $query->execute(self::$slave_db)->as_array();
        return $data;
    }
    
    /**
     * Get list Follow User (using array count)
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array List Follow User
     */
    public static function get_list_ifollow($param)
    {
        if (empty($param['login_user_id'])) {
            $param['login_user_id'] = 0;
        }
        $query = DB::select(
                'users.id',
                'users.name',                            
                DB::expr("IFNULL(IF(image_path='',NULL,image_path),'" . \Config::get('no_image_user') . "') AS image_path"),
                DB::expr("IFNULL(IF(cover_image_path='',NULL,cover_image_path),'" . \Config::get('no_image_cover') . "') AS cover_image_path"),
                'count_follow',
                'count_follower',
                'memo',
                'users.user_physical_type_id',               
                DB::expr("IF(ISNULL(user_physicals.name),'',user_physicals.name) AS user_physical_type_name"),
                DB::expr("IF(ISNULL(login_follow_users.id),0,1) AS is_follow_user")
            )
            ->from(self::$_table_name)
            ->join('users')
            ->on(self::$_table_name. '.follow_user_id', '=', 'users.id')
            ->join(DB::expr("
                    (SELECT *
                    FROM user_physicals
                    WHERE language_type = {$param['language_type']}
                        AND disable = 0) user_physicals
                "), 'LEFT') 
            ->on('users.user_physical_type_id', '=', 'user_physicals.type_id')
            ->join(DB::expr("
                (SELECT *
                FROM follow_users
                WHERE follow_users.user_id = {$param['login_user_id']}
                    AND follow_users.disable = 0) login_follow_users
                "), 'LEFT')
            ->on('users.id', '=', 'login_follow_users.follow_user_id')
            ->where('users.disable', '0')
            ->where(self::$_table_name . '.disable', '0')
            ->where(self::$_table_name . '.user_id', $param['user_id']);      
        if (!empty($param['page']) && !empty($param['limit'])) {
            $offset = ($param['page'] - 1) * $param['limit'];
            $query->limit($param['limit'])->offset($offset);
        }
        $data = $query->execute(self::$slave_db)->as_array();
        $total = !empty($data) ? DB::count_last_query(self::$slave_db) : 0;       
        return array('total' => $total, 'data' => $data);
    }
    
    /**
     * Get list Follow User (using array count)
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array List Follow User
     */
    public static function get_list_followme($param)
    {
        $query = DB::select(
                'users.id',
                'users.name',                            
                DB::expr("IFNULL(IF(image_path='',NULL,image_path),'" . \Config::get('no_image_user') . "') AS image_path"),
                DB::expr("IFNULL(IF(cover_image_path='',NULL,cover_image_path),'" . \Config::get('no_image_cover') . "') AS cover_image_path"),
                'count_follow',
                'count_follower',
                'memo',
                'users.user_physical_type_id',             
                DB::expr("IF(ISNULL(user_physicals.name),'',user_physicals.name) AS user_physical_type_name"),
                DB::expr("IF(ISNULL(login_follow_users.id),0,1) AS is_follow_user")
            )
            ->from(self::$_table_name)
            ->join('users')
            ->on(self::$_table_name. '.user_id', '=', 'users.id')
            ->join(DB::expr("
                    (SELECT *
                    FROM user_physicals
                    WHERE language_type = {$param['language_type']}
                        AND disable = 0) user_physicals
                "), 'LEFT') 
            ->on('users.user_physical_type_id', '=', 'user_physicals.type_id')
            ->join(DB::expr("
                (SELECT *
                FROM follow_users
                WHERE user_id = {$param['login_user_id']}
                    AND disable = 0) login_follow_users
                "), 'LEFT')
            ->on('users.id', '=', 'login_follow_users.follow_user_id')
            ->where('users.disable', '0')
            ->where(self::$_table_name . '.disable', '0')
            ->where(self::$_table_name . '.follow_user_id', $param['user_id']);      
        if (!empty($param['page']) && !empty($param['limit'])) {
            $offset = ($param['page'] - 1) * $param['limit'];
            $query->limit($param['limit'])->offset($offset);
        }
        $data = $query->execute(self::$slave_db)->as_array();
        $total = !empty($data) ? DB::count_last_query(self::$slave_db) : 0;       
        return array('total' => $total, 'data' => $data);
    }
    
}