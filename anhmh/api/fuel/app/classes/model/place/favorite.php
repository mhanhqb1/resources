<?php

/**
 * Any query in Model Place Favorite
 *
 * @package Model
 * @created 2015-06-26
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Model_Place_Favorite extends Model_Abstract
{
    /** @var array $_properties field of table */
    protected static $_properties = array(
        'id',
        'user_id',
        'place_id',
        'favorite_type',
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
    protected static $_table_name = 'place_favorites';

    /**
     * Add info for Place Favorite
     *
     * @author Le Tuan Tu
     * @param array $param Input data.
     * @return int|bool Place Favorite id or false if error
     */
    public static function add($param)
    {
        $query = DB::select(
                array('places.id', 'place_id'),
                array('place_favorites.id', 'favorite_id'),
                array('place_favorites.user_id', 'user_id'),
                array('place_favorites.favorite_type', 'favorite_type'),
                array('place_favorites.disable', 'favorite_disable')
            )
            ->from('places')
            ->join(
                DB::expr(
                    "(SELECT * FROM place_favorites
                     WHERE user_id = {$param['login_user_id']}) AS place_favorites"
                ),
                'LEFT'
            )
            ->on('places.id', '=', 'place_favorites.place_id')
            ->where('places.id', '=', $param['place_id'])
            ->where('places.disable', '=', '0');
        $data = $query->execute()->offsetGet(0);
        if (empty($data['place_id'])) {
            self::errorNotExist('place_id');
            return false;
        }
        if (!empty($data['user_id']) 
            && $data['favorite_disable'] == 0 
            && ($data['favorite_type'] & $param['favorite_type'])) {
            self::errorDuplicate('user_id');
            return false;
        }        
        $new = false;
        if (!empty($data['user_id'])) {            
            $dataUpdate = array(
                'id' => $data['favorite_id'],
                'favorite_type' => $param['favorite_type'],
                'disable' => '0'
            );
            if ($data['favorite_disable'] == 1) {
                $dataUpdate['disable'] = '0';
            }
            if (($data['favorite_disable']&$param['favorite_type']) == 0) {
                $dataUpdate['favorite_type'] = ($data['favorite_type'] | $param['favorite_type']);
            }
        } else {
            $new = true;
            $dataUpdate = array(
                'place_id' => $data['place_id'],
                'user_id' => $param['login_user_id'],
                'favorite_type' => $param['favorite_type']
            );
        }            
        $favorite = new self($dataUpdate, $new);
        $favorite->set('favorite_type', (string) $favorite->get('favorite_type'));
        if ($favorite->save()) {
            if ($new == true) {
                $favorite->id = self::cached_object($favorite)->_original['id'];
            }
            return $favorite->id;
        }
        return false;
    }

    /**
     * Get list Place Favorite (using array count)
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array List Place Favorite
     */
    public static function get_list($param)
    {
        $query = DB::select(
                array('users.name', 'user_name'),
                array('users.image_path', 'user_image_path'),
                self::$_table_name . '.*',
                DB::expr(" 0 AS is_review")
            )
            ->from(self::$_table_name)
            ->join('places')
            ->on(self::$_table_name . '.place_id', '=', 'places.id')
            ->join('users')
            ->on(self::$_table_name . '.user_id', '=', 'users.id')
            ->join('place_informations')
            ->on(self::$_table_name.'.place_id', '=', 'place_informations.place_id')
            ->and_on('place_informations.language_type', '=', "'{$param['language_type']}'")
            ->and_on('place_informations.disable', '=', "'0'")
            ->where('places.disable', '=', '0');
        // filter by keyword
        if (!empty($param['placeid'])) {
            $query->where(self::$_table_name . '.place_id', '=', $param['placeid']);
        }
        if (!empty($param['user_id'])) {
            $query->where(self::$_table_name . '.user_id', '=', $param['user_id']);
        }
        if (!empty($param['favorite_type'])) {
            $query->where(self::$_table_name . '.favorite_type', '=', $param['favorite_type']);
        }
        if (!empty($param['multi_user'])) {
            $query->where(DB::expr(" user_id IN ({$param['multi_user']}) "));
        }
        if (!empty($param['multi_place'])) {
            $query->where(DB::expr(" place_id IN ({$param['multi_place']}) "));
        }
        if (isset($param['disable']) && $param['disable'] != '') {
            $query->where(self::$_table_name . '.disable', '=', $param['disable']);
        }
        if (!empty($param['sort'])) {
            // KienNH 2016/04/20 check valid sort
            if(!self::checkSort($param['sort'])) {
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
        // AnhMH 16/05/26 add filter placename and username
        if (!empty($param['placename'])) {
            $query->where('place_informations.name', 'LIKE', '%' . $param['placename'] . '%');
        }
        if (!empty($param['username'])) {
            $query->where('users.name', 'LIKE', '%' . $param['username'] . '%');
        }
        // get data
        $data = $query->execute(self::$slave_db)->as_array();
        $total = !empty($data) ? DB::count_last_query(self::$slave_db) : 0;
        if (isset($param['get_place_information'])) {
            $data = Model_Place_Information::merge_info(
                $data, 
                $param['language_type'],
                '',
                'place_id'
            );        
        }
        return array('total' => $total, 'data' => $data);
    }

    /**
     * Disable a Place Favorite
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
                'user_id'  => $param['user_id'],
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
     * Get list Place Favorite (using array count)
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array List Place Favorite
     */
    public static function get_all($param)
    {
        $query = DB::select(
            array('places.id', 'id'),
            'places.google_place_id',
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
            'places.count_favorite',
            'places.with_assistance_dog',
            'places.with_credit_card',
            'places.with_emoney',           
            'place_images.thm_image_path',
            array('place_categories.type_id', 'place_category_type_id'),
            array('place_categories.id', 'place_category_id'),
            array('place_categories.name', 'place_category_name'),
            array('place_sub_categories.id', 'place_sub_category_id'),
            array('place_sub_categories.name', 'place_sub_category_name'),
            array('place_images.image_path', 'place_image_path'),
            array('place_images.thm_image_path', 'place_thm_image_path')
        )
            ->from('places')            
            ->join(self::$_table_name)
            ->on('places.id', '=', self::$_table_name . '.place_id')
            ->join(DB::expr("
                (SELECT *
                     FROM place_categories
                     WHERE disable = 0
                         AND language_type = {$param['language_type']}) place_categories
            "), 'LEFT')
            ->on('place_categories.type_id', '=', 'places.place_category_type_id')
            ->join(DB::expr("(  SELECT * 
                                FROM place_sub_categories 
                                WHERE disable = 0 
                                AND language_type={$param['language_type']}
                            ) AS place_sub_categories"), 'LEFT')
            ->on('places.place_sub_category_type_id', '=', 'place_sub_categories.type_id')
            ->join(DB::expr("(  SELECT  place_id, 
                                        MIN(image_path) AS image_path, 
                                        MIN(thm_image_path) AS thm_image_path
                                FROM place_images 
                                WHERE disable = 0 
                                AND is_default = 1
                                GROUP BY place_id
                            ) AS place_images"), 'LEFT')
            ->on('places.id', '=', 'place_images.place_id')
            ->where('places.disable', '=', '0')           
            ->where(self::$_table_name . '.disable', '=', '0')
            ->where(self::$_table_name . '.user_id', '=', $param['login_user_id']);
        // filter by keyword
        if (!empty($param['place_category_type_id'])) {
            $query->where('places.place_category_type_id', '=', $param['place_category_type_id']);
        }
        if (!empty($param['favorite_type'])) {
            $query->where(DB::expr("favorite_type&{$param['favorite_type']}<>0"));   
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
        $query->limit($param['limit']);
        // get data
        $data = Model_Place_Information::merge_info(
            $query->execute(self::$slave_db)->as_array(),
            $param['language_type']
        );
        return $data;
    }

    /**
     * Get list Place Favorite and total
     *
     * @author thailh
     * @param array $param Input data
     * @return array List Place Favorite
     */
    public static function get_top($param)
    {
        if (empty($param['limit'])) {
            $param['limit'] = 15;
        }
        $query = DB::select(
                array(self::$_table_name . '.place_id', 'place_id'),               
                array('place_categories.type_id', 'place_category_type_id'),
                array('place_categories.id', 'place_category_id'),
                array('place_categories.name', 'place_category_name'),
                self::$_table_name . '.favorite_type',
                DB::expr("IF((favorite_type&1),1,0) AS want_to_visit"),
                DB::expr("IF((favorite_type&2),1,0) AS visited")
            )
            ->from(self::$_table_name)        
            ->join('places')
            ->on(self::$_table_name . '.place_id', '=', 'places.id')            
            ->join(
                DB::expr(
                    "(  SELECT *
                        FROM place_categories 
                        WHERE disable = 0 
                        AND language_type={$param['language_type']}
                    ) AS place_categories"
                ),
                'LEFT'
            )
            ->on('places.place_category_type_id', '=', 'place_categories.type_id')
            ->where('places.disable', '0')
            ->where(self::$_table_name . '.disable', '=', '0')
            ->where(self::$_table_name . '.user_id', '=', $param['login_user_id']);
        $query->order_by(self::$_table_name . '.created', 'DESC');
        $data = Model_Place_Information::merge_info(
            $query->execute(self::$slave_db)->as_array(), 
            $param['language_type'],
            '',
            'place_id'
        );   
        $result = array(
            'want_to_visit' => array(),            
            'visited' => array(),
            'count_want_to_visit' => 0,
            'count_visited' => 0,
        );
        if (!empty($data)) {
            $bg_by_category = array(
                1 => '#9DE457', // Mobility
                2 => '#A2C5D1', // Car
                3 => '#63CCFF', // Leisure
                4 => '#FFABAB', // Food
                5 => '#66CAA1', // Life
                6 => '#52A1F7', // Public
                7 => '#FFB2DA', // Wellness
                8 => '#FFE318', // Shop
            );                  
            $placeId = Lib\Arr::field($data, 'place_id');   
            // get place's images
            $images = Model_Place_Image::get_all(
                array(
                    'place_id' => $placeId,
                    'is_default' => '1',
                )
            );            
            foreach ($data as $row) {
                if (empty($row['name'])) {
                    $row['name'] = '';
                }
                if (!empty($row['name'])) {
                    $row['name'] = \Lib\Str::number2Bytes($row['name']);
                }
                if (!empty($row['address'])) {
                    $row['address'] = \Lib\Str::number2Bytes($row['address']);
                }
                $image = Lib\Arr::filter($images, 'place_id', $row['place_id'], false, false);
                if (!empty($image[0])) {
                    $row['image_path'] = $image[0]['image_path'];
                    $row['thm_image_path'] = $image[0]['thm_image_path'];
                }
                $row['image_bg'] = !empty($bg_by_category[$row['place_category_type_id']]) ? $bg_by_category[$row['place_category_type_id']] : '#FF791F';
                if (Lib\Str::is_japanese($row['name'])) {
                    $row['name_1'] = mb_substr($row['name'], 0, 1, "UTF-8");
                    $row['name_short'] = mb_substr($row['name'], 0, 24, "UTF-8");
                    if (mb_strlen($row['name'], "UTF-8") > 24) {
                        $row['name_short'] = $row['name_short'] . '...';
                    }
                } else {
                    $row['name_1'] = Lib\Str::truncate($row['name'], 1, '');
                    $row['name_short'] = Lib\Str::truncate($row['name'], 40, '...');
                }
                if ($row['want_to_visit'] == 1) {
                    $result['want_to_visit'][] = $row;
                }
                if ($row['visited'] == 1) {
                    $result['visited'][] = $row;
                }
            }
            unset($row);
        }
        $result['count_want_to_visit'] = count($result['want_to_visit']);
        $result['count_visited'] = count($result['visited']);
        $result['want_to_visit'] = array_slice($result['want_to_visit'], 0, $param['limit']);
        $result['visited'] = array_slice($result['visited'], 0, $param['limit']);
        return $result;    
    }
    
    /**
     * Disable when unwant to visit
     *
     * @author thailh
     * @param array $param Input data
     * @return bool Success or otherwise
     */
    public static function disable_by_wanttovisit($param)
    {             
        $options['where'] = array(
            'place_id' => $param['place_id'],
            'user_id' => $param['user_id'],            
            'disable' => '0',            
        );       
        $self = self::find('first', $options);
        if (!empty($self)) {
            switch ($self->get('favorite_type')) {
                case 2: // review only -> do nothing
                    return true; 
                case 1: // want to visit only
                    $self->set('disable', '1');
                    break;
                case 3: // want to visit + review
                    $self->set('favorite_type', '2');
                    break;
            }                      
            if (!$self->update()) {
                \LogLig::warning('Can not update . ' . self::$_table_name, __METHOD__, $param);                
                return false;
            }
            $param['place_id'] = $self['place_id'];
            Model_Place::DeleteCacheDetail($param,__METHOD__);
            return true;
        } else {           
            static::errorNotExist('user_id_or_place_id');            
        }
        return false;
    }


    /**
     * Count place want to visit or place visited by category
     *
     * @author thailh
     * @param array $param Input data
     * @return array List Place Favorite
     */
    public static function count_by_category($param)
    {
        $query = DB::select(
                'places.place_category_type_id',
                DB::expr('COUNT(place_id) AS count_place')
            )
            ->from('places')          
            ->join(self::$_table_name)
            ->on('places.id', '=', self::$_table_name . '.place_id')
            ->where('places.disable', '=', '0')           
            ->where(self::$_table_name . '.disable', '=', '0')         
            ->where(self::$_table_name . '.user_id', '=', $param['login_user_id'])
            ->group_by('places.place_category_type_id');
        // filter by keyword
        if (!empty($param['place_category_type_id'])) {
            if (!is_array($param['place_category_type_id'])) {
                $param['place_category_type_id'] = array($param['place_category_type_id']);
            }
            $query->where('places.place_category_type_id', 'IN', $param['place_category_type_id']);
        }
        if (!empty($param['favorite_type'])) {
            $query->where(DB::expr("favorite_type&{$param['favorite_type']}<>0"));            
        }
        $data = $query->execute(self::$slave_db)->as_array();
        return $data;
    }
    
}