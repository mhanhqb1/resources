<?php

class Model_Tag extends Model_Abstract {
    /**
     * Add or update info for Tag
     *
     * @author Hoang Gia Thong
     * @param array $param Input data
     * @return int|bool Id or false if error
     */
    protected static $_properties = array(
        'id',
        'name',
        'created',
        'updated',
        'disable',
    );
    /**
     * Add or update info for Tag
     *
     * @author Hoang Gia Thong
     * @param array $param Input data
     * @return int|bool Id or false if error
     */
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
    protected static $_table_name = 'tags';
    /**
     * Add or update info for Tag
     *
     * @author Hoang Gia Thong
     * @param array $param Input data
     * @return int|bool Id or false if error
     */
    public static function add_update($param)
    {      
        $id = !empty($param['id']) ? $param['id'] : 0;
        $query = new self;
        // check exist
        if (!empty($id)) {
            $query = self::find($id);
            if (empty($query)) {
                self::errorNotExist('id');
                return false;
            }
        }
        // set value    
        if (!empty($param['name'])) {
            $query->set('name', $param['name']);
        }
        // save to database
        if ($query->save()) {
            if (empty($query->id)) {
                $query->id = self::cached_object($query)->_original['id'];
            }
            return !empty($query->id) ? $query->id : 0;
        }
        return false;
    }    
    /**
     * Get list Tag (using array count)
     *
     * @author Hoang Gia Thong
     * @param array $param Input data
     * @return array List Tag
     */
    public static function get_list($param) {        
        $query = DB::select()->from(self::$_table_name);
        // filter by keyword
        if (!empty($param['name'])) {
            $query->where('name', 'LIKE', "%{$param['name']}%");
        }
        if (isset($param['disable']) && $param['disable'] !== '') {
            $query->where(self::$_table_name . '.disable', '=', $param['disable']);
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
            $query->order_by(self::$_table_name . '.id', 'DESC');
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
     * Get all Tag (without array count)
     *
     * @author Hoang Gia Thong
     * @return array List Tag
     */
    public static function get_all() {
        $query = DB::select()
                ->from(self::$_table_name)
                ->where('disable', '=', '0');
        if (!empty($param['sort'])) {
            // KienNH 2016/04/20 check valid sort
            if (!self::checkSort($param['sort'])) {
                self::errorParamInvalid('sort');
                return false;
            }
            
            $sortExplode = explode('-', $param['sort']);
            $query->order_by(self::$_table_name . '.' . $sortExplode[0], $sortExplode[1]);
        } else {
            $query->order_by(self::$_table_name . '.id', 'DESC');
        }
        if (!empty($param['limit'])) {           
            $query->limit($param['limit'])->offset(0);
        }
        $data = $query->execute(self::$slave_db)->as_array();
        return $data;
    }

    
    
    /**
     * Disable/Enable list Tag
     *
     * @author Hoang Gia Thong
     * @param array $param Input data
     * @return bool Success or otherwise
     */
    public static function disable($param) {
        if (!isset($param['disable'])) {
            $param['disable'] = '1';
        }
        $ids = explode(',', $param['id']);
        foreach ($ids as $id) {
            $admin = self::find($id);
            if ($admin) {
                $admin->set('disable', $param['disable']);
                if (!$admin->save()) {
                    return false;
                }
            } else {
                self::errorNotExist('id');
                return false;
            }
        }
        return true;
    }

    /**
     * Get detail Tag
     *
     * @author Hoang Gia Thong
     * @param array $param Input data
     * @return array|bool Detail Tag or false if error
     */
    public static function get_detail($param) {
         $data = self::find($param['id']);
        if (empty($data)) {
            static::errorNotExist('id');
            return false;
        }
        return $data;
    }

}
