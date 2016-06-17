<?php

/**
 * Any query in Model User Point Log
 *
 * @package Model
 * @created 2015-03-23
 * @version 1.0
 * @author KienNH
 * @copyright Oceanize INC
 */
class Model_User_Point_Log extends Model_Abstract {
    
    /** @var array $_properties field of table */
    protected static $_properties = array(
        'id',
        'user_id',
        'point_item_id',
        'point_get_id',
        'place_id',
        'type',
        'point',
        'expire_date',
        'user_bought_item_id',
        'is_paid',
        'return_id',
        'is_displayed',
        'created'
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
    protected static $_table_name = 'user_point_logs';
    
    /**
     * Add info for User Point Log
     *
     * @author KienNH
     * @param array $param Input data
     * @return int|bool User Point Log id or false if error
     */
    public static function add($param) {
        // Check param
        $user = Model_User::find($param['user_id']);
        if (empty($user)) {
            self::errorNotExist('user_id');
            return false;
        }
        if (empty($param['point']) || empty($param['type'])) {
            self::errorParamInvalid('point');
            return false;
        }
        if (!isset($param['point_get_id'])) {
            $param['point_get_id'] = 0;
        }
        if (!isset($param['point_item_id'])) {
            $param['point_item_id'] = 0;
        }
        if (!isset($param['user_bought_item_id'])) {
            $param['user_bought_item_id'] = 0;
        }
        if (!isset($param['is_paid'])) {
            $param['is_paid'] = 0;
        }
        if (!isset($param['return_id'])) {
            $param['return_id'] = 0;
        }
        
        // Create data
        $log = new self;
        $log->set('user_id', $param['user_id']);        
        $log->set('point', $param['point']);
        $log->set('type', $param['type']);        
        if (isset($param['point_get_id'])) {
            $log->set('point_get_id', $param['point_get_id']);
        }
        if (isset($param['point_item_id'])) {
            $log->set('point_item_id', $param['point_item_id']);
        }
        if (isset($param['is_paid'])) {
            $log->set('is_paid', $param['is_paid']);
        }
        if (isset($param['return_id'])) {
            $log->set('return_id', $param['return_id']);
        }
        if (isset($param['user_bought_item_id'])) {
            $log->set('user_bought_item_id', $param['user_bought_item_id']);
        }
        if (isset($param['place_id'])) {
            $log->set('place_id', $param['place_id']);
        }
        $log->set('is_displayed', !empty($param['is_displayed']) ? 1 : 0);
        
        if ($log->create()) {
            // Update user point
            $userCurrentGetPoint = !empty($user->get('point_get_total')) ? $user->get('point_get_total') : 0;
            $user->set('point_get_total', $userCurrentGetPoint + $param['point']);
            $user->save();
            
            if (isset($param['get_point'])) {
                return $user->get('point_get_total');
            }
            return !empty($log->id) ? $log->id : 0;
        }
        
        return false;
    }
    
    /**
     * Get Coin's History of User
     * 
     * @return array
     */
    public static function get_history($param) {
        $language_type = !empty($param['language_type']) ? $param['language_type'] : 1;
        
        // Get Current user ranking
        $user_id = !empty($param['user_id']) ? $param['user_id'] : 0;
        $user = Model_User_Point_Get_Total_Ranking::get_current_user_ranking($user_id);
        
        // Point getted
        $param['page'] = !empty($param['page']) ? $param['page'] : Config::get('page_default', 1);
        $param['limit'] = !empty($param['limit']) ? $param['limit'] : Config::get('limit_default', 10);
        $offset = ($param['page'] - 1) * $param['limit'];
        
        $query = DB::select(
                    self::$_table_name . '.*',
                    array('place_informations.name', 'place_name')
                )
                ->from(self::$_table_name)
                ->join('place_informations', 'left')
                ->on(self::$_table_name . '.place_id', '=' , 'place_informations.place_id')
                ->where(self::$_table_name . '.user_id', '=', $user_id)
                ->group_by(self::$_table_name . '.id')
                ->order_by(self::$_table_name . '.created', 'DESC')
                ->limit($param['limit'])->offset($offset);
        
        $data = $query->execute(self::$slave_db)->as_array();
        $totalGet = !empty($data) ? DB::count_last_query(self::$slave_db) : 0;
        
        $getCoin = array();
        if (!empty($data)) {
            foreach ($data as $history) {
                $getCoin[] = array(
                    'date'        => date('Y-m-d', $history['created']),
                    'day_of_week' => Lib\Calendar::convertDayJapan($history['created'], $language_type),
                    'coin'        => !empty($history['point']) ? $history['point'] : 0,
                    'type'        => $history['type'],
                    'place_id'    => $history['place_id'],
                    'place_name'  => $history['place_name']
                );
            }
        }
        
        // Point used
        $usedCoin = array();
        
        return array(
            'user' => $user,
            'get_coin' => array(
                'total' => $totalGet,
                'data' => $getCoin
            ),
            'used_coin' => $usedCoin
        );
    }
    
    /**
     * Get point not displayed of user
     * @param array $param
     * @return int
     */
    public static function check($param) {
        if (empty($param['login_user_id'])) {
            return 0;
        }
        $query = DB::select(self::$_table_name.'.*')
                ->from(self::$_table_name)
                ->where(self::$_table_name.'.is_displayed', '=', 0)
                ->where(self::$_table_name.'.user_id', '=', $param['login_user_id']);
        $data = $query->execute()->as_array();
        $point = 0;
        if (!empty($data)) {
            $ids = array();
            foreach ($data as $row) {
                $point += intval($row['point']);
                $ids[] = $row['id'];
            }
            
            // Update displayed
            DB::update(self::$_table_name)
                    ->value('is_displayed', 1)
                    ->where('is_displayed', '=', 0)
                    ->where('user_id', '=', $param['login_user_id'])
                    ->where('id', '<=', max($ids))
                    ->execute();
        }
        return $point;
    }
    
    /**
     * Get list user and total get point
     * 
     * @return array
     */
    public static function get_list_for_batch_ranking() {
        $types = array(
            Config::get('user_point_logs.type.review_spot'),
            Config::get('user_point_logs.type.add_spot'),
        );
        
        $query = DB::select(
                    self::$_table_name.'.user_id',
                    DB::expr("SUM(IFNULL(user_point_logs.point, 0)) as point_get_total")
                )
                ->from(self::$_table_name)
                ->join('users', 'left')
                ->on('users.id', '=', self::$_table_name . '.user_id')
                ->where('users.disable', '=', 0)
                ->where(self::$_table_name . '.type', 'IN' , $types)
                ->group_by(self::$_table_name . '.user_id')
                ->order_by(DB::expr("SUM(IFNULL(user_point_logs.point, 0))"), 'DESC');
        
        return $query->execute(self::$slave_db)->as_array();
    }
    
}
