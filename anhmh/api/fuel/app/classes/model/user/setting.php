<?php

use Fuel\Core\DB;

/**
 * Model_User_Setting - Model to operate to User_Setting's functions.
 *
 * @package Model
 * @version 1.0
 * @author diennvt
 * @copyright Oceanize INC
 */
class Model_User_Setting extends Model_Abstract {

    protected static $_properties = array(
        'id',
        'user_id',
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
    protected static $_table_name = 'user_settings';
    protected static $_setting_type = 'user';

    /**
     * Function to add or update a user_settings.
     *
     * @author diennvt
     * @param array $param Input data.
     * @return bool Returns the boolean.
     */
    public static function add_update($param) {
        //check if user_id exist or not
        $options['where'] = array(
            'id' => $param['user_id'],
        );
        $data = Model_User::find('all', $options);
        if (empty($data)) {//if user_id not exist
            static::errorNotExist('user_id', $param['user_id']);
            return false;
        } else {//if user_id exist
            $values = json_decode($param['value']);
            foreach ($values as $val) {
                $options['where'] = array(
                    'user_id' => $param['user_id'],
                    'setting_id' => $val->setting_id
                );
                //check if update or insert
                $user_setting = self::find('first', $options);
                if (!empty($user_setting)) {//if exist then update
                    $user_setting->set('user_id', $param['user_id']);
                    $user_setting->set('setting_id', $val->setting_id);
                    $user_setting->set('value', $val->value);
                    $user_setting->update();
                } else {//if not exist then insert
                    $us = new self;
                    $us->set('user_id', $param['user_id']);
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
            $usersetting = self::find($id);
            if (empty($usersetting)) {
                return false;
            }
            $usersetting->set('disable', $param['disable']);
            if (!$usersetting->update()) {
                return false;
            }
        }
        return true;
    }

    /**
     * Function to get all user_setting.
     *
     * @author diennvt
     * @param array $param Input data.
     * @return array Returns array(total, data).
     */
    public static function get_all($param) {
        $options['where'] = array(
            'id' => $param['login_user_id'],
        );
        $res = Model_User::find('all', $options);
        if (empty($res)) {
            static::errorNotExist('user_id', $param['login_user_id']);
            return false;
        } else {    
            $query = DB::select(
                        array('settings.id', 'setting_id'),
                        'settings.name', 
                        DB::expr("
                            IF({$param['language_type']}=1,settings.title_ja,
                            IF({$param['language_type']}=2,settings.title_en,
                            IF({$param['language_type']}=3,settings.title_th,
                            IF({$param['language_type']}=4,settings.title_vi,
                            IF({$param['language_type']}=5,settings.title_es,settings.title_ja))))) AS title
                        "), 
                        'settings.description', 
                        'settings.data_type', 
                        DB::expr("IF(ISNULL(" . self::$_table_name . '.value' . "), settings.value, " . self::$_table_name . '.value' . ") as value"), 
                        DB::expr("IF(ISNULL(" . self::$_table_name . '.id' . "), settings.id, " . self::$_table_name . '.id' . ") as id")
                    )
                    ->from('settings')
                    ->join(DB::expr("(SELECT * FROM " . self::$_table_name . " WHERE user_id = {$param['login_user_id']}) AS " . self::$_table_name), 'LEFT')
                    ->on('settings.id', '=', self::$_table_name . '.setting_id')
                    ->where('settings.type', self::$_setting_type)
                    ->where('settings.disable', '0')
                    ->order_by('settings.name');

            if (!empty($param['name'])) {
                $query->where('settings.name', 'LIKE', "{$param['name']}%");
            }
            if (!empty($param['data_type'])) {
                $query->where('settings.data_type', $param['data_type']);
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
                $query->order_by(self::$_table_name . '.setting_id', 'ASC');
            }
            if (!empty($param['page']) && !empty($param['limit'])) {
                $offset = ($param['page'] - 1) * $param['limit'];
                $query->limit($param['limit'])->offset($offset);
            }
            $data = $query->execute(self::$slave_db)->as_array();
            return $data;
        }
    }    
    
    /**
     * Function to add or update a usersettings.
     *
     * @author diennvt
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
                'user_id' => $row->user_id,
                'setting_id' => $row->setting_id
            );
            $usersetting = self::find('first', $options);
            if (empty($usersetting)) {
                $us = new self;
                $us->set('user_id', $row->user_id);
                $us->set('setting_id', $row->setting_id);
                $us->set('value', $row->value);
                if (!$us->save()) {
                    AppLog::info("User setting insert failed", __METHOD__, $row);
                    return false;
                }
            } else {
                foreach ($row as $key => $val) {
                    if (in_array($key, self::$_properties) && !in_array($key, self::$not_checks)) {
                        if ($val != '') {
                            $usersetting->set($key, $val);
                        }
                    }
                }
                if (!$usersetting->update()) {
                    AppLog::info("User setting update failed", __METHOD__, $row);
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Function to get list user_setting.
     *
     * @author tuancd
     * @param array $param Input data.
     * @return array Returns the array.
     */
    public static function mobile_get_list($param) {
        $options['where'] = array(
            'id' => $param['user_id'],
        );
        $res = Model_User::find('all', $options);
        if (empty($res)) {
            static::errorNotExist('user_id', $param['user_id']);
            return false;
        } else {
            // Get all user_setting for user
            $query = DB::select('settings.name', DB::expr("IF(ISNULL(" . self::$_table_name . '.value' . "), settings.value, " . self::$_table_name . '.value' . ") as value"))
                    ->from('settings')
                    ->join(DB::expr("(SELECT * FROM " . self::$_table_name . " WHERE user_id = {$param['user_id']}) AS " . self::$_table_name), 'LEFT')
                    ->on('settings.id', '=', self::$_table_name . '.setting_id')
                    ->where('settings.disable', 0)
                    ->where('settings.type', self::$_setting_type)
                    ->where('settings.name', 'in', Config::get('mobile_user_setting_key', true));
            $data = $query->execute(self::$slave_db)->as_array();
            return \Lib\Arr::key_value($data, 'name', 'value');
        }
    }

    /**
     * Update info for User Setting
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return int|bool Help id or false if error
     */
    public static function set_update($param)
    { 
        $options['where'] = array(
            'name' => $param['name'],            
        );
        $setting = Model_Setting::find('first', $options);
        if (empty($setting)) {
            self::errorNotExist('name');
            return false; 
        }
        $options['where'] = array(
            'setting_id' => $setting->get('id'),
            'user_id' => $param['login_user_id'],
        );
        $self = self::find('first', $options);
        if (empty($self)) {
            $self = new self;
        }
        $self->set('user_id', $param['login_user_id']);
        $self->set('setting_id', $setting->get('id'));
        $self->set('value', $param['value']);
        if (!$self->save()) {
            \LogLib::warning('Can not insert/update ' . self::$_table_name, __METHOD__, $param);
            return false;        
        }
        return true;
    }

}
