<?php

use Fuel\Core\DB;

/**
 * Model_User_Setting - Model to operate to User_Setting's functions.
 *
 * @package Model
 * @version 1.0
 * @author tuancd
 * @copyright Oceanize INC
 */
class Model_Admin_Setting extends Model_Abstract {

    protected static $_properties = array(
        'id',
        'admin_id',
        'setting_id',
        'value',
        'disable',
        'created',
        'updated',
    );
    protected static $not_checks = array('id', 'created', 'updated');
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
    protected static $_table_name = 'admin_settings';
    protected static $_setting_type = 'admin';

    /**
     * Function to add or update a user_settings.
     *   
     * @author tuancd 
     * @param array $param Input data.
     * @return bool Returns the boolean.
     */
    public static function add_update($param) {
        //check if admin_id exist or not
        $options['where'] = array(
            'id' => $param['admin_id'],
        );
        $data = Model_Admin::find('all', $options);
        if (empty($data)) {//if admin_id not exist
            static::errorNotExist('admin_id', $param['admin_id']);
            return false;
        } else {//if admin_id exist
            $values = json_decode($param['value']);
            foreach ($values as $val) {
                $options['where'] = array(
                    'admin_id' => $param['admin_id'],
                    'setting_id' => $val->setting_id
                );
                //check if update or insert
                $admin_setting = self::find('first', $options);
                if (!empty($admin_setting)) {//if exist then update
                    $admin_setting->set('admin_id', $param['admin_id']);
                    $admin_setting->set('setting_id', $val->setting_id);
                    $admin_setting->set('value', $val->value);
                    $admin_setting->update();
                } else {//if not exist then insert
                    $us = new self;
                    $us->set('admin_id', $param['admin_id']);
                    $us->set('setting_id', $val->setting_id);
                    $us->set('value', $val->value);
                    $us->save();
                }
            }
        }
        return true;
    }

    /**
     * Function to disable or enable a user_setting.   
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
            $adminsetting = self::find($id);
            if (empty($adminsetting)) {
                return false;
            }
            $adminsetting->set('disable', $param['disable']);
            if (!$adminsetting->update()) {
                return false;
            }
        }
        return true;
    }

    /**
     * Function to get all user_setting. 
     *   
     * @author tuancd 
     * @param array $param Input data.
     * @return mixed[] Returns the array.
     */
    public static function get_all($param) {
        $options['where'] = array(
            'id' => $param['admin_id'],
        );
        $res = Model_Admin::find('all', $options);
        if (empty($res)) {
            static::errorNotExist('admin_id', $param['admin_id']);
            return false;
        } else {
            $query = DB::select(
                array('settings.id', 'setting_id'),
                'settings.name',
                'settings.description',
                'settings.data_type',
                DB::expr(
                    "IF(ISNULL(admin_settings.value),
                    settings.value,
                    admin_settings.value) as value"
                ),
                DB::expr(
                    "IF(ISNULL(admin_settings.id),
                    settings.id,
                    admin_settings.id) as id"
                ),
                self::$_table_name . '.disable'
            )
                    ->from('settings')
                    ->join(DB::expr("(SELECT * FROM " . self::$_table_name . " WHERE admin_id = {$param['admin_id']}) AS " . self::$_table_name), 'LEFT')
                    ->on('settings.id', '=', self::$_table_name . '.setting_id')
                    ->where('settings.type', self::$_setting_type);
            if (!empty($param['name'])) {
                $query->where('settings.name', 'LIKE', "{$param['name']}%");
            }
            if (!empty($param['data_type'])) {
                $query->where('settings.data_type', $param['data_type']);
            }
            if (isset($param['disable']) && $param['disable'] != '') {
                $query->where('settings.disable', $param['disable']);
            }
            if (!empty($param['sort'])) {
                // KienNH 2016/04/20 check valid sort
                if (!self::checkSort($param['sort'], self::$_properties, 'name')) {
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
    }

    /**
     * Function to add or update a usersettings.   
     *
     * @author tuancd 
     * @param array $param Input data.
     * @return bool Returns the boolean.
     */
    public static function multi_update($param) {
        $upd_data = json_decode($param['value']);

        if (empty($upd_data)) {
            AppLog::info("Empty parameter", __METHOD__, $upd_data);
            return false;
        }
        //set infomation
        foreach ($upd_data as $row) {
            $options['where'] = array(
                'admin_id' => $row->admin_id,
                'setting_id' => $row->setting_id
            );
            $adminsetting = self::find('first', $options);
            if (empty($adminsetting)) {
                $us = new self;
                $us->set('admin_id', $row->admin_id);
                $us->set('setting_id', $row->setting_id);
                $us->set('value', $row->value);
                if (!$us->create()) {
                    AppLog::info("Admin setting insert failed", __METHOD__, $row);
                    return false;
                }
            } else {
                foreach ($row as $key => $val) {
                    if (in_array($key, self::$_properties) && !in_array($key, self::$not_checks)) {
                        $adminsetting->set($key, $val);
                    }
                }
                if (!$adminsetting->update()) {
                    AppLog::info("Admin setting update failed", __METHOD__, $row);
                    return false;
                }
            }
        }
        return true;
    }

}
