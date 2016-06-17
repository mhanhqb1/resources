<?php

/**
 * Any query in Model Place Review
 *
 * @package Model
 * @created 2015-06-29
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Model_Place_Review extends Model_Abstract
{
    /** @var array $_properties field of table */
    protected static $_properties = array(
        'id',
        'user_id',
        'place_id',      
        'comment',
        'language_type',
        'count_like',
        'count_comment',
        'count_user_report',
        'created',
        'updated',
        'disable',
        'entrance_steps',
        'is_flat',
        'is_spacious',
        'is_silent',
        'is_bright',
        'count_parking',
        'count_wheelchair_parking',
        'count_elevator',
        'count_wheelchair_rent',
        'count_wheelchair_wc',
        'count_ostomate_wc',
        'count_nursing_room',
        'count_babycar_rent',
        'with_assistance_dog',
        'is_universal_manner',
        'with_credit_card',
        'with_emoney',
        'count_plug',
        'count_wifi',
        'count_smoking_room',
        'is_newest',
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
    protected static $_table_name = 'place_reviews';

    /**
     * Add or update info for Place Review
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return int|bool Place Review id or false if error
     */
    public static function add_update($param)
    {
        if (empty($param['review_point']) 
            && empty($param['comment']) 
            && empty($_FILES)
            && (!isset($param['entrance_steps']) || $param['entrance_steps'] === '' || $param['entrance_steps'] < 0)
            && (empty($param['is_flat']) && empty($param['is_spacious']) && empty($param['is_silent']) && empty($param['is_bright']) &&
                empty($param['count_parking']) && empty($param['count_wheelchair_parking']) && empty($param['count_elevator']) && empty($param['count_wheelchair_rent']) &&
                empty($param['count_wheelchair_wc']) && empty($param['count_ostomate_wc']) && empty($param['count_nursing_room']) && empty($param['count_babycar_rent']) &&
                empty($param['with_assistance_dog']) && empty($param['is_universal_manner']) && empty($param['with_credit_card']) && empty($param['with_emoney']) &&
                empty($param['count_plug']) && empty($param['count_wifi']) && empty($param['count_smoking_room']))) {
            self::errorParamInvalid('review_point_and_comment_and_images_and_entrance_steps_and_facilities');
            return false;
        }
        
        // check exist
        $new = empty($param['id']) ? true : false;
        if (!empty($param['id'])) {
            $place_review = self::find($param['id']);
            if (empty($place_review)) {
                self::errorNotExist('place_review_id');
                return false;
            }
            $param['place_id'] = $place_review->get('place_id');
        }
        
        $imagePath = array();
        if (!empty($_FILES)) {
            $uploadResult = \Lib\Util::uploadImage($thumb = 'places');            
            if ($uploadResult['status'] != 200) {
                self::setError($uploadResult['error']);            
                return false;
            }
            $imagePath = $uploadResult['body'];         
        }
        
        if (empty($param['place_id']) 
            && !empty($param['google_place_id'])) {
            if (empty($imagePath)) {
                $param['get_place_images'] = 1;
            }
            $param['place_id'] = Model_Place::add_place_by_google_place_id($param);
        }  
        if (empty($param['place_id'])) {
            static::errorNotExist('place_id');
            return false;
        }
        
        // Check 1 user 1 review
        if ($new) {
            $place_review = self::find('first', array(
                'where' => array(
                    'user_id' => $param['login_user_id'],
                    'place_id' => $param['place_id'],
                    'is_newest' => 1,
                    'disable' => 0
                )
            ));
            if (!empty($place_review)) {
                self::errorDuplicate('duplicate_review');
                return false;
            }
        }
        
        // Set old data
        DB::query("UPDATE place_reviews SET is_newest = 0 WHERE is_newest = 1 AND place_id = {$param['place_id']} AND user_id = {$param['login_user_id']}")->execute();
        
        // Alway create data
        $self = new self;
        
        if (empty($param['count_like'])) {
            $param['count_like'] = '0';
        }

        // set value     
        $self->set('user_id', $param['login_user_id']);
        $self->set('place_id', $param['place_id']);
        $self->set('comment', !empty($param['comment']) ? trim($param['comment']) : '');
        $self->set('language_type', $param['language_type']);
        
        $entrance_steps = -1;
        if (isset($param['entrance_steps']) && $param['entrance_steps'] !== '') {
            $entrance_steps = !empty($param['entrance_steps']) ? $param['entrance_steps'] : 0;
        }
        
        $self->set('entrance_steps', $entrance_steps);
        $self->set('is_flat', !empty($param['is_flat']) ? 1 : 0);
        $self->set('is_spacious', !empty($param['is_spacious']) ? 1 : 0);
        $self->set('is_silent', !empty($param['is_silent']) ? 1 : 0);
        $self->set('is_bright', !empty($param['is_bright']) ? 1 : 0);
        $self->set('count_parking', !empty($param['count_parking']) ? 1 : 0);
        $self->set('count_wheelchair_parking', !empty($param['count_wheelchair_parking']) ? 1 : 0);
        $self->set('count_elevator', !empty($param['count_elevator']) ? 1 : 0);
        $self->set('count_wheelchair_rent', !empty($param['count_wheelchair_rent']) ? 1 : 0);
        $self->set('count_wheelchair_wc', !empty($param['count_wheelchair_wc']) ? 1 : 0);
        $self->set('count_ostomate_wc', !empty($param['count_ostomate_wc']) ? 1 : 0);
        $self->set('count_nursing_room', !empty($param['count_nursing_room']) ? 1 : 0);
        $self->set('count_babycar_rent', !empty($param['count_babycar_rent']) ? 1 : 0);
        $self->set('with_assistance_dog', !empty($param['with_assistance_dog']) ? 1 : 0);
        $self->set('is_universal_manner', !empty($param['is_universal_manner']) ? 1 : 0);
        $self->set('with_credit_card', !empty($param['with_credit_card']) ? 1 : 0);
        $self->set('with_emoney', !empty($param['with_emoney']) ? 1 : 0);
        $self->set('count_plug', !empty($param['count_plug']) ? 1 : 0);
        $self->set('count_wifi', !empty($param['count_wifi']) ? 1 : 0);
        $self->set('count_smoking_room', !empty($param['count_smoking_room']) ? 1 : 0);
        $self->set('is_newest', 1);
        
        // save to database
        if ($self->save()) {
            self::update_place_entrance_steps_and_facility($param['place_id']);
            if (empty($self->id)) {
                $self->id = self::cached_object($self)->_original['id'];
            }
            if (!empty($self->id)) {
                $param['favorite_type'] = 2;
                $options['where'] = array(
                    'place_id' => $param['place_id'],
                    'user_id' => $param['login_user_id'],
                );
                $favorite = Model_Place_Favorite::find('first', $options);
                if (empty($favorite)) {
                    $favorite = new Model_Place_Favorite;
                    $favorite->set('place_id', $param['place_id']);
                    $favorite->set('user_id', $param['login_user_id']);
                    $favorite->set('favorite_type', $param['favorite_type']);
                    if (!$favorite->create()) {
                        return false;
                    }
                } elseif (($favorite->get('favorite_type')&2) == 0) {                   
                    $favorite->set('favorite_type', ($favorite->get('favorite_type') | $param['favorite_type']));
                    $favorite->set('disable', '0');
                    if (!$favorite->update()) {
                        return false;
                    }
                }
                if (isset($param['review_point'])) {
                    Model_Place_Review_Point_Log::add(
                        array(
                            'login_user_id' => $param['login_user_id'],
                            'place_id' => $param['place_id'],
                            'place_review_id' => $self->id,
                            'review_point' => $param['review_point'] ? $param['review_point'] : 0,
                        )
                    );
                    if (self::error()) {
                        return false;
                    }
                }
                if (!empty($imagePath)) {
                    Model_Place_Image::upload_images_for_review(
                        array(
                            'user_id' => $param['login_user_id'],
                            'place_id' => $param['place_id'],
                            'place_review_id' => $self->id,
                            'image_path' => $imagePath,
                        )
                    );
                    if (self::error()) {
                        return false;
                    }
                }
                if ($new) {
                    Model_User_Point::add(array(
                        'user_id' => $param['login_user_id'],
                        'type' => 1, // see config user_points_type
                        'place_id' => $param['place_id'],
                        'review_id' => $self->id,
                        'comment_id' => 0
                    ));
                    
                    // KienNH 2016/03/23 begin
                    $point_get_id = \Config::get('point_gets.id.review_spot');
                    $point_gets = Model_Point_Get::find($point_get_id);
                    if (!empty($point_gets)) {
                        Model_User_Point_Log::add(array(
                            'user_id' => $param['login_user_id'],
                            'type' => \Config::get('user_point_logs.type.review_spot'),
                            'place_id' => $param['place_id'],
                            'point' => $point_gets['point'],
                            'point_get_id' => $point_gets['id'],
                        ));
                    }
                    // KienNH end

                    if (self::error()) {
                        return false;
                    }
                }
            }
            // Reflesh cache and reload.
            Model_Place::DeleteCacheDetail($param,__METHOD__);
            if (isset($param['get_place_detail']) && $self->id > 0 && $self->get('place_id') > 0) {
                return Model_Place::get_detail(array(
                    'id' => $self->get('place_id'),
                    'language_type' => $self->get('language_type')
                ));
            }
            return !empty($self->id) ? $self->id : 0;
        }
        return false;
    }

    /**
     * Get list Place Review (using array count)
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array List Place Review
     */
    public static function get_list($param)
    {
        if (empty($param['user_id'])) {
            $param['user_id'] = 0;
        }
        if (empty($param['login_user_id'])) {
            $param['login_user_id'] = 0;
        }
        $query = DB::select(
                self::$_table_name.'.id',
                self::$_table_name.'.user_id',
                self::$_table_name.'.place_id',
                self::$_table_name.'.comment',
                self::$_table_name.'.created',
                self::$_table_name.'.disable',
                self::$_table_name.'.count_comment',
                self::$_table_name.'.count_like',
                self::$_table_name.'.count_user_report',
                'users.name',
                'users.image_path',
                'users.sex_id',
                'users.email',
                'users.birthday',
                'users.zipcode',
                DB::expr("IFNULL(place_review_point_logs.review_point, 0) AS review_point"),
                DB::expr("IF(ISNULL(place_review_likes.id),0,1) AS is_like"),
                DB::expr("IF(ISNULL(follow_users.id),0,1) AS is_follow_user"),
                DB::expr("place_informations.name as place_name"),// KienNH 2016/03/04 add place_informations
                DB::expr("place_informations.language_type as place_language"),
                
                self::$_table_name.'.entrance_steps',
                self::$_table_name.'.is_flat',
                self::$_table_name.'.is_spacious',
                self::$_table_name.'.is_silent',
                self::$_table_name.'.is_bright',
                self::$_table_name.'.count_parking',
                self::$_table_name.'.count_wheelchair_parking',
                self::$_table_name.'.count_elevator',
                self::$_table_name.'.count_wheelchair_rent',
                self::$_table_name.'.count_wheelchair_wc',
                self::$_table_name.'.count_ostomate_wc',
                self::$_table_name.'.count_nursing_room',
                self::$_table_name.'.count_babycar_rent',
                self::$_table_name.'.with_assistance_dog',
                self::$_table_name.'.is_universal_manner',
                self::$_table_name.'.with_credit_card',
                self::$_table_name.'.with_emoney',
                self::$_table_name.'.count_plug',
                self::$_table_name.'.count_wifi',
                self::$_table_name.'.count_smoking_room',
                self::$_table_name.'.is_newest',
                
                DB::expr("IF(ISNULL(has_reviews.total_review),0,1) AS has_review")
            )
            ->from(self::$_table_name)
            ->join('places')
            ->on(self::$_table_name.'.place_id', '=', 'places.id')
            ->join('place_informations')// KienNH 2016/03/04 : add join place_informations
            ->on(self::$_table_name.'.place_id', '=', 'place_informations.place_id')
            ->join('users')
            ->on(self::$_table_name.'.user_id', '=', 'users.id')
            ->join('place_review_point_logs', 'LEFT')
            ->on(self::$_table_name.'.place_id', '=', 'place_review_point_logs.place_id')
            ->on(self::$_table_name.'.id', '=', 'place_review_point_logs.place_review_id')
            ->on(self::$_table_name.'.user_id', '=', 'place_review_point_logs.user_id')
            ->join(
                DB::expr(
                    "
                        (SELECT *
                        FROM place_review_likes
                        WHERE user_id = {$param['login_user_id']}
                            AND disable = 0) place_review_likes
                    "
                ),
                'LEFT'
            )
            ->on(self::$_table_name.'.id', '=', 'place_review_likes.place_review_id')
            ->join(
                DB::expr(
                    "
                (SELECT *
                FROM follow_users
                WHERE user_id = {$param['login_user_id']}
                    AND disable = 0) follow_users
            "
                ),
                'LEFT'
            )
            ->on(self::$_table_name.'.user_id', '=', 'follow_users.follow_user_id')
            ->join(
                DB::expr(
                    "
                        (SELECT id, place_id, user_id, COUNT(*) AS total_review
                        FROM place_reviews
                        WHERE is_newest = 0
                        AND `disable` = 0
                        GROUP BY place_id, user_id) has_reviews
                    "
                ),
                'LEFT'
            )
            ->on(self::$_table_name.'.user_id', '=', 'has_reviews.user_id')
            ->and_on(self::$_table_name.'.place_id', '=', 'has_reviews.place_id')
            ->where(self::$_table_name.'.is_newest', '=', 1);
        // filter by keyword
        if (!empty($param['user_id'])) {
            $query->where(self::$_table_name.'.user_id', '=', $param['user_id']);
        }
        if (!empty($param['place_id'])) {
            $query->where(self::$_table_name.'.place_id', '=', $param['place_id']);
        }
        if (!empty($param['review_user_name'])) {// KienNH 2016/03/04 : name -> review_user_name
            $query->where('users.name', 'LIKE', "%{$param['review_user_name']}%");
        }
        if (!empty($param['place_name'])) {// KienNH 2016/03/04 : name_kana -> place_name
            $query->where('place_informations.name', 'LIKE', "%{$param['place_name']}%");
        }
        if (!empty($param['place_language_type'])) {// KienNH 2016/03/04 add language_type
            $query->where('place_informations.language_type', '=', $param['place_language_type']);
        }
        if (!empty($param['comment'])) {
            $query->where(self::$_table_name.'.comment', 'LIKE', "%{$param['comment']}%");
        }
        if (isset($param['disable']) && $param['disable'] !== '') {
            $_disable = !empty($param['disable']) ? 1 : 0;
            $query->where(self::$_table_name.'.disable', '=', $_disable);
        }
        if (isset($param['report']) && $param['report'] !== '') {
            $query->where(self::$_table_name.'.count_user_report', '>', 0);
            if ($param['report'] == 0) {      
                $query->where(self::$_table_name.'.disable', '=', 1);
            } else {
                $query->where(self::$_table_name.'.disable', '=', 0);
            }
        }
        // KienNH 2016/03/07 add search by point
        if (isset($param['point_from']) && is_numeric($param['point_from'])) {
            $query->where(DB::expr("IFNULL(place_review_point_logs.review_point, 0) >= {$param['point_from']}"));
        }
        if (isset($param['point_to']) && is_numeric($param['point_to'])) {
            $query->where(DB::expr("IFNULL(place_review_point_logs.review_point, 0) <= {$param['point_to']}"));
        }
        // KienNH end
        if (!empty($param['sort'])) {
            // KienNH 2016/04/20 check valid sort
            if (!self::checkSort($param['sort'], self::$_properties, 'review_point')) {
                self::errorParamInvalid('sort');
                return false;
            }
            
            $sortExplode = explode('-', $param['sort']);
            if ($sortExplode[0] == 'review_point') {
                $query->order_by('place_review_point_logs.'.$sortExplode[0], $sortExplode[1]);
            } else {
                $query->order_by(self::$_table_name.'.'.$sortExplode[0], $sortExplode[1]);
            }
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
        if (isset($param['get_place_images']) && !empty($data)) {
            // KienNH 20106/04/14 begin
            /*$placeReviewId = Lib\Arr::field($data, 'id');
            $images = Model_Place_Image::get_all(
                array(
                    'place_review_id' => $placeReviewId,
                )
            );
            foreach ($data as &$row) {
                $row['place_images'] = Lib\Arr::filter($images, 'place_review_id', $row['id'], false, false);
            }
            unset($row);*/
            
            $placeIds = Lib\Arr::field($data, 'place_id');
            $userIds = Lib\Arr::field($data, 'user_id');
            $images = Model_Place_Image::get_all(
                array(
                    'place_id' => $placeIds,
                    'user_id' => $userIds,
                    'review_image_only' => 1
                )
            );
            if (!empty($images)) {
                foreach ($data as &$row) {
                    $place_images = array();
                    foreach ($images as $image) {
                        if ($image['place_id'] == $row['place_id'] && $image['user_id'] == $row['user_id']) {
                            $place_images[] = $image;
                        }
                    }
                    $row['place_images'] = $place_images;
                }
                unset($row);
            }
            // KienNH end
        }
        return array('total' => $total, 'data' => $data);
    }

    /**
     * Get all Place Review (without array count)
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array List Place Review
     */
    public static function get_all($param)
    {
        if (empty($param['user_id'])) {
            $param['user_id'] = 0;
        }
        if (empty($param['login_user_id'])) {
            $param['login_user_id'] = 0;
        }
        $query = DB::select(
                self::$_table_name.'.id',
                self::$_table_name.'.user_id',
                self::$_table_name.'.place_id',
                self::$_table_name.'.comment',
                self::$_table_name.'.created',
                self::$_table_name.'.count_like',
                self::$_table_name.'.count_comment',
                'users.name',
                DB::expr("IFNULL(IF(users.image_path='',NULL,users.image_path),'" . \Config::get('no_image_user') . "') AS image_path"),
                'users.sex_id',
                'users.email',
                'users.birthday',
                'users.zipcode',
                DB::expr("IFNULL(users.user_physical_type_id, 0) AS user_physical_type_id"),
                DB::expr("IFNULL(place_review_point_logs.review_point, 0) AS review_point"),
                DB::expr("IF(ISNULL(place_review_likes.id),0,1) AS is_like"),
                DB::expr("IF(ISNULL(follow_users.id),0,1) AS is_follow_user"),
                
                self::$_table_name.'.entrance_steps',
                self::$_table_name.'.is_flat',
                self::$_table_name.'.is_spacious',
                self::$_table_name.'.is_silent',
                self::$_table_name.'.is_bright',
                self::$_table_name.'.count_parking',
                self::$_table_name.'.count_wheelchair_parking',
                self::$_table_name.'.count_elevator',
                self::$_table_name.'.count_wheelchair_rent',
                self::$_table_name.'.count_wheelchair_wc',
                self::$_table_name.'.count_ostomate_wc',
                self::$_table_name.'.count_nursing_room',
                self::$_table_name.'.count_babycar_rent',
                self::$_table_name.'.with_assistance_dog',
                self::$_table_name.'.is_universal_manner',
                self::$_table_name.'.with_credit_card',
                self::$_table_name.'.with_emoney',
                self::$_table_name.'.count_plug',
                self::$_table_name.'.count_wifi',
                self::$_table_name.'.count_smoking_room',
                self::$_table_name.'.is_newest',
                
                DB::expr("IF(ISNULL(has_reviews.total_review),0,1) AS has_review")
            )
            ->from(self::$_table_name)
            ->join('users')
            ->on(self::$_table_name.'.user_id', '=', 'users.id')
            ->join('place_review_point_logs', 'LEFT')
            ->on(self::$_table_name.'.place_id', '=', 'place_review_point_logs.place_id')
            ->on(self::$_table_name.'.id', '=', 'place_review_point_logs.place_review_id')
            ->on(self::$_table_name.'.user_id', '=', 'place_review_point_logs.user_id')
            ->join(
                DB::expr(
                    "
                        (SELECT *
                        FROM place_review_likes
                        WHERE user_id = {$param['login_user_id']}
                            AND disable = 0) place_review_likes
                    "
                ),
                'LEFT'
            )
            ->on(self::$_table_name.'.id', '=', 'place_review_likes.place_review_id')
            ->join(
                DB::expr(
                    "
                        (SELECT *
                        FROM follow_users
                        WHERE user_id = {$param['login_user_id']}
                            AND disable = 0) follow_users
                    "
                ),
                'LEFT'
            )
            ->on(self::$_table_name.'.user_id', '=', 'follow_users.follow_user_id')
            ->join(
                DB::expr(
                    "
                        (SELECT id, place_id, user_id, COUNT(*) AS total_review
                        FROM place_reviews
                        WHERE is_newest = 0
                        AND `disable` = 0
                        GROUP BY place_id, user_id) has_reviews
                    "
                ),
                'LEFT'
            )
            ->on(self::$_table_name.'.user_id', '=', 'has_reviews.user_id')
            ->and_on(self::$_table_name.'.place_id', '=', 'has_reviews.place_id')
            ->where(self::$_table_name.'.disable', '=', '0')
            ->where(self::$_table_name.'.is_newest', '=', 1);
        // filter by keyword
        if (!empty($param['user_id'])) {
            $query->where(self::$_table_name.'.user_id', '=', $param['user_id']);
        }
        if (!empty($param['place_id'])) {
            if (!is_array($param['place_id'])) {
                $param['place_id'] = array($param['place_id']);
            }
            $query->where(self::$_table_name.'.place_id', 'IN', $param['place_id']);
        }
        if (!empty($param['language_type'])) {
            //$query->where(self::$_table_name . '.language_type', '=', $param['language_type']);
        }
        if (!empty($param['limit'])) {
            $query->limit($param['limit'])->offset(0);
        }
        $query->order_by(self::$_table_name.'.created', 'DESC');
        $data = $query->execute(self::$slave_db)->as_array();

        if (isset($param['get_place_images']) && !empty($data)) {
            //$placeReviewId = Lib\Arr::field($data, 'id');
            $placeIds = Lib\Arr::field($data, 'place_id');
            $userIds = Lib\Arr::field($data, 'user_id');
            $images = Model_Place_Image::get_all(
                array(
                    'place_id' => $placeIds,
                    'user_id' => $userIds
                )
            );
            foreach ($data as &$row) {
                //$row['place_images'] = Lib\Arr::filter($images, 'place_review_id', $row['id'], false, false);
                $placeImages = array();
                foreach ($images as $image) {
                    if ($row['place_id'] == $image['place_id'] && $row['user_id'] == $image['user_id']) {
                        $placeImages[] = $image;
                    }
                }
                $row['place_images'] = $placeImages;
            }
            unset($row);
        }
        return $data;
    }

    /**
     * Disable/Enable list Place Review
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
                self::errorNotExist('place_review_id');
                return false;
            }
        }
        return true;
    }

    /**
     * Get detail Place Review
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array|bool Detail Place Review or false if error
     */
    public static function get_detail($param)
    {
        if (empty($param['login_user_id'])) {
            $param['login_user_id'] = 0;
        }
        $data = DB::select(
                self::$_table_name.'.id',
                self::$_table_name.'.user_id',
                self::$_table_name.'.comment',
                self::$_table_name.'.count_like',
                self::$_table_name.'.count_comment',
                self::$_table_name.'.created',
                self::$_table_name.'.place_id',
                'users.name',
                'users.image_path',
                'users.sex_id',
                'users.email',
                'users.birthday',
                'users.zipcode',
                DB::expr("IFNULL(place_review_point_logs.review_point, 0) AS review_point"),
                DB::expr("IF(ISNULL(place_review_likes.id),0,1) AS is_like"),
                DB::expr("IF(ISNULL(follow_users.id),0,1) AS is_follow_user"),
                
                self::$_table_name.'.entrance_steps',
                self::$_table_name.'.is_flat',
                self::$_table_name.'.is_spacious',
                self::$_table_name.'.is_silent',
                self::$_table_name.'.is_bright',
                self::$_table_name.'.count_parking',
                self::$_table_name.'.count_wheelchair_parking',
                self::$_table_name.'.count_elevator',
                self::$_table_name.'.count_wheelchair_rent',
                self::$_table_name.'.count_wheelchair_wc',
                self::$_table_name.'.count_ostomate_wc',
                self::$_table_name.'.count_nursing_room',
                self::$_table_name.'.count_babycar_rent',
                self::$_table_name.'.with_assistance_dog',
                self::$_table_name.'.is_universal_manner',
                self::$_table_name.'.with_credit_card',
                self::$_table_name.'.with_emoney',
                self::$_table_name.'.count_plug',
                self::$_table_name.'.count_wifi',
                self::$_table_name.'.count_smoking_room',
                self::$_table_name.'.is_newest'
            )
            ->from(self::$_table_name)
            ->join('users')
            ->on(self::$_table_name.'.user_id', '=', 'users.id')
            ->join('place_review_point_logs', 'LEFT')
            ->on(self::$_table_name.'.place_id', '=', 'place_review_point_logs.place_id')
            ->on(self::$_table_name.'.id', '=', 'place_review_point_logs.place_review_id')
            ->on(self::$_table_name.'.user_id', '=', 'place_review_point_logs.user_id')
            ->join(
                DB::expr(
                    "
                        (SELECT *
                        FROM place_review_likes
                        WHERE user_id = {$param['login_user_id']}
                            AND disable = 0) place_review_likes
                    "
                ),
                'LEFT'
            )
            ->on(self::$_table_name.'.id', '=', 'place_review_likes.place_review_id')
            ->join(
                DB::expr(
                    "
                (SELECT *
                FROM follow_users
                WHERE user_id = {$param['login_user_id']}
                    AND disable = 0) follow_users
            "
                ),
                'LEFT'
            )
            ->on(self::$_table_name.'.user_id', '=', 'follow_users.follow_user_id')
            //->where(self::$_table_name.'.disable', '=', '0')
            ->where(self::$_table_name.'.id', '=', $param['id'])
            ->execute(self::$slave_db)
            ->offsetGet(0);
        if (empty($data)) {
            static::errorNotExist('place_review_id');
            return false;
        }
        $data = Model_Place_Information::merge_info(
            $data,
            $param['language_type'],
             '',
            'place_id',           
            array(
                'place_informations.name' => 'place_name',
                'place_informations.name_kana' => 'place_name_kana',
                'place_informations.address' => 'place_address',
            )
        );
        if (isset($param['get_like'])) {
            $place_review_likes = Model_Place_Review_Like::get_all_by_place_review_id(
                array(
                    'place_review_id' => $param['id'],
                    'login_user_id'   => $param['login_user_id'],
                )
            );
            if (!empty($place_review_likes)) {
                $userA = '';
                foreach ($place_review_likes as $like) {
                    if ($like['user_id'] == $param['login_user_id']) {
                        $userA = $like['name'];
                    }
                }
                if (empty($userA)) {
                    $userA = $place_review_likes[0]['name'];
                }
                $data['notice'] = Model_Notice::get_notice_string(
                    array(
                        'type' => 2,
                        'count_like' => count($place_review_likes) - 1,
                        'name' => $data['name'],
                        'place_name' => $data['place_name'],
                        'language_type' => $param['language_type'],
                    )
                );
                $data['place_review_likes'] = $place_review_likes;
            }
        }
        if (isset($param['get_comment'])) {
            $data['place_review_comments'] = Model_Place_Review_Comment::get_all_comment_by_place_review_id(
                array(
                    'place_review_id' => $param['id'],
                    'login_user_id'   => $param['login_user_id'],
                )
            );
        }
        return $data;
    }
    
    /**
     * Get all review for timeline of User
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array List place
     */
    public static function get_last_review($param)
    {
        if (empty($param['user_id'])) {
            $param['user_id'] = 0;
        }
        if (empty($param['login_user_id'])) {
            $param['login_user_id'] = 0;
        }
        $query = DB::select(
            self::$_table_name.'.id',
            self::$_table_name.'.place_id',
            self::$_table_name.'.comment',
            self::$_table_name.'.created',
            DB::expr("IFNULL(place_review_point_logs.review_point, 0) AS review_point"),
            DB::expr("IF(ISNULL(place_review_likes.id),0,1) AS is_like"),
            self::$_table_name.'.user_id',
            'users.name',
            'users.image_path',
            'users.sex_id',
            'users.email',
            'users.birthday',
            'users.zipcode',
            DB::expr("IF(ISNULL(follow_users.id),0,1) AS is_follow_user"),
            
            self::$_table_name.'.entrance_steps',
            self::$_table_name.'.is_flat',
            self::$_table_name.'.is_spacious',
            self::$_table_name.'.is_silent',
            self::$_table_name.'.is_bright',
            self::$_table_name.'.count_parking',
            self::$_table_name.'.count_wheelchair_parking',
            self::$_table_name.'.count_elevator',
            self::$_table_name.'.count_wheelchair_rent',
            self::$_table_name.'.count_wheelchair_wc',
            self::$_table_name.'.count_ostomate_wc',
            self::$_table_name.'.count_nursing_room',
            self::$_table_name.'.count_babycar_rent',
            self::$_table_name.'.with_assistance_dog',
            self::$_table_name.'.is_universal_manner',
            self::$_table_name.'.with_credit_card',
            self::$_table_name.'.with_emoney',
            self::$_table_name.'.count_plug',
            self::$_table_name.'.count_wifi',
            self::$_table_name.'.count_smoking_room',
            self::$_table_name.'.is_newest'
        )
            ->from(self::$_table_name)
            ->join(
                DB::expr(
                    "
                (   SELECT place_id, max(id) AS id
                    FROM place_reviews
                    WHERE disable = 0
                    GROUP BY place_id
                ) last_place_reviews
            "
                ),
                'LEFT'
            )
            ->on(self::$_table_name.'.place_id', '=', 'last_place_reviews.place_id')
            ->on(self::$_table_name.'.id', '=', 'last_place_reviews.id')
            ->join('users')
            ->on(self::$_table_name.'.user_id', '=', 'users.id')
            ->join('place_review_point_logs', 'LEFT')
            ->on(self::$_table_name.'.place_id', '=', 'place_review_point_logs.place_id')
            ->on(self::$_table_name.'.id', '=', 'place_review_point_logs.place_review_id')
            ->on(self::$_table_name.'.user_id', '=', 'place_review_point_logs.user_id')
            ->join(
                DB::expr(
                    "
                (SELECT *
                FROM place_review_likes
                WHERE user_id = {$param['login_user_id']}
                    AND disable = 0) place_review_likes
            "
                ),
                'LEFT'
            )
            ->on(self::$_table_name.'.id', '=', 'place_review_likes.place_review_id')
            ->join(
                DB::expr(
                    "
                (SELECT *
                FROM follow_users
                WHERE user_id = {$param['login_user_id']}
                    AND disable = 0) follow_users
            "
                ),
                'LEFT'
            )
            ->on(self::$_table_name.'.user_id', '=', 'follow_users.follow_user_id')
            ->where(self::$_table_name.'.disable', '=', '0');
        // filter by keyword
        if (!empty($param['user_id'])) {
            $query->where(self::$_table_name.'.user_id', '=', $param['user_id']);
        }
        if (!empty($param['place_id'])) {
            if (!is_array($param['place_id'])) {
                $param['place_id'] = array($param['place_id']);
            }
            $query->where(self::$_table_name.'.place_id', 'IN', $param['place_id']);
        }
        if (!empty($param['language_type'])) {
            //$query->where(self::$_table_name . '.language_type', '=', $param['language_type']);
        }
        if (!empty($param['limit'])) {
            $query->limit($param['limit'])->offset(0);
        }
        $query->order_by(self::$_table_name.'.id', 'ASC');
        $data = $query->execute(self::$slave_db)->as_array();
        return $data;
    }
    
    /**
     * Update info for Place Review
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return int|bool Place Review id or false if error
     */
    public static function update_review($param)
    {        
        if (empty($param['comment']) 
            && empty($_FILES)) {
            self::errorParamInvalid('comment_and_images');
            return false;
        }
        $id = !empty($param['id']) ? $param['id'] : 0;
        // check exist
        if (!empty($id)) {
            $self = self::find($id);
            if (empty($self)) {
                self::errorNotExist('place_review_id');
                return false;
            }
        }
        $imagePath = array();
        if (!empty($_FILES)) {
            $uploadResult = \Lib\Util::uploadImage($thumb = 'places');            
            if ($uploadResult['status'] != 200) {
                self::setError($uploadResult['error']);            
                return false;
            }
            $imagePath = $uploadResult['body'];         
        }
        $self->set('comment', $param['comment']);
        // save to database
        if ($self->save()) {            
            return !empty($self->id) ? $self->id : 0;
        }
        return false;
    }
    
    /**
     * Update place : entrance_steps + facility
     * 
     * @param int $place_id
     * @return boolean
     */
    public static function update_place_entrance_steps_and_facility($place_id = '') {
        if (empty($place_id)) {
            return false;
        }
        if (is_array($place_id)) {
            $place_id = implode(',', $place_id);
        }
        
        $datas = DB::query("SELECT
            place_reviews.place_id,
            a.entrance_steps,
            SUM(IF(is_flat is null or is_flat <= 0, 0, 1)) as is_flat,
            SUM(IF(is_spacious IS NULL OR is_spacious <= 0, 0, 1)) AS is_spacious,
            SUM(IF(is_silent IS NULL OR is_silent <= 0, 0, 1)) AS is_silent,
            SUM(IF(is_bright IS NULL OR is_bright <= 0, 0, 1)) AS is_bright,
            SUM(IF(count_parking IS NULL OR count_parking <= 0, 0, 1)) AS count_parking,
            SUM(IF(count_wheelchair_parking IS NULL OR count_wheelchair_parking <= 0, 0, 1)) AS count_wheelchair_parking,
            SUM(IF(count_elevator IS NULL OR count_elevator <= 0, 0, 1)) AS count_elevator,
            SUM(IF(count_wheelchair_rent IS NULL OR count_wheelchair_rent <= 0, 0, 1)) AS count_wheelchair_rent,
            SUM(IF(count_wheelchair_wc IS NULL OR count_wheelchair_wc <= 0, 0, 1)) AS count_wheelchair_wc,
            SUM(IF(count_ostomate_wc IS NULL OR count_ostomate_wc <= 0, 0, 1)) AS count_ostomate_wc,
            SUM(IF(count_nursing_room IS NULL OR count_nursing_room <= 0, 0, 1)) AS count_nursing_room,
            SUM(IF(count_babycar_rent IS NULL OR count_babycar_rent <= 0, 0, 1)) AS count_babycar_rent,
            SUM(IF(with_assistance_dog IS NULL OR with_assistance_dog <= 0, 0, 1)) AS with_assistance_dog,
            SUM(IF(is_universal_manner IS NULL OR is_universal_manner <= 0, 0, 1)) AS is_universal_manner,
            SUM(IF(with_credit_card IS NULL OR with_credit_card <= 0, 0, 1)) AS with_credit_card,
            SUM(IF(with_emoney IS NULL OR with_emoney <= 0, 0, 1)) AS with_emoney,
            SUM(IF(count_plug IS NULL OR count_plug <= 0, 0, 1)) AS count_plug,
            SUM(IF(count_wifi IS NULL OR count_wifi <= 0, 0, 1)) AS count_wifi,
            SUM(IF(count_smoking_room IS NULL OR count_smoking_room <= 0, 0, 1)) AS count_smoking_room,
            IFNULL(b.total_reviewer, 0) AS total_reviewer,
            c.google_place_id
            FROM place_reviews
            LEFT JOIN (
                SELECT place_id, entrance_steps
                FROM (
                    SELECT *
                    FROM (
                        SELECT place_id, entrance_steps, count(*) as total
                        FROM (
                            SELECT place_id, entrance_steps, updated
                            FROM place_reviews
                            WHERE is_newest = 1 AND disable = 0 AND place_id IN ({$place_id})
                            ORDER BY updated DESC
                        ) x
                        GROUP BY place_id, entrance_steps
                        ORDER BY updated DESC
                    ) y
                    GROUP BY place_id, total
                    ORDER BY total DESC
                ) z
                GROUP BY place_id
            ) a
            ON place_reviews.place_id = a.place_id
            LEFT JOIN (
                SELECT place_id, COUNT(*) AS total_reviewer
                FROM place_reviews
                WHERE place_id IN ({$place_id})
                    AND `disable` = 0
                    AND is_newest = 1
                GROUP BY place_id
            ) b ON place_reviews.place_id = b.place_id
            LEFT JOIN (
                SELECT id, google_place_id
                FROM places
                WHERE id IN ({$place_id})
            ) c ON place_reviews.place_id = c.id
            WHERE is_newest = 1 AND disable = 0 AND place_reviews.place_id IN ({$place_id})
            GROUP BY place_id")
        ->execute();
        
        if (!empty($datas)) {
            foreach ($datas as $data) {
                DB::update('places')
                    ->value('entrance_steps', $data['entrance_steps'])
                    ->value('is_flat', $data['is_flat'])
                    ->value('is_spacious', $data['is_spacious'])
                    ->value('is_silent', $data['is_silent'])
                    ->value('is_bright', $data['is_bright'])
                    ->value('count_parking', $data['count_parking'])
                    ->value('count_wheelchair_parking', $data['count_wheelchair_parking'])
                    ->value('count_elevator', $data['count_elevator'])
                    ->value('count_wheelchair_rent', $data['count_wheelchair_rent'])
                    ->value('count_wheelchair_wc', $data['count_wheelchair_wc'])
                    ->value('count_ostomate_wc', $data['count_ostomate_wc'])
                    ->value('count_nursing_room', $data['count_nursing_room'])
                    ->value('count_babycar_rent', $data['count_babycar_rent'])
                    ->value('with_assistance_dog', $data['with_assistance_dog'])
                    ->value('is_universal_manner', $data['is_universal_manner'])
                    ->value('with_credit_card', $data['with_credit_card'])
                    ->value('with_emoney', $data['with_emoney'])
                    ->value('count_plug', $data['count_plug'])
                    ->value('count_wifi', $data['count_wifi'])
                    ->value('count_smoking_room', $data['count_smoking_room'])
                    ->value('count_review', $data['total_reviewer'])
                    ->where('id', '=', $data['place_id'])
                    ->execute();
                
                // Delete cache for place detail api
                $languageType = array(1, 2, 3, 4, 'ALL');
                foreach ($languageType as $language_type) {
                    Model_Place::DeleteCacheDetail(array(
                        'language_type' => $language_type,
                        'place_id' => $data['place_id']
                    ));
                }
            }
        }
        
        return true;
    }
    
    /**
     * Get Review history
     * 
     * @param array $param
     * @return boolean | array
     */
    public static function get_history($param) {
        /*if (empty($param['user_id']) || empty($param['place_id'])) {
            self::errorParamInvalid('user_id_and_place_id');
            return false;
        }*/
        
        $query = DB::select(
                    self::$_table_name.'.id',
                    self::$_table_name.'.user_id',
                    self::$_table_name.'.place_id',
                    self::$_table_name.'.comment',
                    self::$_table_name.'.created',
                    self::$_table_name.'.updated',
                    DB::expr("place_informations.name as place_name"),
                    DB::expr("users.name as user_name")
                )
                ->from(self::$_table_name)
                ->join('users')
                ->on(self::$_table_name.'.user_id', '=', 'users.id')
                ->join('place_informations')
                ->on(self::$_table_name.'.place_id', '=', 'place_informations.place_id')
                ->where(self::$_table_name.'.is_newest', 'IN', array(0, 1));
        
        if (!empty($param['user_id'])) {
            $query->where(self::$_table_name.'.user_id', '=', $param['user_id']);
        }
        
        if (!empty($param['place_id'])) {
            $query->where(self::$_table_name.'.place_id', '=', $param['place_id']);
        }
        
        if (isset($param['disable']) && in_array($param['disable'], array(0, 1))) {
            $query->where(self::$_table_name.'.disable', '=', 0);
        }
        
        $query->group_by(self::$_table_name.'.id');
        
        $query->order_by(self::$_table_name.'.is_newest', 'DESC')
                ->order_by(self::$_table_name.'.updated', 'DESC');
                
        if (!empty($param['page']) && !empty($param['limit'])) {
            $offset = ($param['page'] - 1) * $param['limit'];
            $query->limit($param['limit'])->offset($offset);
        } else {
            $query->limit(1000)->offset(0);
        }
        
        $data = $query->execute(self::$slave_db)->as_array();
        
        if (!empty($param['get_by_paging'])) {
            $total = !empty($data) ? DB::count_last_query(self::$slave_db) : 0;
            return array('total' => $total, 'data' => $data);
        }
        
        return $data;
    }

}
