<?php

/**
 * Any query in Model Place Information
 *
 * @package Model
 * @created 2015-06-29
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Model_Place_Information extends Model_Abstract
{
    /** @var array $_properties field of table */
    protected static $_properties = array(
        'id',
        'place_id',
        'name',
        'name_kana',
        'address',
        'tel',
        'station_near_by',
        'business_hours',
        'regular_holiday',
        'place_memo',
        'language_type',
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
    protected static $_table_name = 'place_informations';

    /**
     * Add or update info for Place Information
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return int|bool Place Information id or false if error
     */
    public static function add_update($param, &$is_changed = false)
    {  
        if (!empty($param['place_id'])) {
            $self = self::find('first', array(
                    'where' => array(
                        'place_id' => $param['place_id'],
                        'language_type' => $param['language_type'],
                    )
                )
            );
        } elseif (!empty($param['id'])) {
            $self = self::find($param['id']);
            if (empty($self)) {
                self::errorNotExist('place_information_id');
                return false;
            }                       
        }        
        if (empty($self)) {
            $self = new self;
            if (!isset($param['name'])) {
                $param['name'] = '';
            }
            if (!isset($param['name_kana'])) {
                $param['name_kana'] = '';
            }
            if (!isset($param['address'])) {
                $param['address'] = '';
            }
            if (!isset($param['station_near_by'])) {
                $param['station_near_by'] = '';
            }
            if (!isset($param['business_hours'])) {
                $param['business_hours'] = '';
            }
            if (!isset($param['regular_holiday'])) {
                $param['regular_holiday'] = '';
            }
            if (!isset($param['place_memo'])) {
                $param['place_memo'] = '';
            }
        }        
        // set value
        $self->set('language_type', $param['language_type']);        
        if (isset($param['place_id'])) {
            $self->set('place_id', $param['place_id']);
        }
        if (isset($param['name'])) {
            $self->set('name', $param['name']);
        }
        if (isset($param['name_kana'])) {
            $self->set('name_kana', $param['name_kana']);
        }
        if (isset($param['address'])) {
            $self->set('address', $param['address']);
        }
        if (isset($param['tel']) && $param['tel'] !== null) {
            $self->set('tel', $param['tel']);
        }
        if (isset($param['station_near_by'])) {
            $self->set('station_near_by', $param['station_near_by']);
        }
        if (isset($param['business_hours'])) {
            $self->set('business_hours', $param['business_hours']);
        }
        if (isset($param['regular_holiday'])) {
            $self->set('regular_holiday', $param['regular_holiday']);
        }
        if (isset($param['place_memo'])) {
            $self->set('place_memo', $param['place_memo']);
        }  
        // save to database
        if ($self->save()) {            
            Model_Place::DeleteCacheDetail($param,__METHOD__);
            return !empty($self->get('place_id')) ? $self->get('place_id') : 0;
        }
        return false;
    }

    /**
     * Get list Place Information (using array count)
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array List Place Information
     */
    public static function get_list($param)
    {
        $query = DB::select(
            self::$_table_name . '.*'
        )
            ->from(self::$_table_name)
            ->join('places')
            ->on(self::$_table_name . '.place_id', '=', 'places.id');
        // filter by keyword
        if (!empty($param['place_id'])) {
            $query->where(self::$_table_name . '.place_id', '=', $param['place_id']);
        }
        if (!empty($param['name'])) {
            $query->where(self::$_table_name . '.name', 'LIKE', "%{$param['name']}%");
        }
        if (!empty($param['name_kana'])) {
            $query->where(self::$_table_name . '.name_kana', 'LIKE', "%{$param['name_kana']}%");
        }
        if (!empty($param['address'])) {
            $query->where(self::$_table_name . '.address', 'LIKE', "%{$param['address']}%");
        }
        if (!empty($param['tel'])) {
            $query->where(self::$_table_name . '.tel', 'LIKE', "%{$param['tel']}%");
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
     * Get all Place Information (without array count)
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array List Place Information
     */
    public static function get_all($param)
    {
        $query = DB::select(
            self::$_table_name . '.*'
        )
            ->from(self::$_table_name)
            ->join('places')
            ->on(self::$_table_name . '.place_id', '=', 'places.id')
            ->where(self::$_table_name . '.disable', '=', '0');
        // filter by keyword
        if (!empty($param['place_id'])) {
            $query->where(self::$_table_name . '.place_id', '=', $param['place_id']);
        }
        if (!empty($param['language_type'])) {
            $query->where(self::$_table_name . '.language_type', '=', $param['language_type']);
        }
        $query->order_by(self::$_table_name . '.id', 'ASC');
        // get data
        $data = $query->execute(self::$slave_db)->as_array();
        return $data;
    }

    /**
     * Get all Place Information (without array count)
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array List Place Information
     */
    public static function merge_info($places = array(), $language_type = 1, $keyword = '', $key = 'id', $selectMap = null)
    {
        if (empty($places)) { 
            return array();
        }
        $get_one = false;
        if (empty($places[0])) {
            $places = array($places);
            $get_one = true;
        }        
        $placeIdArray = Lib\Arr::field($places, $key);        
        $select = array(
            array(self::$_table_name . '.place_id', 'place_id'),
            array(self::$_table_name . '.name', 'name'),
            array(self::$_table_name . '.name_kana', 'name_kana'),
            array(self::$_table_name . '.address', 'address'),
            array(self::$_table_name . '.tel', 'tel'),
            array(self::$_table_name . '.station_near_by', 'station_near_by'),
            array(self::$_table_name . '.business_hours', 'business_hours'),
            array(self::$_table_name . '.regular_holiday', 'regular_holiday'),
            array(self::$_table_name . '.place_memo', 'place_memo'),
            array(self::$_table_name . '.language_type', 'language_type'),
        );
        if (!empty($selectMap)) {  
            foreach ($select as &$sel) {
                if (isset($selectMap[$sel[0]])) {
                    $sel[1] = $selectMap[$sel[0]];
                }
            }
            unset($sel);
        }
        $query = DB::select_array($select)        
            ->from(self::$_table_name)         
            ->where(self::$_table_name . '.disable', '0')
            ->where(self::$_table_name . '.place_id', 'IN', $placeIdArray)
            ->order_by(self::$_table_name . '.place_id', 'ASC')
            ->order_by(self::$_table_name . '.language_type', 'ASC');   
        if (!empty($keyword)) {
            $query->and_where_open(); 
            $query->where('place_informations.name', 'LIKE', "%{$keyword}%");
            $query->or_where('place_informations.name_kana', 'LIKE', "%{$keyword}%");
            $query->where_close();
        }
        $items = $query->execute(self::$slave_db)->as_array();
        if (empty($items)) {
            return array();
        }
        $data = array();
        foreach ($items as $item) {
            if ($item['language_type'] == $language_type) {
                $data[$item['place_id']] = $item;
                //break;
            }
        }        
        foreach ($items as $item) {
            if (!isset($data[$item['place_id']])) {
                if (!isset($data['place_id'])) {
                    $data[$item['place_id']] = $item;
                }
            }
        }
        foreach ($places as &$place) {            
            if (isset($data[$place[$key]])) {                
                $place = array_merge($place, $data[$place[$key]]);                
            }
            if (!empty($place['name'])) {
                $place['name'] = \Lib\Str::number2Bytes($place['name']);
            }
            if (!empty($place['address'])) {
                $place['address'] = \Lib\Str::number2Bytes($place['address']);
            }
            if (!empty($place['place_name'])) {
                $place['place_name'] = \Lib\Str::number2Bytes($place['place_name']);
            }
            if (!empty($place['place_address'])) {
                $place['place_address'] = \Lib\Str::number2Bytes($place['place_address']);
            }
        }
        unset($place);
        if ($get_one == true && !empty($places[0])) {
            return $places[0];
        }
        return $places;
    }
    
    /**
     * Disable/Enable list Place Information
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
                $param['place_id'] = $place['place_id'];
                Model_Place::DeleteCacheDetail($param,__METHOD__);
            } else {
                self::errorNotExist('place_information_id');
                return false;
            }
        }
        return true;
    }

    /**
     * Get detail Place Information
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array|bool Detail Place Information or false if error
     */
    public static function get_detail($param)
    {
        $data = self::find($param['id']);
        if (empty($data)) {
            static::errorNotExist('place_information_id');
            return false;
        }
        return $data;
    }
    
}
