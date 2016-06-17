<?php

use Fuel\Core\DB;
use Lib\Util;
/**
 * Any query in Model Admin.
 *
 * @package Model
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Model_Admin extends Model_Abstract
{
	protected static $_properties = array(
		'id',
		'name',
		'login_id',
		'password',
        'admin_type',
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

	protected static $_table_name = 'admins';

    /**
     * Get list admin by login_id LIKE $param['login_id'].
     *
     * @author Le Tuan Tu
     * @param array array $param Input data.
     * @return array Returns array(total, data).
     */
    public static function get_list($param)
    {
        $query = DB::select(
                    self::$_table_name . '.*'
                )
                ->from(self::$_table_name);        
        if (!empty($param['login_id'])) {
            $query->where('login_id', 'LIKE', "%{$param['login_id']}%");
        }
        if (!empty($param['name'])) {
            $query->where('name', 'LIKE', "%{$param['name']}%");
        }
        if (isset($param['disable']) && $param['disable'] != '') {
            $query->where('disable', '=', $param['disable']);
        }
        if (isset($param['admin_type']) && $param['admin_type'] != '') {
            $query->where('admin_type', '=', $param['admin_type']);
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
     * Disable/Enable a admin.
     *
     * @author Le Tuan Tu
     * @param array array $param Input data.
     * @return bool Returns the boolean.
     */
    public static function disable($param)
    {
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
                self::errorNotExist('admin_id');
                return false;
            }
        }

        return true;
    }

    /**
     * Add or update info for admin.
     *
     * @author Le Tuan Tu
     * @param array array $param Input data.
     * @return bool|int Returns the boolean or the integer.
     */
    public static function add_update($param)
    {
        $id = !empty($param['id']) ? $param['id'] : 0;
        $options['where'][] = array(
            'login_id' => $param['login_id'],
        );
        if (!empty($id)) {
            $admin = self::find($id);
            if (empty($admin)) {
                return false;
            }  
            $options['where'][] = array(
                'id', '<>', $id
            );
        }       
        $check = self::find('first', $options);             
        if (!empty($check) && $check->get('login_id') == $param['login_id']) {
            static::errorDuplicate('login_id', $param['login_id']);
            return false;
        }
        if (empty($admin)) {
            $admin = new self;  
        }
        if (isset($param['name'])) {
            $admin->set('name', $param['name']);
        }
        if (isset($param['login_id'])) {
            $admin->set('login_id', $param['login_id']);
        }
        if (isset($param['admin_type']) && $param['admin_type'] != '') {
            $admin->set('admin_type', $param['admin_type']);
        }
        if (isset($param['password'])) {
            $admin->set('password', Util::encodePassword($param['password'], $param['login_id']));
        }
        if ($admin->save()) {
            if (empty($admin->id)) {
                $admin->id = self::cached_object($admin)->_original['id'];
            }
            return !empty($admin->id) ? $admin->id : 0;
        }
        return false;
    }
    
    /**
     * Login for admin.
     *
     * @author diennvt - VuLTH
     * @param array $param Input data.
     * @return array|bool Returns the array or the boolean.
     */
    public static function login($param)
    {  
        $param['password'] = Util::encodePassword($param['password'], $param['login_id']);
        $query = DB::select(
                    'admins.id',
                    'admins.name',
                    'admins.login_id',
                    'admins.admin_type',
                    'admins.created'                   
                )
                ->from(self::$_table_name)
                ->where("admins.disable",'=','0')
                ->where(self::$_table_name.".login_id",'=',$param['login_id'])
                ->where(self::$_table_name.".password",'=',$param['password']);
        $data = $query->execute(self::$slave_db)->offsetGet(0);
        return $data;
    }

    /**
     * Get detail for admin.
     *
     * @author diennvt
     * @param array $param Input data.
     * @return array Returns the array.
     */
    public static function get_detail($param)
    {
        $param['password'] = Util::encodePassword($param['password'], $param['login_id']);
        $query = DB::select(
                self::$_table_name.".*",
                'authenticates.token'
                )
                ->from(self::$_table_name)
                ->join("authenticates", "LEFT")
                ->on(self::$_table_name.".id",'=','authenticates.user_id')
                ->where(self::$_table_name.".login_id",'=',$param['login_id'])
                ->where(self::$_table_name.".password",'=',$param['password'])
                ->where("authenticates.regist_type",'=','admin');
        
        $data = $query->execute(self::$slave_db)->as_array();
        if (empty($data)) {
            static::errorNotExist('id', $param['login_id']);
        }
        return !empty($data) ? $data : array();
    }

    /**
     * Update password for admin.
     *
     * @author Le Tuan Tu
     * @param array $param Input data.
     * 
     * @return bool Returns the boolean.
     */
    public static function update_password($param)
    {
        $admin = self::find($param['id']);
        if ($admin) {
            $admin->set('password', Util::encodePassword($param['password'], $admin->get('login_id')));
            if ($admin->update()) {
                return true;
            }
        }
        self::errorNotExist('admin_id');
        return false;
    }
    
    /**
     * Get all Admin (without array count)
     *
     * @author Hoang Gia Thong
     * @return array List Admin
     */
    public static function get_all($param) {
        $query = DB::select()
                ->from(self::$_table_name)
                ->where('disable', '=', '0')               
                ->where(self::$_table_name.".admin_type",'=',$param['admin_type']);
        // get data
        $data = $query->execute(self::$slave_db)->as_array();
        return $data;
    }
}
