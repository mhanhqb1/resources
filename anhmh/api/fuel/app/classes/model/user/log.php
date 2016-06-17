<?php

class Model_User_Log extends Model_Abstract {

    protected static $_properties = array(
        'id',
        'user_id',
        'nailist_id',
        'memo',
        'created',
        'updated',
        'disable',
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
    protected static $_table_name = 'user_logs';

    /**
     * Add and update info of user_log.
     *
     * @author truongnn
     * @param array $param Input data.
     * @return bool|int Returns the boolean or the integer.
     */
    public static function add_update($param) {        
        $id = !empty($param['id']) ? $param['id'] : 0;
        $user_log = new self;
        if (!empty($id)) {
            $user_log = self::find($id);
            if (empty($user_log)) {
                static::errorNotExist('user_log_id', $id);
                return false;
            }
        }
        if (!empty($param['memo'])) {
            $user_log->set('memo', $param['memo']);
        }
        if (isset($param['user_id'])) {
            $user_log->set('user_id', $param['user_id']);
        }
        if (!empty($param['nailist_id'])) {
            $user_log->set('nailist_id', $param['nailist_id']);
        }
        if ($user_log->save()) {
            if (empty($user_log->id)) {
                $user_log->id = self::cached_object($user_log)->_original['id'];
            }
            return !empty($user_log->id) ? $user_log->id : 0;
        }
        return false;
    }

    /**
     * Get detail user_log.
     *
     * @author truongnn
     * @param array $param Input data.
     * @return array|bool Detail  or false if error.
     */
    public static function get_detail($param) {
        $query = DB::select(self::$_table_name . '.*', array('users.name', 'user_name'), array('nailists.name', 'nailist_name')
                )
                ->from(self::$_table_name)
                ->join('users', 'LEFT')
                ->on(self::$_table_name . '.user_id', '=', 'users.id')
                ->join('nailists', 'LEFT')
                ->on(self::$_table_name . '.nailist_id', '=', 'nailists.id')
                ->where(self::$_table_name . '.id', $param['id'])
                ->where(self::$_table_name . '.disable', '0');
        $data = $query->execute(self::$slave_db)->as_array();
        
        if (empty($data)) {
            static::errorNotExist('user_log_id');
            return false;
        }
        return $data;
    }

    /**
     * Disable/enable user_log.
     *
     * @author truongnn
     * @param array $param Input data.
     * @return bool Returns the boolean.
     */
    public static function disable($param) {
        $ids = explode(',', $param['id']);
        foreach ($ids as $id) {
            $user_log = self::find($id);
            if ($user_log) {
                $user_log->set('disable', $param['disable']);
                if (!$user_log->update()) {
                    return false;
                }
            } else {
                static::errorNotExist('user_log_id', $id);
                return false;
            }
        }

        return true;
    }

    /**
     * Get all user_log.
     *
     * @author truongnn
     * @param array $param Input data.
     * @return array Returns the array.
     */
    public static function get_all($param) {
        $query = DB::select(self::$_table_name . '.*', array('users.name', 'user_name'), array('nailists.name', 'nailist_name')
                )
                ->from(self::$_table_name)
                ->join('users', 'LEFT')
                ->on(self::$_table_name . '.user_id', '=', 'users.id')
                ->join('nailists', 'LEFT')
                ->on(self::$_table_name . '.nailist_id', '=', 'nailists.id')
                ->where(self::$_table_name . '.disable', '0');
        $data = $query->execute(self::$slave_db)->as_array();
        return $data;
    }

    /**
     * Get list user_logs.
     *
     * @author truongnn
     * @param array $param Input data.
     * @return array Returns array(total, data).
     */
    public static function get_list($param) {
        if (!empty($param['order_id'])) {
            $order = Model_Order::find($param['order_id']);
            if (empty($order)) {
                return false;
            }
            $param['user_id'] = $order->get('user_id');
            if (empty($param['user_id'])) {
                static::errorNotExist('user_id');
                return false;
            }
        }
        $query = DB::select(self::$_table_name . '.*', 
            array('users.name', 'user_name'), 
            array('nailists.name', 'nailist_name'),
            DB::expr("IFNULL(IF(nailists.image_url='',NULL,nailists.image_url), '" . \Config::get('no_image_nailist') . "') AS nailist_image"),
            array('shops.name', 'shop_name')
                )
                ->from(self::$_table_name)
                ->join('users', 'LEFT')
                ->on(self::$_table_name . '.user_id', '=', 'users.id')
                ->join('nailists', 'LEFT')
                ->on(self::$_table_name . '.nailist_id', '=', 'nailists.id')
                ->join('shops', 'LEFT')
                ->on( 'nailists.shop_id', '=', 'shops.id');
        if (!empty($param['user_id'])) {
            $query->where('users.id', 'LIKE', "%{$param['user_id']}%");
        }
        if (!empty($param['user_name'])) {
            $query->where('users.name', 'LIKE', "%{$param['user_name']}%");
        }
        if (isset($param['disable']) && $param['disable'] != '') {
            $query->where(self::$_table_name . '.disable', '=', $param['disable']);
        }
        if (!empty($param['sort'])) {
            // KienNH 2016/04/20 check valid sort
            if (!self::checkSort($param['sort'])) {
                self::errorParamInvalid('sort');
                return false;
            }
            
            $sortExplode = explode('-', $param['sort']);
            $query->order_by($sortExplode[0], $sortExplode[1]);
        } else {
            $query->order_by(self::$_table_name . '.created', 'DESC');
        }
        if (empty($param['page'])) {
            $param['page'] = 1;
        }
        if (!empty($param['page']) && !empty($param['limit'])) {
            $offset = ($param['page'] - 1) * $param['limit'];
            $query->limit($param['limit'])->offset($offset);
        }
        $data = $query->execute(self::$slave_db)->as_array();
        $total = !empty($data) ? DB::count_last_query(self::$slave_db) : 0;

        return array($total, $data);
    }

}
