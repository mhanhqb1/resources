<?php

/**
 * Any query in Model Place Category
 *
 * @package Model
 * @created 2015-06-29
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Model_Place_Category extends Model_Abstract
{
    /** @var array $_properties field of table */
    protected static $_properties = array(
        'id',
        'type_id',
        'name',
        'language_type',
        'pin_icon',
        'menu_icon',
        'tab_icon',
        'small_icon',
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
    protected static $_table_name = 'place_categories';

    /**
     * Add or update info for Place Category
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return int|bool Place Category id or false if error
     */
    public static function add_update($param)
    {
        $id = !empty($param['id']) ? $param['id'] : 0;
        $place = new self;
        // check exist
        if (!empty($id)) {
            $place = self::find($id);
            if (empty($place)) {
                self::errorNotExist('place_category_id');
                return false;
            }
        }
        // set value
        if (!empty($param['type_id'])) {
            $place->set('type_id', $param['type_id']);
        }
        if (isset($param['name'])) {
            $place->set('name', $param['name']);
        }
        if (isset($param['language_type'])) {
            $place->set('language_type', $param['language_type']);
        }
        if (isset($param['pin_icon'])) {
            $place->set('pin_icon', $param['pin_icon']);
        }
        if (isset($param['menu_icon'])) {
            $place->set('menu_icon', $param['menu_icon']);
        }
        if (isset($param['tab_icon'])) {
            $place->set('tab_icon', $param['tab_icon']);
        }
        if (isset($param['small_icon'])) {
            $place->set('small_icon', $param['small_icon']);
        }
        // save to database
        if ($place->save()) {
            if (empty($place->id)) {
                $place->id = self::cached_object($place)->_original['id'];
            }
            return !empty($place->id) ? $place->id : 0;
        }
        return false;
    }

    /**
     * Get list Place Category (using array count)
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array List Place Category
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
     * Get all Place Category (without array count)
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array List Place Category
     */
    public static function get_all($param)
    {
        $query = DB::select(
                self::$_table_name . '.id',
                self::$_table_name . '.type_id',
                self::$_table_name . '.name',
                self::$_table_name . '.language_type'
            )
            ->from(self::$_table_name)
            ->where(self::$_table_name . '.disable', '=', '0')
            ->where(self::$_table_name . '.language_type', '=', $param['language_type']);
        // filter by keyword
        if (!empty($param['type_id'])) {
            $query->where(self::$_table_name . '.type_id', '=', $param['type_id']);
        }               
        $query->order_by(self::$_table_name . '.id', 'ASC');
        $data = $query->execute(self::$slave_db)->as_array();
        if (isset($param['get_sub_category'])) {
            $subCategories = Model_Place_Sub_Category::get_all(array(
                                    'language_type' => $param['language_type']
                                )
                            );
            foreach ($data as &$row) {
                $row['sub_categories'] = Lib\Arr::filter($subCategories, 'category_type_id', $row['type_id']);
            }
        }
        if (isset($param['count_place'])) {
            $typeId = Lib\Arr::field($data, 'type_id');
            $counts = Lib\Arr::key_value(
                Model_Place::count_by_category(array(                   
                    'place_category_type_id' => $typeId,                    
                )),
                'place_category_type_id',
                'count_place'
            );
        } elseif (isset($param['count_place_want_to_visit']) && !empty($param['login_user_id'])) {
            $typeId = Lib\Arr::field($data, 'type_id');
            $counts = Lib\Arr::key_value(
                Model_Place_Favorite::count_by_category(array(
                    'login_user_id' => $param['login_user_id'],
                    'place_category_type_id' => $typeId,
                    'favorite_type' => 1,
                )),
                'place_category_type_id',
                'count_place'
            );
        } elseif (isset($param['count_place_visited']) && !empty($param['login_user_id'])) {
            $typeId = Lib\Arr::field($data, 'type_id');
            $counts = Lib\Arr::key_value(
                Model_Place_Favorite::count_by_category(array(
                    'login_user_id' => $param['login_user_id'],
                    'place_category_type_id' => $typeId,
                    'favorite_type' => 2,
                )),
                'place_category_type_id',
                'count_place'
            );
        }
        if (!empty($counts)) {
            foreach ($data as &$row) {
                $row['count_place'] = !empty($counts[$row['type_id']]) ? $counts[$row['type_id']] : 0;
            }
            unset($row);
        }
        return $data;
    }

    /**
     * Disable/Enable list Place Category
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return bool Success or otherwise
     */
    public static function disable($param)
    {
        $ids = explode(',', $param['id']);
        foreach ($ids as $id) {
            $place = self::find($id);
            if ($place) {
                $place->set('disable', $param['disable']);
                if (!$place->save()) {
                    return false;
                }
            } else {
                self::errorNotExist('place_category_id');
                return false;
            }
        }
        return true;
    }

    /**
     * Get detail Place Category
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array|bool Detail Place Category or false if error
     */
    public static function get_detail($param)
    {
        $data = self::find($param['id']);
        if (empty($data)) {
            static::errorNotExist('place_category_id');
            return false;
        }
        return $data;
    }
}
