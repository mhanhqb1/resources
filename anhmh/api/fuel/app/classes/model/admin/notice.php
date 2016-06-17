<?php

/**
 * Admin notices
 *
 * @package Model
 * @version 1.0
 * @author Thai Lai
 * @copyright Oceanize INC
 */
class Model_Admin_Notice extends Model_Abstract {

    protected static $_properties = array(
        'id',
        'admin_id',
        'title',
        'message',
        'url',
        'start_date',
        'end_date',
        'created',
        'updated',
        'disable',
        'priority',
        'date',
        'language_type'
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
    
    protected static $_table_name = 'admin_notices';
    
    /**
     * Enable/disable a or any push messages.
     *
     * @author Thai Lai
     * @param array $param Input data.
     * @return bool Returns the boolean.
     */
    public static function disable($param) {
        if (empty($param['id'])) {
            return false;
        }
        $ids = explode(',', $param['id']);
        foreach ($ids as $id) {
            $self = self::find($id);
            if ($self) {
                $self->set('disable', $param['disable']);
                if (!$self->update()) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Get list notices
     *
     * @author Thai Lai
     * @param array $param Input data
     * @return array List notice
     */
    public static function get_list($param) { 
        $query = DB::select(
                'id',
                'title',
                'message',
                'url',
                'priority',
                DB::expr("IF(date <= 0 OR date IS NULL, '', FROM_UNIXTIME(date, '%Y-%m-%d')) AS date"),
                DB::expr("IF(start_date <= 0 OR start_date IS NULL, '', FROM_UNIXTIME(start_date, '%Y-%m-%d')) AS start_date"),
                DB::expr("IF(end_date <= 0 OR end_date IS NULL, '', FROM_UNIXTIME(end_date, '%Y-%m-%d')) AS end_date"),
                'language_type'
            )
            ->from(
                self::$_table_name          
            );
        if (!empty($param['language_type'])) {
            $query->where('language_type', '=', $param['language_type']);
        }
        if (!empty($param['title'])) {
            $query->where('title', 'LIKE', "%{$param['title']}%");
        }
        if (!empty($param['message'])) {
            $query->where('message', 'LIKE', "%{$param['message']}%");
        }
        if (!empty($param['url'])) {
            $query->where('url', 'LIKE', "%{$param['url']}%");
        }        
        if (isset($param['disable']) && $param['disable'] != '') {
            $query->where(self::$_table_name . '.disable', '=', $param['disable']);
        }
        if (!empty($param['date_from'])) {
            $query->where(self::$_table_name . '.date', '<=', self::date_from_val($param['date_from']));
        }
        if (!empty($param['date_to'])) {
            $query->where(self::$_table_name . '.date', '>=', self::date_to_val($param['date_to']));
        }
        /*
        if (!empty($param['date_from'])) {
            $query->and_where_open(); 
            $query->where(self::$_table_name . '.start_date', '=', null);
            $query->or_where(self::$_table_name . '.start_date', '<=', self::date_from_val($param['date_from']));
            $query->where_close();
        }
        if (!empty($param['date_to'])) {
            $query->and_where_open(); 
            $query->where(self::$_table_name . '.end_date', '=', null);
            $query->or_where(self::$_table_name . '.end_date', '>=', self::date_to_val($param['date_to']));
            $query->where_close();
        }
         * 
         */
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
     * Get all notices
     *
     * @author Thai Lai
     * @param array $param Input data
     * @return array List notice
     */
    public static function get_all($param = array()) {        
        $query = DB::select(
                'id',
                'title',
                'message',
                'url',
                'priority',
                'updated',
                DB::expr("FROM_UNIXTIME(date, '%Y-%m-%d') AS date"),
                'language_type'
            )
            ->from(
                self::$_table_name          
            )        
            ->where('disable', '0')            
            ->and_where_open()
            ->where(self::$_table_name . '.start_date', '=', null) 
            ->or_where(self::$_table_name . '.start_date', '<=', time())
            ->where_close()
            ->and_where_open()
            ->where(self::$_table_name . '.end_date', '=', null) 
            ->or_where(self::$_table_name . '.end_date', '>=', time())
            ->where_close();
        
        if (!empty($param['language_type'])) {
            $query->where(self::$_table_name . '.language_type', '=', $param['language_type']);
        }
        
        $query->order_by('priority', 'DESC')
            ->order_by('date', 'DESC');
        
        return $query->execute(self::$slave_db)->as_array();
    }
    
    /**
     * Add or update
     *
     * @author thailh
     * @param array $param Input data.
     * @throws Exception If the provided is not of type array.
     * @return bool|int Returns the boolean or the integer.
     */
    public static function add_update($param) {

        //check id if existing
        $id = !empty($param['id']) ? $param['id'] : 0;
        $self = new self;
        if (!empty($id)) {
            $self = self::find($id);
            if (empty($self)) {
                static::errorNotExist('id', $id);
                return false;
            }
        }
        if (isset($param['language_type'])) {
            $self->set('language_type', $param['language_type']);
        }
        if (isset($param['admin_id'])) {
            $self->set('admin_id', $param['admin_id']);
        }
        if (isset($param['title'])) {
            $self->set('title', $param['title']);
        }       
        if (isset($param['message'])) {
            $self->set('message', $param['message']);
        }       
        if (isset($param['url'])) {
            $self->set('url', $param['url']);
        }  
        if (isset($param['priority'])) {
            $self->set('priority', $param['priority']);
        }  
        if (isset($param['date'])) {
            $self->set('date', self::time_to_val($param['date']));
        }
        if (isset($param['start_date']) && $param['start_date'] !== '') {
    		$self->set('start_date', self::time_to_val($param['start_date']));
    	} else {
            $self->set('start_date', null);
        }
        if (isset($param['end_date']) && $param['end_date'] !== '') {
    		$self->set('end_date', self::time_to_val($param['end_date']));
    	} else {
            $self->set('end_date', null);
        }
        if ($self->save()) {
            if (empty($self->id)) {
                $self->id = self::cached_object($self)->_original['id'];
            }
            return !empty($self->id) ? $self->id : 0;
        }
        return false;
    }
    
    /**
     * Get detail
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array|bool Detail or false if error
     */
    public static function get_detail($param)
    {  
        $data = self::find($param['id']); 
        if (empty($data)) {
            self::errorNotExist('id');
            return false;
        }
        return $data;
    }
    
}
