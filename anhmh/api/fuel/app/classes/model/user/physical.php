<?php

/**
 * Any query in Model User Physical
 *
 * @package Model
 * @created 2015-06-29
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Model_User_Physical extends Model_Abstract
{
    /** @var array $_properties field of table */
    protected static $_properties = array(
        'id',
        'type_id',
        'language_type',
        'name',
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
    protected static $_table_name = 'user_physicals';

    /**
     * Add or update info for User Physical
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return int|bool User Physical id or false if error
     */
    public static function add_update($param)
    {
        $id = !empty($param['id']) ? $param['id'] : 0;
        $physical = new self;
        // check exist
        if (!empty($id)) {
            $physical = self::find($id);
            if (empty($physical)) {
                self::errorNotExist('user_physical_id');
                return false;
            }
        }
        // set value
        if (!empty($param['type_id'])) {
            $physical->set('type_id', $param['type_id']);
        }
        if (isset($param['name'])) {
            $physical->set('name', $param['name']);
        }
        if (isset($param['language_type'])) {
            $physical->set('language_type', $param['language_type']);
        }
        // save to database
        if ($physical->save()) {
            if (empty($physical->id)) {
                $physical->id = self::cached_object($physical)->_original['id'];
            }
            return !empty($physical->id) ? $physical->id : 0;
        }
        return false;
    }

    /**
     * Get list User Physical (using array count)
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array List User Physical
     */
    public static function get_list($param)
    {
        $query = DB::select(
            self::$_table_name . '.*'
        )
            ->from(self::$_table_name);
        // filter by keyword
        if (!empty($param['id'])) {
            $query->where(self::$_table_name . '.id', '=', $param['id']);
        }
        if (!empty($param['type_id'])) {
            $query->where(self::$_table_name . '.type_id', '=', $param['type_id']);
        }
        if (!empty($param['language_type'])) {
            $query->where(self::$_table_name . '.language_type', '=', $param['language_type']);
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
        return array('total' => $total, 'data' => $data);
    }

    /**
     * Get all User Physical (without array count)
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array List User Physical
     */
    public static function get_all($param)
    {
        $query = DB::select(
                self::$_table_name . '.id',
                self::$_table_name . '.type_id',
                self::$_table_name . '.name'
            )
            ->from(self::$_table_name)
            ->where(self::$_table_name . '.disable', '=', '0');
        // filter by keyword
        if (!empty($param['type_id'])) {
            $query->where(self::$_table_name . '.type_id', '=', $param['type_id']);
        }
        if (!empty($param['language_type'])) {
            $query->where(self::$_table_name . '.language_type', '=', $param['language_type']);
        }
        $query->order_by(self::$_table_name . '.type_id', 'ASC');        
        $data = $query->execute(self::$slave_db)->as_array();
        return $data;
    }

    /**
     * Disable/Enable list User Physical
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return bool Success or otherwise
     */
    public static function disable($param)
    {
        $ids = explode(',', $param['id']);
        foreach ($ids as $id) {
            $physical = self::find($id);
            if ($physical) {
                $physical->set('disable', $param['disable']);
                if (!$physical->save()) {
                    return false;
                }
            } else {
                self::errorNotExist('user_physical_id');
                return false;
            }
        }
        return true;
    }

    /**
     * Get detail User Physical
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array|bool Detail User Physical or false if error
     */
    public static function get_detail($param)
    {
        $data = self::find($param['id']);
        if (empty($data)) {
            static::errorNotExist('user_physical_id');
            return false;
        }
        return $data;
    }
    
}
