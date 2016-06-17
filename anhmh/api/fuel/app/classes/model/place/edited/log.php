<?php

class Model_Place_Edited_Log extends Model_Abstract
{
    protected static $_properties = array(
        'id',
        'user_id',
        'language_type',
        'place_id',
        'name',
        'name_kana',
        'address',
        'tel',
        'station_near_by',
        'business_hours',
        'regular_holiday',
        'place_memo',
        'entrance_steps',
        'is_flat',
        'is_spacious',
        'is_silent',
        'is_bright',
        'is_universal_manner',
        'count_parking',
        'count_wheelchair_parking',
        'count_wheelchair_rent',
        'count_babycar_rent',
        'count_elevator',
        'count_wheelchair_wc',
        'count_ostomate_wc',
        'count_nursing_room',
        'count_smoking_room',
        'count_plug',
        'count_wifi',
        'with_assistance_dog',        
        'with_credit_card',
        'with_emoney',
        'created',
        'updated',
        'disable',
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

    protected static $_table_name = 'place_edited_logs';

    /**
     * Add or update info for Place_Edited_Log
     *
     * @author Caolp
     * @param array $param Input data
     * @return int|bool Place_Edited_Log id or false if error
     */
    public static function add($param)
    {
        $options = array('from_cache' => false);
        if (isset($param['login_user_id'])) {
            $options['where']['user_id'] = $param['login_user_id'];
        }
        if (isset($param['language_type'])) {
            $options['where']['language_type'] = $param['language_type'];
        }
        if (isset($param['place_id'])) {
            $options['where']['place_id'] = $param['place_id'];
        }
        if (isset($param['name'])) {
            $options['where']['name'] = $param['name'];
        }
        if (isset($param['name_kana'])) {
            $options['where']['name_kana'] = $param['name_kana'];
        }
        if (isset($param['address'])) {
            $options['where']['address'] = $param['address'];
        }
        if (isset($param['tel'])) {
            $options['where']['tel'] = $param['tel'];
        }
        if (isset($param['station_near_by'])) {
            $options['where']['station_near_by'] = $param['station_near_by'];
        }
        if (isset($param['business_hours'])) {
            $options['where']['business_hours'] = $param['business_hours'];
        }
        if (isset($param['regular_holiday'])) {
            $options['where']['business_hours'] = $param['business_hours'];
        }
        if (isset($param['place_memo'])) {
            $options['where']['place_memo'] = $param['place_memo'];
        }
        if (isset($param['entrance_steps'])) {
            $options['where']['entrance_steps'] = $param['entrance_steps'];
        }
        if (isset($param['is_flat'])) {
            $options['where']['is_flat'] = $param['is_flat'];
        }
        if (isset($param['is_spacious'])) {
            $options['where']['is_spacious'] = $param['is_spacious'];
        }
        if (isset($param['is_silent'])) {
            $options['where']['is_silent'] = $param['is_silent'];
        }
        if (isset($param['is_bright'])) {
            $options['where']['is_bright'] = $param['is_bright'];
        }
        if (isset($param['is_universal_manner'])) {
            $options['where']['is_universal_manner'] = $param['is_universal_manner'];
        }
        if (isset($param['count_parking'])) {
            $options['where']['count_parking'] = $param['count_parking'];
        }
        if (isset($param['count_wheelchair_parking'])) {
            $options['where']['count_wheelchair_parking'] = $param['count_wheelchair_parking'];
        }
        if (isset($param['count_wheelchair_rent'])) {
            $options['where']['count_wheelchair_rent'] = $param['count_wheelchair_rent'];
        }
        if (isset($param['count_babycar_rent'])) {
            $options['where']['count_babycar_rent'] = $param['count_babycar_rent'];
        }
        if (isset($param['count_elevator'])) {
            $options['where']['count_elevator'] = $param['count_elevator'];
        }
        if (isset($param['count_wheelchair_wc'])) {
            $options['where']['count_wheelchair_wc'] = $param['count_wheelchair_wc'];
        }
        if (isset($param['count_ostomate_wc'])) {
            $options['where']['count_ostomate_wc'] = $param['count_ostomate_wc'];
        }
        if (isset($param['count_nursing_room'])) {
            $options['where']['count_nursing_room'] = $param['count_nursing_room'];
        }
        if (isset($param['count_smoking_room'])) {
            $options['where']['count_smoking_room'] = $param['count_smoking_room'];
        }
        if (isset($param['count_plug'])) {
            $options['where']['count_plug'] = $param['count_plug'];
        }
        if (isset($param['count_wifi'])) {
            $options['where']['count_wifi'] = $param['count_wifi'];
        }
        if (isset($param['with_assistance_dog'])) {
            $options['where']['with_assistance_dog'] = $param['with_assistance_dog'];
        }        
        if (isset($param['with_credit_card'])) {
            $options['where']['with_credit_card'] = $param['with_credit_card'];
        }
        if (isset($param['with_emoney'])) {
            $options['where']['with_emoney'] = $param['with_emoney'];
        }
        $self = self::find('last', $options);
        if (empty($self)) {
            $self = new self($options['where'], $new = true);
        } else {
            $self->set('created', DB::expr("UNIX_TIMESTAMP()"));
        }
        if ($self->save()) {
            return $self->id;
        }
        return false;
    }

    /**
     * Get list Place_Edited_Log (using array count)
     *
     * @author Caolp
     * @param array $param Input data
     * @return array List Place_Edited_Log
     */
    public static function get_list($param)
    {
        $query = DB::select(
            self::$_table_name.'.*'
        )
            ->from(self::$_table_name);

        //		language_type,
        if (!empty($param['language_type'])) {
            $query->where(self::$_table_name.'.language_type', '=', $param['language_type']);
        }
        //id,
        if (!empty($param['id'])) {
            $query->where(self::$_table_name.'.id', '=', $param['id']);
        }
        //place_id,
        if (!empty($param['place_id'])) {
            $query->where(self::$_table_name.'.place_id', '=', $param['place_id']);
        }
        //name,
        if (!empty($param['name'])) {
            $query->where(self::$_table_name.'.name', '=', $param['name']);
        }
        //name_kana,
        if (!empty($param['name_kana'])) {
            $query->where(self::$_table_name.'.name_kana', '=', $param['name_kana']);
        }
        //address,
        if (!empty($param['address'])) {
            $query->where(self::$_table_name.'.address', '=', $param['address']);
        }
        //tel,
        if (!empty($param['tel'])) {
            $query->where(self::$_table_name.'.tel', '=', $param['tel']);
        }
        //		disable

        if (!empty($param['disable'])) {
            $query->where(self::$_table_name.'.disable', '=', $param['disable']);
        }
        if (!empty($param['page']) && !empty($param['limit'])) {
            $offset = ($param['page'] - 1) * $param['limit'];
            $query->limit($param['limit'])->offset($offset);
        }
        $query->order_by(self::$_table_name.'.id', 'ASC');
        // get data
        $data = $query->execute(self::$slave_db)->as_array();
        $total = !empty($data) ? DB::count_last_query(self::$slave_db) : 0;
        return array($total, $data);
    }

    /**
     * Get all Place_Edited_Log (without array count)
     *
     * @author Caolp
     * @return array List Place_Edited_Log
     */
    public static function get_all($param)
    {
        $query = DB::select(
            self::$_table_name.'.*'
        )
            ->from(self::$_table_name);
        //		language_type,
        if (!empty($param['language_type'])) {
            $query->where(self::$_table_name.'.language_type', '=', $param['language_type']);
        }
        //id,
        if (!empty($param['id'])) {
            $query->where(self::$_table_name.'.id', '=', $param['id']);
        }
        //place_id,
        if (!empty($param['place_id'])) {
            $query->where(self::$_table_name.'.place_id', '=', $param['place_id']);
        }
        //name,
        if (!empty($param['name'])) {
            $query->where(self::$_table_name.'.name', '=', $param['name']);
        }
        //name_kana,
        if (!empty($param['name_kana'])) {
            $query->where(self::$_table_name.'.name_kana', '=', $param['name_kana']);
        }
        //address,
        if (!empty($param['address'])) {
            $query->where(self::$_table_name.'.address', '=', $param['address']);
        }
        //tel,
        if (!empty($param['tel'])) {
            $query->where(self::$_table_name.'.tel', '=', $param['tel']);
        }
        //		disable

        if (!empty($param['disable'])) {
            $query->where(self::$_table_name.'.disable', '=', $param['disable']);
        }

        $query->order_by(self::$_table_name.'.id', 'ASC');
        // get data
        $data = $query->execute(self::$slave_db)->as_array();
        return $data;
    }

    /**
     * Disable/Enable list Place_Edited_Log
     *
     * @author Caolp
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
                self::errorNotExist('place_edited_log_id');
                return false;
            }
        }
        return true;
    }

    /**
     * Get detail Place_Edited_Log
     *
     * @author Caolp
     * @param array $param Input data
     * @return array|bool Detail Place_Edited_Log or false if error
     */
    public static function get_detail($param)
    {
        $data = self::find(
            'first',
            array(
                'where' => array(
                    array('id', '=', $param['id']),
                    array('place_id', '=', $param['place_id'])
                )
            )
        );
        if (empty($data)) {
            static::errorNotExist('place_id');

            return false;
        }

        return $data;
    }
}
