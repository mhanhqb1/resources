<?php

/**
 * Any query in Model Follow Place
 *
 * @package Model
 * @created 2015-06-29
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Model_Follow_Place extends Model_Abstract
{
    /** @var array $_properties field of table */
    protected static $_properties = array(
        'id',
        'user_id',
        'follow_place_id',
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
    protected static $_table_name = 'follow_places';

    /**
     * Add info for Follow Place
     *
     * @author Le Tuan Tu
     * @param array $param Input data.
     * @return int|bool Follow Place id or false if error
     *
     */
    public static function add($param)
    {
        if (empty($param['place_id'])) {
            static::errorNotExist('place_id');
            return false;
        }
        $query = DB::select(
                array('places.id', 'place_id'),
                array('follow_places.id', 'follow_id'),
                array('follow_places.user_id', 'user_id'),
                array('follow_places.disable', 'follow_disable')
            )
            ->from('places')
            ->join(
                DB::expr(
                    "(SELECT * FROM follow_places
                     WHERE user_id = {$param['login_user_id']}) AS follow_places"
                ),
                'LEFT'
            )
            ->on('places.id', '=', 'follow_places.follow_place_id')
            ->where('places.id', '=', $param['place_id'])
            ->where('places.disable', '=', '0');
        $data = $query->execute()->offsetGet(0);
        if (empty($data['place_id'])) {
            static::errorNotExist('place_id');
            return false;
        }
        if (!empty($data['user_id']) && $data['follow_disable'] == 0) {
            static::errorDuplicate('user_id');
            return false;
        }
        $new = false;
        if (!empty($data['user_id']) && $data['follow_disable'] == 1) {
            $dataUpdate = array(
                'id' => $data['follow_id'],
                'disable' => '0'
            );
        } else {
            $new = true;
            $dataUpdate = array(
                'follow_place_id' => $data['place_id'],
                'user_id' => $param['login_user_id']
            );
        }
        $self = new self($dataUpdate, $new);
        if ($self->save()) {
            if ($new == true) {
                $self->id = self::cached_object($self)->_original['id'];
            }
            return $self->id;
        }
        return false;
    }

    /**
     * Get list Follow Place (using array count)
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array List Follow Place
     */
    public static function get_list($param)
    {
        $query = DB::select(
            array('users.name', 'user_name'),
            self::$_table_name . '.*'
        )
            ->from(self::$_table_name)
            ->join('places')
            ->on(self::$_table_name . '.follow_place_id', '=', 'places.id')
            ->join('users')
            ->on(self::$_table_name . '.user_id', '=', 'users.id')
            ->where('places.disable', '=', '0');
        // filter by keyword
        if (!empty($param['follow_place_id'])) {
            $query->where(self::$_table_name . '.follow_place_id', '=', $param['follow_place_id']);
        }
        if (!empty($param['user_id'])) {
            $query->where(self::$_table_name . '.user_id', '=', $param['user_id']);
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
     * Disable a Follow Place
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
                'follow_place_id' => $param['place_id'],
                'user_id' => $param['user_id'],
                'disable' => '0'
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