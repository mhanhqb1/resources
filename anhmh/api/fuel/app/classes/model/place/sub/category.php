<?php

/**
 * Any query in Model Place Sub Category
 *
 * @package Model
 * @created 2015-07-01
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Model_Place_Sub_Category extends Model_Abstract
{
    /** @var array $_properties field of table */
    protected static $_properties = array(
        'id',
        'type_id',
        'google_name',
        'name',
        'language_type',
        'category_type_id',
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
    protected static $_table_name = 'place_sub_categories';

    /**
     * Add or update info for Place Sub Category
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return int|bool Place Sub Category id or false if error
     */
    public static function add_update($param)
    {
        $id = !empty($param['id']) ? $param['id'] : 0;
        $place = new self;
        // check exist
        if (!empty($id)) {
            $place = self::find($id);
            if (empty($place)) {
                self::errorNotExist('place_sub_category_id');
                return false;
            }
        }
        // set value
        if (!empty($param['type_id'])) {
            $place->set('type_id', $param['type_id']);
        }
        if (isset($param['google_name'])) {
            $place->set('google_name', $param['google_name']);
        }
        if (isset($param['name'])) {
            $place->set('name', $param['name']);
        }
        if (isset($param['language_type'])) {
            $place->set('language_type', $param['language_type']);
        }
        if (isset($param['category_type_id'])) {
            $place->set('category_type_id', $param['category_type_id']);
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
     * Get list Place Sub Category (using array count)
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array List Place Sub Category
     */
    public static function get_list($param)
    {
        $query = DB::select(
                self::$_table_name . '.*',
                array(Model_Place_Category::table() . '.id', 'category_id'),
                array(Model_Place_Category::table() . '.name', 'category_name')
            )
            ->from(self::$_table_name)
            ->join(Model_Place_Category::table())
            ->on(self::$_table_name . '.category_type_id', '=', Model_Place_Category::table() . '.type_id')
            ->on(self::$_table_name . '.language_type', '=', Model_Place_Category::table() . '.language_type');
        
        if (!empty($param['id'])) {
            $query->where(self::$_table_name . '.id', '=', $param['id']);
        }
        if (!empty($param['type_id'])) {
            $query->where(self::$_table_name . '.type_id', '=', $param['type_id']);
        }
        if (!empty($param['place_category_type_id'])) {
            $query->where(self::$_table_name . '.category_type_id', '=', $param['place_category_type_id']);
        }
        if (!empty($param['language_type'])) {
            //$query->where(self::$_table_name . '.language_type', '=', $param['language_type']);
            //$query->where(Model_Place_Category::table() . '.language_type', '=', $param['language_type']);
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
        /*
        if (!empty($param['page']) && !empty($param['limit'])) {
            $offset = ($param['page'] - 1) * $param['limit'];
            $query->limit($param['limit'])->offset($offset);
        }      
        * 
        */ 
        $data = $query->execute(self::$slave_db)->as_array();        
        $jp = \Lib\Arr::filter($data, 'language_type', 1);
        $total = count($jp);
        $en = \Lib\Arr::key_value(\Lib\Arr::filter($data, 'language_type', 2), 'type_id', 'name');
        $th = \Lib\Arr::key_value(\Lib\Arr::filter($data, 'language_type', 3), 'type_id', 'name');
        $es = \Lib\Arr::key_value(\Lib\Arr::filter($data, 'language_type', 5), 'type_id', 'name');
        if (!empty($param['page']) && !empty($param['limit'])) {
            $offset = ($param['page'] - 1) * $param['limit'];
            $jp = array_slice($jp, $offset, $param['limit']);
        }
        $result = array();
        foreach ($jp as $row) {
            $row['id'] = $row['type_id'];
            $row['name_en'] = isset($en[$row['type_id']]) ? $en[$row['type_id']] : '';
            $row['name_th'] = isset($th[$row['type_id']]) ? $th[$row['type_id']] : '';
            $row['name_es'] = isset($es[$row['type_id']]) ? $es[$row['type_id']] : '';
            $result[] = $row;
        }
        return array('total' => $total, 'data' => $result);
    }

    /**
     * Get all Place Sub Category (without array count)
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array List Place Sub Category
     */
    public static function get_all($param)
    {
        $query = DB::select(
                self::$_table_name . '.*',
                array(Model_Place_Category::table() . '.id', 'category_id'),
                array(Model_Place_Category::table() . '.name', 'category_name')
            )
            ->from(self::$_table_name)
            ->join(Model_Place_Category::table())
            ->on(self::$_table_name . '.category_type_id', '=', Model_Place_Category::table() . '.type_id')
            ->where(self::$_table_name . '.disable', '=', '0')
            ->where(Model_Place_Category::table() . '.disable', '=', '0')
            ->where(self::$_table_name . '.language_type', '=', $param['language_type'])
            ->where(Model_Place_Category::table() . '.language_type', '=', $param['language_type']);
        // filter by keyword
        if (!empty($param['type_id'])) {
            $query->where(self::$_table_name . '.type_id', '=', $param['type_id']);
        }  
        if (!empty($param['category_type_id'])) {
            $query->where(self::$_table_name . '.category_type_id', '=', $param['category_type_id']);
        }
        $query->order_by(self::$_table_name . '.id', 'ASC');
        // get data
        $data = $query->execute(self::$slave_db)->as_array();
        return $data;
    }

    /**
     * Disable/Enable list Place Sub Category
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return bool Success or otherwise
     */
    public static function disable($param)
    {
        $ids = explode(',', $param['id']);
        foreach ($ids as $id) {
            $categories = self::find('all', array(
                'where' => array(
                    'type_id' => $id
                )
            ));
            if ($categories) {
                foreach ($categories as $category) {
                    $category->set('disable', $param['disable']);
                    if (!$category->save()) {
                        return false;
                    }
                }
            } else {
                self::errorNotExist('place_sub_category_id');
                return false;
            }
        }
        return true;
    }

    /**
     * Get detail Place Sub Category
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array|bool Detail Place Sub Category or false if error
     */
    public static function get_detail($param)
    {
        $data = self::find($param['id']);
        if (empty($data)) {
            static::errorNotExist('place_sub_category_id');
            return false;
        }
        return $data;
    }

    /**
     * Get detail Place Sub Category by Google name
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array|bool Detail Place Sub Category or false if error
     */
    public static function get_detail_by_google_name($param)
    {
        if (!is_array($param['google_name'])) {
            $param['google_name'] = explode(',', $param['google_name']);
        }
        if (empty($param['google_name'])) {
            return array();
        }
        $data = DB::select(
                self::$_table_name . '.*',
                array(Model_Place_Category::table() . '.id', 'category_id'),
                array(Model_Place_Category::table() . '.name', 'category_name')
            )
            ->from(self::$_table_name)
            ->join(Model_Place_Category::table())
            ->on(self::$_table_name . '.category_type_id', '=', Model_Place_Category::table() . '.type_id')
            ->where(self::$_table_name . '.disable', '=', '0')
            ->where(Model_Place_Category::table() . '.disable', '=', '0')
            ->where(self::$_table_name . '.language_type', '=', $param['language_type'])
            ->where(Model_Place_Category::table() . '.language_type', '=', $param['language_type'])
            ->where(self::$_table_name . '.google_name', 'IN', $param['google_name'])
            ->order_by(self::$_table_name . '.id', 'ASC')
            ->execute(self::$slave_db)
            ->as_array();
        return $data;  
    }
    
    /**
     * Add or update multiple images
     *
     * @author Le Tuan Tu
     * @param array $param Array image path
     * @return int|bool Place Image id or false if error
     */
    public static function add_update_multiple($param)
    {
        if (!isset($param['data'])) {
            static::errorParamInvalid('data');
            return false;
        }
        $param = json_decode($param['data'], true);
        \LogLib::warning('Params: ', __METHOD__, $param);
        if (empty($param['type_id'])
            || empty($param['google_name'])
            || empty($param['name'])
            || empty($param['name_en'])
            || empty($param['name_es'])
        ) {
            static::errorParamInvalid('type_id/google_name/name/name_en/name_th');
            return false;
        }
        $dataUpdate = array();
        $languageType = array(
            1 => $param['name'],
            2 => $param['name_en'],
            5 => $param['name_es'],
        );
        foreach ($languageType as $language => $name) {
            foreach ($param['type_id'] as $type_id) {
                if ($type_id == 0) {
                    $new_type_id = self::max('type_id') + 1;
                }
                $dataUpdate[] = array(
                    'type_id' => isset($new_type_id) ? $new_type_id : $type_id,
                    'language_type' => $language,
                    'google_name' => !empty($param['google_name'][$type_id]) ? $param['google_name'][$type_id] : '',
                    'category_type_id' => !empty($param['category_type_id'][$type_id]) ? $param['category_type_id'][$type_id] : 0,
                    'name' => !empty($name[$type_id]) ? $name[$type_id] : '',                    
                );              
            }
        }
        // execute insert/update
        if (!empty($dataUpdate) && !parent::batchInsert(
                self::$_table_name,
                $dataUpdate,
                array(
                    'google_name' => DB::expr('VALUES(google_name)'),
                    'category_type_id' => DB::expr('VALUES(category_type_id)'),
                    'name' => DB::expr('VALUES(name)'),
                    'disable' => DB::expr('VALUES(disable)')
                ),
                false
            )
        ) {
            \LogLib::warning('Can not update '.self::$_table_name, __METHOD__, $param);
            return false;
        }        
        return true;
    }
    
}
