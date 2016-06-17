<?php

/**
 * Model_Setting - Model to operate to settings's functions
 *
 * @package Model
 * @version 1.0
 * @author diennvt
 * @copyright Oceanize INC
 */
class Model_Setting extends Model_Abstract {

    protected static $_properties = array(
        'id',
        'name',
        'description',
        'data_type',
        'type',
        'default_value',
        'value',
        'pattern_url_rule',
        'disable',
        'created',
        'updated',
    );
    protected static $not_checks = array('id', 'created', 'updated');
    protected static $like_search = array('name', 'data_type', 'type');
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
    protected static $_table_name = 'settings';

    /**
     * Function to get a list of settings.
     *
     * @author diennvt
     * @param array $param Input data.
     * @return array Return array(total, data).
     */
    public static function get_list($param) {
        $query = DB::select()
                ->from(self::$_table_name);
        foreach ($param as $key => $val) {
            if (in_array($key, self::$_properties) && !in_array($key, self::$not_checks)) {
                if ($val != '') {
                    if (in_array($key, self::$like_search)) {
                        $query->where($key, 'LIKE', "{$val}%");
                    } else {
                        $query->where($key, $val);
                    }
                }
            }
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
        if (!empty($param['page']) && !empty($param['limit'])) {
            $offset = ($param['page'] - 1) * $param['limit'];
            $query->limit($param['limit'])->offset($offset);
        }
        $data = $query->execute(self::$slave_db)->as_array();
        $total = !empty($data) ? DB::count_last_query(self::$slave_db) : 0;
        return array($total, $data);
    }

    /**
     * Function to add or update a settings.
     *
     * @author diennvt
     * @param array $param Input data.
     * @return bool|int Returns the boolean or the integer.
     */
    public static function add_update($param) {

        //check id if existing
        $is_edit = false;
        $id = !empty($param['id']) ? $param['id'] : 0;
        $setting = new self;
        if (!empty($id)) {
            $setting = self::find($id);
            if (empty($setting)) {
                static::errorNotExist('setting_id', $param['id']);
                return false;
            }
            $is_edit = true;
        }
        //check if name and type existing
        if (!empty($param['name']) && !empty($param['type'])) {
            $option['where'] = array(
                'name' => $param['name'],
                'type' => $param['type']
            );
            if ($is_edit) {
                $option['where'][] = array(
                    'id', '<>', $id
                );
            }
            $check = self::find('first', $option);
            if (!empty($check)) {
                static::errorDuplicate('name', $param['name']);
                return false;
            }
        }
        //set infomation
        foreach ($param as $key => $val) {
            if (in_array($key, self::$_properties) && !in_array($key, self::$not_checks)) {
                if ($val != '') {
                    $setting->set($key, $val);
                }
            }
        }
        //check id for adding new or updating
        if ($setting->save()) {
            if (empty($setting->id)) {
                $setting->id = self::cached_object($setting)->_original['id'];
            }
            self::delete_cache();
            return !empty($setting->id) ? $setting->id : 0;
        }
        return false;
    }

    /**
     * Function to get detail settings.
     *
     * @author diennvt
     * @param array $param Input data.
     * @return array Returns the array.
     */
    public static function get_detail($param) {
        $data = self::find($param['id']);
        return !empty($data) ? $data : array();
    }

    /**
     * Function to disable or enable a setting.
     *
     * @author diennvt
     * @param array $param Input data.
     * @return bool Returns the boolean.
     */
    public static function disable($param) {
        if (empty($param['id'])) {
            return false;
        }
        $ids = explode(',', $param['id']);
        foreach ($ids as $id) {
            $setting = self::find($id);
            if (empty($setting)) {
                static::errorNotExist('setting_id', $param['id']);
                return false;
            }
            $setting->set('disable', $param['disable']);
            if (!$setting->update()) {
                return false;
            }
        }
        self::delete_cache();
        return true;
    }

    /**
     * Function to get all setting.
     *
     * @author diennvt
     * @param array $param Input data.
     * @return bool|array Returns the boolean or the array.
     */
    public static function get_all($param) {
        if (empty($param['type'])) {
            return false;
        }
        $key = 'setting_all_' . $param['type'];
        $data = \Lib\Cache::get($key);
        if ($data === false) {
            $options['where'] = array(
                'disable' => 0,
                'type' => $param['type'],
            );
            $data = !empty($data) ? $data : array();
            $data = self::find('all', $options);
            \Lib\Cache::set($key, $data, \Config::load('cache')['key']['setting_all']);
        }        
        return $data;
    }

    /**
     * Function to add or update a settings.
     *
     * @author diennvt
     * @param array $param Input data.
     * @return bool Returns the boolean.
     */
    public static function multi_update($param) {
        $upd_data = json_decode($param['value']);

        if (empty($upd_data)) {
            return false;
        }
        //set infomation
        foreach ($upd_data as $row) {
            $setting = new self;
            if (!empty($row->id)) {
                $setting = self::find($row->id);
                if (empty($setting)) {
                    static::errorNotExist('setting_id', $row->id);
                    return false;
                }
                foreach ($row as $key => $val) {
                    if (in_array($key, self::$_properties) && !in_array($key, self::$not_checks)) {
                        if ($val != '') {
                            $setting->set($key, $val);
                        }
                    }
                }
                if (!$setting->update()) {                    
                    return false;
                }
            }
        }
        self::delete_cache();
        return true;
    }
    /**
     * Function to delete cache.
     *
     * @author thailh
     * @return bool Returns the boolean.
     */
    public static function delete_cache()
    {
        return \Lib\Cache::delete('setting_all_global');
    }

    /**
     * Set url for any field image data.
     *
     * @author Le Tuan Tu
     * @param array $param Input data.
     * @param array $fieldArray fieldArray
     * @return array Returns the array.
     *
     */
    public static function set_image_url($param, $fieldArray)
    {
        foreach ($param as &$paramElement) {
            foreach ($fieldArray as $field) {
                if (empty($paramElement[$field])) {
                    $paramElement[$field] .= \Config::get('no_image_user');
                } elseif (!(strstr($paramElement[$field], 'http://') || strstr($paramElement[$field], 'https://'))) {
                    $paramElement[$field] = \Config::get('img_url') . $paramElement[$field];
                }
            }
        }

        return $param;
    }
}
