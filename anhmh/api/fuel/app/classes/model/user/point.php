<?php

/**
 * Any query in Model User point
 *
 * @package Model
 * @created 2015-06-29
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Model_User_Point extends Model_Abstract
{
    /** @var array $_properties field of table */
    protected static $_properties = array(
        'id',
        'user_id',
        'type',
        'place_id',
        'review_id',
        'comment_id',
        'team_id',
        'point',
        'created',
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
    protected static $_table_name = 'user_points';

    /**
     * Add or update info for User point
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return int|bool User point id or false if error
     */
    public static function add($param)
    {            
        $user = Model_User::find($param['user_id']);
        if (empty($user)) {
            self::errorParamInvalid('user_id');
            return false;
        }
        if (empty($user->get('team_id'))) {
            return true;
        } else {
            $team = Model_Team::find($user->get('team_id'));
            if (empty($team)) {
                self::errorParamInvalid('team_id');
                return false;
            }
        }
        $self = new self;
        $self->set('user_id', $param['user_id']);
        $self->set('type', $param['type']);
        $self->set('team_id', $team->get('id'));
        if (isset(\Config::get('user_points_type')[$param['type']])) {
            $param['point'] = \Config::get('user_points_type')[$param['type']];
            if ($param['point'] == 0) {
                return true;
            }
        } else {
            self::errorParamInvalid('type');
            return false;
        }       
        if (isset($param['place_id'])) {
            $self->set('place_id', $param['place_id']);
        }
        if (isset($param['review_id'])) {
            $self->set('review_id', $param['review_id']);
        }
        if (isset($param['comment_id'])) {
            $self->set('comment_id', $param['comment_id']);
        }
        if (isset($param['point'])) {
            $self->set('point', $param['point']);
        }        
        // save to database
        if ($self->save()) {
            if (empty($self->id)) {
                $self->id = self::cached_object($self)->_original['id'];
            }
            $team->set('point', $team->get('point') + $param['point']);
            if (!$team->save()) {
                return false;
            }
            return !empty($self->id) ? $self->id : 0;
        }
        return false;
    }

    /**
     * Get list User point (using array count)
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array List User point
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
     * Get all User point (without array count)
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array List User point
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
     * Disable/Enable list User point
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return bool Success or otherwise
     */
    public static function disable($param)
    {
        $ids = explode(',', $param['id']);
        foreach ($ids as $id) {
            $self = self::find($id);
            if ($self) {
                $self->set('disable', $param['disable']);
                if (!$self->save()) {
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
     * Get detail User point
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array|bool Detail User point or false if error
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
