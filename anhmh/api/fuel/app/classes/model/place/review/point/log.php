<?php

/**
 * Any query in Model Place View Point Log
 *
 * @package Model
 * @created 2015-06-29
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Model_Place_Review_Point_Log extends Model_Abstract
{
    /** @var array $_properties field of table */
    protected static $_properties = array(
        'id',
        'user_id',
        'place_id',
        'place_review_id',
        'review_point',
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
    protected static $_table_name = 'place_review_point_logs';

    /**
     * Add info for Place View Point Log
     *
     * @author Le Tuan Tu
     * @param array $param Input data.
     * @return int|bool Place View Point Log id or false if error
     *
     */
    public static function add($param)
    {
        if (empty($param['place_id']) || !isset($param['review_point'])) {
            static::errorNotExist('place_id_or_review_point');
            return false;
        }
        if (isset($param['review_point']) && $param['review_point'] < 0) {
            static::errorParamInvalid('review_point');
            return false;
        }
        $self = self::find('first', array(
                'where' => array(
                    'place_id' => $param['place_id'],
                    'place_review_id' => $param['place_review_id'],
                    'user_id' => $param['login_user_id'],
                )
            )
        );
        if (empty($self)) {
            $self = new self;
        }
        $self->set('user_id', $param['login_user_id']);
        $self->set('review_point', $param['review_point']);
        if (isset($param['place_id'])) {
            $self->set('place_id', $param['place_id']);
        }
        if (isset($param['place_review_id'])) {
            $self->set('place_review_id', $param['place_review_id']);
        }
        // save to database
        if ($self->save()) {
            if (empty($self->id)) {
                $self->id = self::cached_object($self)->_original['id'];
            }
            return !empty($self->id) ? $self->id : 0;
        }
        return false;
    }

    /**
     * Get list Place View Point Log (using array count)
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array List Place View Point Log
     */
    public static function get_list($param)
    {
        $query = DB::select(
                self::$_table_name . '.*',
                array('users.name', 'user_name'),
                array('users.image_path', 'user_image_path')
            )
            ->from(self::$_table_name)
            ->join('places')
            ->on(self::$_table_name . '.place_id', '=', 'places.id')
            ->join('users')
            ->on(self::$_table_name . '.user_id', '=', 'users.id')
            ->where('places.disable', '=', '0');
        // filter by keyword
        if (!empty($param['place_id'])) {
            $query->where('place_id', '=', $param['place_id']);
        }
        if (!empty($param['place_review_id'])) {
            $query->where(self::$_table_name . '.place_review_id', '=', $param['place_review_id']);
        }
        if (!empty($param['user_id'])) {
            $query->where(self::$_table_name . '.user_id', '=', $param['login_user_id']);
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
     * Disable a Place View Point Log
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return bool Success or otherwise
     */
    public static function disable($param)
    {
        if (!isset($param['disable'])) {
            $param['disable'] = '1';
        }
        if (!empty($param['id'])) {
            $options['where'] = array(
                'id' => $param['id'],
            );
        } else {
            $options['where'] = array(
                'place_id' => $param['place_id'],
                'user_id'  => $param['login_user_id'],
                'disable'  => '0'
            );
        }
        $data = self::find('first', $options);
        if ($data) {
            $data->set('disable', $param['disable']);
            if ($data->update()) {
                return true;
            }
        } else {
            if (!empty($param['id'])) {
                static::errorNotExist('id');
            } else {
                static::errorNotExist('user_id_or_place_id');
            }
        }
        return false;
    }
}