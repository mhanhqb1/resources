<?php

/**
 * Any query in Model Place Pin
 *
 * @package Model
 * @created 2015-06-30
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Model_Place_Pin extends Model_Abstract
{
    /** @var array $_properties field of table */
    protected static $_properties = array(
        'id',
        'user_id',
        'place_id',
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
    protected static $_table_name = 'place_pins';

    /**
     * Add info for Place Pin
     *
     * @author Le Tuan Tu
     * @param array $param Input data.
     * @return int|bool Place Pin id or false if error
     */
    public static function add($param)
    {
        // add a place to Bmaps database
        $location = explode(',', $param['location']);
        if (count($location) != 2) {
            self::errorParamInvalid('location');
            return false;
        }
        $placeId = Model_Place::add_update(
            array(
                'place_category_type_id'     => !empty($param['place_category_type_id']) ? $param['place_category_type_id'] : 0,
                'place_sub_category_type_id' => 0,
                'google_place_id'            => '',
                'google_category_name'       => '',
                'google_scope'               => '',
                'google_postal_code'         => '',
                'name'                       => !empty($param['name']) ? $param['name'] : '',
                'name_kana'                  => '',
                'latitude'                   => $location[0],
                'longitude'                  => $location[1],
                'review_point'               => '0',
                'entrance_steps'             => '-1',
                'is_flat'                    => '-1',
                'is_spacious'                => '-1',
                'is_silent'                  => '-1',
                'is_bright'                  => '-1',
                'is_universal_manner'        => '-1',
                'count_parking'              => '-1',
                'count_wheelchair_parking'   => '-1',
                'count_wheelchair_rent'      => '-1',
                'count_babycar_rent'         => '-1',
                'count_elevator'             => '-1',
                'count_wheelchair_wc'        => '-1',
                'count_ostomate_wc'          => '-1',
                'count_nursing_room'         => '-1',
                'count_smoking_room'         => '-1',
                'count_plug'                 => '-1',
                'count_wifi'                 => '-1',
                'count_follow'               => '0',
                'count_favorite'             => '0',
                'count_review'               => '0',
                'with_assistance_dog'         => '-1',                
                'with_credit_card'           => '-1',
                'with_emoney'                => '-1',
                'address'                    => !empty($param['address']) ? $param['address'] : '',
                'tel'                        => '',
                'language_type'              => $param['language_type'],
                'login_user_id'              => $param['login_user_id']
            )
        );
        if (empty($placeId)) {
            static::errorNotExist('place_id');
            return false;
        }
        $dataUpdate = array(
            'place_id' => $placeId,
            'user_id'  => $param['login_user_id']
        );
        $self = new self($dataUpdate, true);
        if ($self->save()) {
            if (empty($self->id)) {
                $self->id = self::cached_object($self)->_original['id'];
            }
            Model_User_Point::add(array(
                'user_id' => $param['login_user_id'],
                'type' => 2, // see config user_points_type
                'place_id' => $placeId,
                'review_id' => 0,
                'comment_id' => 0
            ));
            
            // KienNH 2016/03/23 begin
            $point_get_id = \Config::get('point_gets.id.add_spot');
            $point_gets = Model_Point_Get::find($point_get_id);
            if (!empty($point_gets)) {
                Model_User_Point_Log::add(array(
                    'user_id' => $param['login_user_id'],
                    'type' => \Config::get('user_point_logs.type.add_spot'),
                    'place_id' => $placeId,
                    'point' => $point_gets['point'],
                    'point_get_id' => $point_gets['id'],
                ));
            }
            // KienNH end
            
            if (self::error()) {
                return false;
            }
            return $self->id;
        }
        return false;
    }

    /**
     * Get list Place Pin (using array count)
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array List Place Pin
     */
    public static function get_list($param)
    {
        $query = DB::select(
            array('users.name', 'user_name'),
            self::$_table_name.'.*'
        )
            ->from(self::$_table_name)
            ->join('places')
            ->on(self::$_table_name.'.place_id', '=', 'places.id')
            ->join('users')
            ->on(self::$_table_name.'.user_id', '=', 'users.id')
            ->where('places.disable', '=', '0');
        // filter by keyword
        if (!empty($param['place_id'])) {
            $query->where('place_id', '=', $param['place_id']);
        }
        if (!empty($param['user_id'])) {
            $query->where(self::$_table_name.'.user_id', '=', $param['user_id']);
        }
        if (isset($param['disable']) && $param['disable'] != '') {
            $query->where(self::$_table_name.'.disable', '=', $param['disable']);
        }
        if (!empty($param['sort'])) {
            // KienNH 2016/04/20 check valid sort
            if (!self::checkSort($param['sort'])) {
                self::errorParamInvalid('sort');
                return false;
            }
            
            $sortExplode = explode('-', $param['sort']);
            $query->order_by(self::$_table_name.'.'.$sortExplode[0], $sortExplode[1]);
        } else {
            $query->order_by(self::$_table_name.'.created', 'DESC');
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
     * Disable a Place Pin
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


    /**
     * Get list Place Pin (using array count)
     *
     * @author Caolp
     * @param array $param Input data
     * @return array List Place Pin
     */
    public static function get_for_profile($param)
    {
        $query = DB::select(
                array('place_pins.place_id', 'id'),
                'place_pins.place_id',
                'places.place_category_type_id',
                'places.place_sub_category_type_id',
                'places.google_place_id',
                'places.google_category_name',                
                'places.latitude',
                'places.longitude',
                'places.review_point',
                'places.entrance_steps',
                'places.is_flat',
                'places.is_spacious',
                'places.is_silent',
                'places.is_bright',
                'places.is_universal_manner',
                'places.count_parking',
                'places.count_wheelchair_parking',
                'places.count_wheelchair_rent',
                'places.count_babycar_rent',
                'places.count_elevator',
                'places.count_wheelchair_wc',
                'places.count_ostomate_wc',
                'places.count_nursing_room',
                'places.count_smoking_room',
                'places.count_plug',
                'places.count_wifi',
                'places.count_follow',                             
                'places.count_review',                             
                'places.count_favorite',                             
                'places.with_credit_card',
                'places.with_emoney',
                'places.with_assistance_dog'
            )
            ->from('places')            
            ->join('place_pins')
            ->on('places.id', '=', 'place_pins.place_id')
            ->where('places.disable', '=', 0)           
            ->where('place_pins.disable', '=', 0)
            ->where('place_pins.user_id', '=', $param['user_id']);
        if (!empty($param['place_category_type_id'])) { 
            $query->where('places.place_category_type_id', '=', $param['place_category_type_id']);
        }
        if (!empty($param['place_sub_category_type_id'])) {
            $query->where('places.place_sub_category_type_id', '=', $param['place_sub_category_type_id']);
        }
        if (!empty($param['page']) && !empty($param['limit'])) {
            $offset = ($param['page'] - 1) * $param['limit'];
            $query->limit($param['limit'])->offset($offset);
        }        
        $places = $query->execute(self::$slave_db)->as_array();
        $total = !empty($places) ? DB::count_last_query(self::$slave_db) : 0;
        $data = Model_Place_Information::merge_info(
            $places,
            $param['language_type'],
             '',
            'place_id'
        );        
        $placeId = Lib\Arr::field($data, 'place_id');
        $images = Model_Place_Image::get_all(
            array(
                'place_id' => $placeId,
                'is_default' => 1,               
            )
        );
        foreach ($data as &$row) {
            $image = Lib\Arr::filter($images, 'place_id', $row['place_id'], false, false);
            if (!empty($image[0])) {
                $row['place_image_path'] = $image[0]['image_path'];
                $row['place_thm_image_path'] = $image[0]['thm_image_path'];
            }                   
        }
        return array('total' => $total, 'data' => $data);
    }

}