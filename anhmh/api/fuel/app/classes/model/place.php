<?php

/**
 * Any query in Model Place
 *
 * @package   Model
 * @created   2015-06-29
 * @version   1.0
 * @author    Caolp
 * @copyright Oceanize INC
 */
class Model_Place extends Model_Abstract
{
    protected static $_properties = array(
        'id',
        'place_category_type_id',
        'place_sub_category_type_id',
        'google_place_id',
        'google_category_name',
        'google_scope',
        'google_postal_code',
        'latitude',
        'longitude',
        'review_point',
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
        'count_follow',
        'count_favorite',
        'count_review',
        'count_user_report',
        'with_assistance_dog',        
        'with_credit_card',
        'with_emoney',
        'created',
        'updated',
        'disable',
        'license',
        'source_url',
        'indoor_url'
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

    protected static $_table_name = 'places';

    /**
     * Add or update info for Place
     *
     * @author Caolp
     * @param array $param Input data
     * @return int|bool Place id or false if error
     */
    public static function add_update($param)
    {
        $id = !empty($param['id']) ? $param['id'] : 0;        
        $new = true;
        if (!empty($id)) {
            $place = self::find(
                $id,
                array(
                    'from_cache' => false
                )
            );
            if (empty($place)) {
                self::errorNotExist('place_id');
                return false;
            }
            $new = true;
        }
        if (empty($param['place_category_type_id'])) {
            $param['place_category_type_id'] = 0;
        }
        if (empty($param['place_sub_category_type_id'])) {
            $param['place_sub_category_type_id'] = 0;
        }
        if (empty($place) && !empty($param['google_place_id'])) {
            $place = self::find(
                'first',
                array(
                    'where' => array(
                        'google_place_id' => $param['google_place_id']
                    ),
                    'from_cache' => false
                )
            );
        }
        if (empty($place)) {
            $place = new self;
            $place->set('count_follow', '0');
            $place->set('count_favorite', '0');
            $place->set('count_review', '0');
            $place->set('count_user_report', '0');
            $place->set('review_point', '0');
        }
        if (!empty($param['sub_category_id'])) {
            $subCategory = Model_Place_Sub_Category::get_detail(
                array(
                    'id' => $param['sub_category_id']
                )
            );
            if (empty($subCategory)) {
                static::errorNotExist('sub_category_id');
                return false;
            }
            $param['place_category_type_id'] = $subCategory->get('category_type_id');
            $param['place_sub_category_type_id'] = $subCategory->get('type_id');
        }        
        if (isset($param['place_category_type_id']) && $param['place_category_type_id'] !== '') {
            $place->set('place_category_type_id', $param['place_category_type_id']);
        }        
        if (isset($param['place_sub_category_type_id']) && $param['place_sub_category_type_id'] !== '') {
            $place->set('place_sub_category_type_id', $param['place_sub_category_type_id']);
        }
        if (isset($param['google_place_id'])) {
            $place->set('google_place_id', $param['google_place_id']);
        }
        if (isset($param['google_category_name'])) {
            $place->set('google_category_name', $param['google_category_name']);
        }
        if (isset($param['google_scope'])) {
            $place->set('google_scope', $param['google_scope']);
        }
        if (isset($param['google_postal_code']) && $param['google_postal_code'] !== null) {
            $place->set('google_postal_code', $param['google_postal_code']);
        }
        if (isset($param['latitude'])) {
            $place->set('latitude', $param['latitude']);
        }
        if (isset($param['longitude'])) {
            $place->set('longitude', $param['longitude']);
        }
        if (isset($param['review_point'])) {
            $place->set('review_point', $param['review_point']);
        }
        if (isset($param['disable'])) {
            $place->set('disable', $param['disable']);
        }
        if (isset($param['license'])) {
            $place->set('license', $param['license']);
        }
        if (isset($param['indoor_url'])) {
            $place->set('indoor_url', $param['indoor_url']);
        }

        $is_changed_place = $place->is_changed();
        // save to database      
        if ($place->save()) {
            if (empty($place->id)) {
                $place->id = self::cached_object($place)->_original['id'];
            }
            if (isset($param['name'])
                || isset($param['name_kana'])
                || isset($param['address'])
                || isset($param['tel'])
                || isset($param['station_near_by'])
                || isset($param['business_hours'])
                || isset($param['regular_holiday'])
                || isset($param['place_memo'])
            ) {
                $param['place_id'] = $place->id;
                if (!Model_Place_Information::add_update($param, $is_changed_place_information)) {
                    \LogLib::warning("Can not add/update place_informations", __METHOD__, $param);
                    return false;
                }
            }
            // write log when change place's infos
            if ($place->is_new() == false
                && !empty($param['login_user_id'])
                && ($is_changed_place || $is_changed_place_information)
            ) {
                if (isset($param['id'])) {
                    unset($param['id']);
                }
                $param['place_id'] = $place->id;
                Model_Place_Edited_Log::add($param);
            }
            if (isset($param['return_place_detail'])) {
                return self::get_detail(array(
                    'id' => $place->id,
                    'language_type' => $param['language_type']
                ));
            }
            Model_Place_Review::update_place_entrance_steps_and_facility($place->id);
            self::DeleteCacheDetail($param,__METHOD__);
            return !empty($place->id) ? $place->id : 0;
        }
        return false;
    }

    /**
     * Get list Place (using array count)
     *
     * @author Caolp
     * @param array $param Input data
     * @return array List Place
     */
    public static function get_list($param)
    {
        $query = DB::select(
                self::$_table_name.'.id',
                self::$_table_name.'.place_category_type_id',
                self::$_table_name.'.place_sub_category_type_id',
                self::$_table_name.'.google_place_id',
                self::$_table_name.'.google_category_name',
                self::$_table_name.'.google_postal_code',
                'place_informations.name',
                'place_informations.name_kana',
                self::$_table_name.'.latitude',
                self::$_table_name.'.longitude',
                self::$_table_name.'.review_point',
                self::$_table_name.'.entrance_steps',
                self::$_table_name.'.is_flat',
                self::$_table_name.'.is_spacious',
                self::$_table_name.'.is_silent',
                self::$_table_name.'.is_bright',
                self::$_table_name.'.is_universal_manner',
                self::$_table_name.'.count_parking',
                self::$_table_name.'.count_wheelchair_parking',
                self::$_table_name.'.count_wheelchair_rent',
                self::$_table_name.'.count_babycar_rent',
                self::$_table_name.'.count_elevator',
                self::$_table_name.'.count_wheelchair_wc',
                self::$_table_name.'.count_ostomate_wc',
                self::$_table_name.'.count_nursing_room',
                self::$_table_name.'.count_smoking_room',
                self::$_table_name.'.count_plug',
                self::$_table_name.'.count_wifi',
                self::$_table_name.'.count_follow',
                //self::$_table_name.'.count_favorite',
                array('place_favorites_total.total', 'count_favorite'),
                //self::$_table_name.'.count_review',
                array('place_reviews_total.total', 'count_review'),
                self::$_table_name.'.count_user_report',
                self::$_table_name.'.with_assistance_dog',            
                self::$_table_name.'.with_credit_card',
                self::$_table_name.'.with_emoney',
                self::$_table_name.'.disable',
                self::$_table_name.'.created',
                self::$_table_name.'.license',
                self::$_table_name.'.source_url',
                'place_informations.address',
                'place_informations.tel',
                'place_informations.station_near_by',
                'place_informations.business_hours',
                'place_informations.regular_holiday',
                'place_informations.place_memo',
                'place_informations.language_type',
                array('place_categories.id', 'place_category_id'),
                array('place_categories.name', 'place_category_name'),
                self::$_table_name.'.indoor_url'
            )
            ->from(self::$_table_name)
            ->join('place_informations')
            ->on(self::$_table_name.'.id', '=', 'place_informations.place_id')
            ->and_on('place_informations.language_type', '=', "'{$param['language_type']}'")
            ->and_on('place_informations.disable', '=', "'0'")
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
            ->on(self::$_table_name.'.place_category_type_id', '=', 'place_categories.type_id')
            ->join(
                DB::expr("(
                    SELECT place_id, COUNT(*) as total
                    FROM place_reviews
                    WHERE disable = 0
                    GROUP BY place_id
                ) AS place_reviews_total"),
                'LEFT'
            )
            ->on(self::$_table_name.'.id', '=', 'place_reviews_total.place_id')
            ->join(
                DB::expr("(
                    SELECT place_id, COUNT(*) as total
                    FROM place_favorites
                    WHERE disable = 0 AND favorite_type = 1
                    GROUP BY place_id
                ) AS place_favorites_total"),
                'LEFT'
            )
            ->on(self::$_table_name.'.id', '=', 'place_favorites_total.place_id')
            ->join('place_pins', 'LEFT')
            ->on(self::$_table_name.'.id', '=', 'place_pins.place_id');
            //->where('place_categories.language_type', '=', $param['language_type'])

        if (!empty($param['id'])) {
            $query->where(self::$_table_name.'.id', '=', $param['id']);
        }
        if (!empty($param['place_category_type_id'])) {
            $query->where(self::$_table_name.'.place_category_type_id', '=', $param['place_category_type_id']);
        }
        if (!empty($param['place_category_type_ids'])) {
            $query->where(DB::expr(self::$_table_name . ".place_category_type_id IN ({$param['place_category_type_ids']})"));
        }
        if (!empty($param['place_sub_category_type_id'])) {
            $query->where(self::$_table_name.'.place_sub_category_type_id', '=', $param['place_sub_category_type_id']);
        }
        if (!empty($param['google_place_id'])) {
            $query->where(self::$_table_name.'.google_place_id', '=', $param['google_place_id']);
        }
        if (!empty($param['name'])) {
            $query->where('place_informations.name', 'LIKE', '%' . $param['name'] . '%');
        }
        if (!empty($param['name_kana'])) {
            $query->where('place_informations.name_kana', 'LIKE', '%' . $param['name_kana'] . '%');
        }
        if (!empty($param['address'])) {
            $query->where('place_informations.address', 'LIKE', '%' . $param['address'] . '%');
        }
        if (!empty($param['tel'])) {
            $query->where('place_informations.tel', '=', $param['tel']);
        }
        if (!empty($param['review_point'])) { 
            $query->where(self::$_table_name.'.entrance_steps', '>=', 0);
            $query->where(self::$_table_name.'.review_point', '>=', $param['review_point']);
        }
        if (!empty($param['entrance_steps'])) {
            $query->where(self::$_table_name.'.entrance_steps', '>=', 0);
            $query->where(self::$_table_name.'.entrance_steps', '<=', $param['entrance_steps']);
        }
        if (!empty($param['is_flat'])) {
            $query->where(self::$_table_name.'.is_flat', '=', $param['is_flat']);
        }
        if (!empty($param['is_spacious'])) {
            $query->where(self::$_table_name.'.is_spacious', '=', $param['is_spacious']);
        }
        if (!empty($param['is_silent'])) {
            $query->where(self::$_table_name.'.is_silent', '=', $param['is_silent']);
        }
        if (!empty($param['is_bright'])) {
            $query->where(self::$_table_name.'.is_bright', '=', $param['is_bright']);
        }
        if (!empty($param['is_universal_manner'])) {
            $query->where(self::$_table_name.'.is_universal_manner', '=', $param['is_universal_manner']);
        }
        if (!empty($param['count_parking'])) {
            $query->where(self::$_table_name.'.count_parking', '>=', $param['count_parking']);
        }
        if (!empty($param['count_wheelchair_parking'])) {
            $query->where(self::$_table_name.'.count_wheelchair_parking', '>=', $param['count_parking']);
        }
        if (!empty($param['count_wheelchair_rent'])) {
            $query->where(self::$_table_name.'.count_wheelchair_rent', '>=', $param['count_parking']);
        }
        if (!empty($param['count_babycar_rent'])) {
            $query->where(self::$_table_name.'.count_babycar_rent', '>=', $param['count_parking']);
        }        
        if (!empty($param['count_elevator'])) {
            $query->where(self::$_table_name.'.count_elevator', '>=', $param['count_elevator']);
        }
        if (!empty($param['count_wheelchair_wc'])) {
            $query->where(self::$_table_name.'.count_wheelchair_wc', '>=', $param['count_wheelchair_wc']);
        }
        if (!empty($param['count_ostomate_wc'])) {
            $query->where(self::$_table_name.'.count_ostomate_wc', '>=', $param['count_ostomate_wc']);
        }
        if (!empty($param['count_nursing_room'])) {
            $query->where(self::$_table_name.'.count_nursing_room', '>=', $param['count_nursing_room']);
        }
        if (!empty($param['count_smoking_room'])) {
            $query->where(self::$_table_name.'.count_smoking_room', '>=', $param['count_smoking_room']);
        }
        if (!empty($param['count_plug'])) {
            $query->where(self::$_table_name.'.count_plug', '>=', $param['count_plug']);
        }
        if (!empty($param['count_wifi'])) {
            $query->where(self::$_table_name.'.count_wifi', '>=', $param['count_wifi']);
        }
        if (!empty($param['with_assistance_dog'])) {
            $query->where(self::$_table_name.'.with_assistance_dog', '=', $param['with_assistance_dog']);
        }       
        if (!empty($param['with_credit_card'])) {
            $query->where(self::$_table_name.'.with_credit_card', '=', $param['with_credit_card']);
        }
        if (!empty($param['with_emoney'])) {
            $query->where(self::$_table_name.'.with_emoney', '=', $param['with_emoney']);
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
        
        // KienNH 2016/05/13 begin
        if (!empty($param['register_user'])) {
            if ($param['register_user'] == 1) {// Register by user
                $query->where('place_pins.place_id', '>', 0);
            } else if ($param['register_user'] == 2) {// Get from Google
                $query->where('place_pins.place_id', 'IS', null);
            }
        }
        // KienNH end
        
        if (!empty($param['page']) && !empty($param['limit'])) {
            $offset = ($param['page'] - 1) * $param['limit'];
            $query->limit($param['limit'])->offset($offset);
        }
        if (!empty($param['sort'])) {
            // KienNH 2016/04/20 check valid sort
            if (!self::checkSort($param['sort'], self::$_properties, array('name', 'count_favorite', 'count_review'))) {
                self::errorParamInvalid('sort');
                return false;
            }
            
            $sortExplode = explode('-', $param['sort']);
            switch ($sortExplode[0]) {
                case 'name':
                    $query->order_by('place_informations.'.$sortExplode[0], $sortExplode[1]);
                    break;
                case 'count_favorite':
                    $query->order_by('place_favorites_total.total', $sortExplode[1]);
                    break;
                case 'count_review':
                    $query->order_by('place_reviews_total.total', $sortExplode[1]);
                    break;
                default:
                    $query->order_by(self::$_table_name.'.'.$sortExplode[0], $sortExplode[1]);
            }            
        } else {
            $query->order_by(self::$_table_name.'.created', 'DESC');
        }
        $data = $query->execute(self::$slave_db)->as_array();
        $total = !empty($data) ? DB::count_last_query(self::$slave_db) : 0;


        if (isset($param['get_place_images']) && !empty($data)) {
            $placeId = Lib\Arr::field($data, 'id');
            $images = Model_Place_Image::get_all(
                array(
                    'place_id' => $placeId,
                    'ignore_place_disable' => 1,
                    //'is_default' => '1',
                )
            );
            foreach ($data as &$row) {
                $imageList = Lib\Arr::filter($images, 'place_id', $row['id'], false, false);
                if (!empty($imageList)) {  
                    foreach ($imageList as $image) {
                        if ($image['is_default'] == 1) {
                            $row['place_image_path'] = $image['image_path'];
                            $row['place_thm_image_path'] = $image['thm_image_path'];
                            break;
                        }
                    }
                    if (empty($row['place_thm_image_path'])) {
                        //$image = $imageList[0];
                        $row['place_image_path'] = null;//$image['image_path'];
                        $row['place_thm_image_path'] = null;//$image['thm_image_path'];
                    }
                    $row['count_image'] = count($imageList);
                } else {
                    $row['count_image'] = 0;
                    if (empty($row['place_image_path'])) {
                        $row['place_image_path'] = \Config::get('no_image_place');
                        $row['place_thm_image_path'] = \Config::get('no_image_place');
                    }
                }                
            }
            unset($row);
        }
        return array('total' => $total, 'data' => $data);
    }

    /**
     * Get list Place that order by review_point -> count_review -> last_review
     *
     * @author Caolp
     * @param array $param Input data
     * @return array List Place
     */
    public static function get_list_order_by_ranking($param)
    {
        if (empty($param['limit'])) {
            $param['limit'] = 3;
        }
        if (empty($param['login_user_id'])) {
            $param['login_user_id'] = 0;
        }
        if (empty($param['page'])) {
            $param['page'] = 1;
        }
        if (empty($param['language_type'])) {
            $param['language_type'] = 1;
        }  
        $order_by_txt = isset($param['ranking_by_point']) ? 'ReviewPoint' : '' ;

        $query = DB::select(
                self::$_table_name.'.id',
                self::$_table_name.'.google_place_id',
                self::$_table_name.'.google_category_name',
                self::$_table_name.'.google_postal_code',               
                self::$_table_name.'.latitude',
                self::$_table_name.'.longitude',
                self::$_table_name.'.review_point',
                self::$_table_name.'.entrance_steps',
                self::$_table_name.'.is_flat',
                self::$_table_name.'.is_spacious',
                self::$_table_name.'.is_silent',
                self::$_table_name.'.is_bright',
                self::$_table_name.'.is_universal_manner',
                self::$_table_name.'.count_parking',
                self::$_table_name.'.count_wheelchair_parking',
                self::$_table_name.'.count_wheelchair_rent',
                self::$_table_name.'.count_babycar_rent',
                self::$_table_name.'.count_elevator',
                self::$_table_name.'.count_wheelchair_wc',
                self::$_table_name.'.count_ostomate_wc',
                self::$_table_name.'.count_nursing_room',
                self::$_table_name.'.count_smoking_room',
                self::$_table_name.'.count_plug',
                self::$_table_name.'.count_wifi',
                self::$_table_name.'.count_follow',
                self::$_table_name.'.count_favorite',
                self::$_table_name.'.count_review',
                self::$_table_name.'.with_assistance_dog',           
                self::$_table_name.'.with_credit_card',
                self::$_table_name.'.with_emoney',               
                self::$_table_name.'.place_category_type_id',
                array('place_categories.id', 'place_category_id'),
                array('place_categories.name', 'place_category_name'),
                self::$_table_name.'.place_sub_category_type_id',
                array('place_sub_categories.id', 'place_sub_category_id'),
                array('place_sub_categories.name', 'place_sub_category_name'),
                // DB::expr("IF(ISNULL(place_favorites.id),0,1) AS is_favorite"),
                // 'place_favorites.favorite_type',
                DB::expr(self::sql_distance($param)),
                self::$_table_name.'.indoor_url'
            )
            ->from(self::$_table_name)           
            // ->join(
            //     DB::expr(
            //         "
            //     (SELECT id, place_id, favorite_type
            //     FROM place_favorites
            //     WHERE user_id = {$param['login_user_id']}
            //         AND (favorite_type&1) <> 0
            //         AND disable = 0) place_favorites
            // "
            //     ),
            //     'LEFT'
            // )
            // ->on(self::$_table_name.'.id', '=', 'place_favorites.place_id')
            ->join(
                DB::expr(
                    "(  SELECT place_id, max(created) AS last_review_time
                                FROM place_reviews 
                                WHERE disable = 0 
                                GROUP BY place_id
                            ) AS place_reviews"
                ),
                'LEFT'
            )
            ->on(self::$_table_name.'.id', '=', 'place_reviews.place_id')
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
            ->on(self::$_table_name.'.place_category_type_id', '=', 'place_categories.type_id')
            ->join(
                DB::expr(
                    "(  SELECT *
                           FROM place_sub_categories 
                           WHERE disable = 0 
                           AND language_type={$param['language_type']}
                       ) AS place_sub_categories"
                ),
                'LEFT'
            )
            ->on(self::$_table_name.'.place_sub_category_type_id', '=', 'place_sub_categories.type_id')
            ->where(self::$_table_name.'.count_favorite', '>', '0')
            ->where(self::$_table_name.'.disable', '=', '0');
        if (!empty($param['place_category_type_id'])) {
            $query->where(self::$_table_name.'.place_category_type_id', '=', $param['place_category_type_id']);
        }
        if (!empty($param['page']) && !empty($param['limit'])) {
            $offset = ($param['page'] - 1) * $param['limit'];
            $query->limit($param['limit'])->offset($offset);
        }
        if (isset($param['ranking_by_point'])) {
            $query->order_by(self::$_table_name.'.review_point', 'DESC');
        }
        $query->order_by(self::$_table_name.'.count_review', 'DESC');
        $query->order_by(self::$_table_name.'.count_favorite', 'DESC');
        $query->order_by('place_reviews.last_review_time', 'DESC');
        $data = $query->execute(self::$slave_db)->as_array();
        $total = !empty($data) ? DB::count_last_query(self::$slave_db) : 0;
        $data = Model_Place_Information::merge_info(
            $data,
            $param['language_type']
        );

        // Cache::set('placesRanking'.$order_by_txt.'Lang'.$param['language_type'].'limit'.$param['limit'].'page'.$param['page'], $data, 3600 * 1);
        // Cache::set('placesRanking'.$order_by_txt.'Lang'.$param['language_type'].'limit'.$param['limit'].'page'.$param['page'].'Total', $total, 3600 * 1);


        if (!empty($data)) {
            $placeId = Lib\Arr::field($data, 'id');
            $images = Model_Place_Image::get_all(
                array(
                    'place_id'   => $placeId,
                    'is_default' => '1',
                )
            );
            $favorites = Model_Place_Favorite::find('all',
                array(
                     'where' => array(
                        array('user_id' , '=', $param['login_user_id']),
                        array('favorite_type','&1<>','0'),
                        array('disable','=', '0'),
                    )
                )
            );
            foreach ($data as &$row) {
                $image = Lib\Arr::filter($images, 'place_id', $row['id'], false, false);
                $favorite = Lib\Arr::filter($favorites, 'place_id', $row['id'], false, false);
                if (!empty($image[0])) {
                    $row['place_image_path'] = $image[0]['image_path'];
                    $row['place_thm_image_path'] = $image[0]['thm_image_path'];
                    if(!empty($favorite)){
                        $row['is_favorite'] = 1;
                        $row['favorite_type'] = $favorite[0]['favorite_type'];    
                    } else {
                        $row['is_favorite'] = 0;
                        $row['favorite_type'] = 0;
                    }
                }
            }
            unset($row);
        }
        return array('total' => $total, 'data' => $data);
    }

    /**
     * Get all Place (without array count)
     *
     * @author Caolp
     * @param array $param Input data
     * @return array List Place
     */
    public static function get_all($param)
    {
        $query = DB::select(
                self::$_table_name.'.*'
            )
            ->from(self::$_table_name)
            ->join('place_informations')
            ->on(self::$_table_name.'.id', '=', 'place_informations.place_id')
            ->join('place_categories')
            ->on(self::$_table_name.'.place_category_type_id', '=', 'place_categories.type_id');
        if (!empty($param['language_type'])) {
            $query->where('place_informations.language_type', '=', $param['language_type']);
            $query->where('place_categories.language_type', '=', $param['language_type']);
        }
        if (!empty($param['id'])) {
            $query->where(self::$_table_name.'.id', '=', $param['id']);
        }
        if (!empty($param['place_category_type_id'])) {
            $query->where(self::$_table_name.'.place_category_type_id', '=', $param['place_category_type_id']);
        }
        if (!empty($param['google_place_id'])) {
            $query->where(self::$_table_name.'.google_place_id', '=', $param['google_place_id']);
        }
        if (!empty($param['name'])) {
            $query->where(self::$_table_name.'.name', '=', $param['name']);
        }
        if (!empty($param['name_kana'])) {
            $query->where(self::$_table_name.'.name_kana', '=', $param['name_kana']);
        }
        if (!empty($param['address'])) {
            $query->where(self::$_table_name.'.address', '=', $param['address']);
        }
        if (!empty($param['tel'])) {
            $query->where(self::$_table_name.'.tel', '=', $param['tel']);
        }
        if (!empty($param['review_point'])) { 
            $query->where(self::$_table_name.'.entrance_steps', '>=', 0);
            $query->where(self::$_table_name.'.review_point', '>=', $param['review_point']);
        }
        if (!empty($param['entrance_steps'])) {
            $query->where(self::$_table_name.'.entrance_steps', '>=', 0);
            $query->where(self::$_table_name.'.entrance_steps', '<=', $param['entrance_steps']);
        }
        if (!empty($param['is_flat'])) {
            $query->where(self::$_table_name.'.is_flat', '=', $param['is_flat']);
        }
        if (!empty($param['is_spacious'])) {
            $query->where(self::$_table_name.'.is_spacious', '=', $param['is_spacious']);
        }
        if (!empty($param['is_silent'])) {
            $query->where(self::$_table_name.'.is_silent', '=', $param['is_silent']);
        }
        if (!empty($param['is_bright'])) {
            $query->where(self::$_table_name.'.is_bright', '=', $param['is_bright']);
        }
        if (!empty($param['is_universal_manner'])) {
            $query->where(self::$_table_name.'.is_universal_manner', '=', $param['is_universal_manner']);
        }
        if (!empty($param['count_parking'])) {
            $query->where(self::$_table_name.'.count_parking', '>=', $param['count_parking']);
        }
        if (!empty($param['count_wheelchair_parking'])) {
            $query->where(self::$_table_name.'.count_wheelchair_parking', '>=', $param['count_parking']);
        }
        if (!empty($param['count_wheelchair_rent'])) {
            $query->where(self::$_table_name.'.count_wheelchair_rent', '>=', $param['count_parking']);
        }
        if (!empty($param['count_babycar_rent'])) {
            $query->where(self::$_table_name.'.count_babycar_rent', '>=', $param['count_parking']);
        }        
        if (!empty($param['count_elevator'])) {
            $query->where(self::$_table_name.'.count_elevator', '>=', $param['count_elevator']);
        }
        if (!empty($param['count_wheelchair_wc'])) {
            $query->where(self::$_table_name.'.count_wheelchair_wc', '>=', $param['count_wheelchair_wc']);
        }
        if (!empty($param['count_ostomate_wc'])) {
            $query->where(self::$_table_name.'.count_ostomate_wc', '>=', $param['count_ostomate_wc']);
        }
        if (!empty($param['count_nursing_room'])) {
            $query->where(self::$_table_name.'.count_nursing_room', '>=', $param['count_nursing_room']);
        }
        if (!empty($param['count_smoking_room'])) {
            $query->where(self::$_table_name.'.count_smoking_room', '>=', $param['count_smoking_room']);
        }
        if (!empty($param['count_plug'])) {
            $query->where(self::$_table_name.'.count_plug', '>=', $param['count_plug']);
        }
        if (!empty($param['count_wifi'])) {
            $query->where(self::$_table_name.'.count_wifi', '>=', $param['count_wifi']);
        }
        if (!empty($param['with_assistance_dog'])) {
            $query->where(self::$_table_name.'.with_assistance_dog', '=', $param['with_assistance_dog']);
        }       
        if (!empty($param['with_credit_card'])) {
            $query->where(self::$_table_name.'.with_credit_card', '=', $param['with_credit_card']);
        }
        if (!empty($param['with_emoney'])) {
            $query->where(self::$_table_name.'.with_emoney', '=', $param['with_emoney']);
        }
        if (!empty($param['disable'])) {
            $query->where(self::$_table_name.'.disable', '=', $param['disable']);
        }
        if (!empty($param['page']) && !empty($param['limit'])) {
            $offset = ($param['page'] - 1) * $param['limit'];
            $query->limit($param['limit'])->offset($offset);
        }
        $query->order_by(self::$_table_name.'.id', 'ASC');       
        $data = $query->execute(self::$slave_db)->as_array();
        return $data;
    }

    /**
     * Disable/Enable list Place
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
                self::errorNotExist('place_id');
                return false;
            }
        }
        return true;
    }

    /**
     * Get detail Place
     *
     * @author Caolp
     * @param array $param Input data
     * @return array|bool Detail Place or false if error
     */
    public static function get_detail($param)
    {
        if (empty($param['id']) && empty($param['google_place_id'])) {
            self::errorParamInvalid('id_or_google_place_id');
            return false;
        }
        if (empty($param['id'])) {
            $param['id'] = 0;
        } elseif (isset($param['google_place_id'])) {
            unset($param['google_place_id']);
        }
        if (empty($param['login_user_id'])) {
            $param['login_user_id'] = 0;
        }
        if (empty($param['review_limit'])) {
            $param['review_limit'] = 0;
        }
        if (empty($param['language_type'])) {
            $param['language_type'] = 1;
        }
        
        $query = DB::select(
                self::$_table_name.'.id',
                self::$_table_name.'.google_place_id',
                self::$_table_name.'.google_category_name',          
                self::$_table_name.'.latitude',
                self::$_table_name.'.longitude',
                self::$_table_name.'.review_point',
                self::$_table_name.'.entrance_steps',
                self::$_table_name.'.is_flat',
                self::$_table_name.'.is_spacious',
                self::$_table_name.'.is_silent',
                self::$_table_name.'.is_bright',
                self::$_table_name.'.is_universal_manner',
                self::$_table_name.'.count_parking',
                self::$_table_name.'.count_wheelchair_parking',
                self::$_table_name.'.count_wheelchair_rent',
                self::$_table_name.'.count_babycar_rent',
                self::$_table_name.'.count_elevator',
                self::$_table_name.'.count_wheelchair_wc',
                self::$_table_name.'.count_ostomate_wc',
                self::$_table_name.'.count_nursing_room',
                self::$_table_name.'.count_smoking_room',
                self::$_table_name.'.count_plug',
                self::$_table_name.'.count_wifi',
                self::$_table_name.'.count_follow',
                self::$_table_name.'.count_favorite',
                self::$_table_name.'.count_review',
                array(self::$_table_name.'.count_review', 'total_reviewer'),
                self::$_table_name.'.with_assistance_dog',           
                self::$_table_name.'.with_credit_card',
                self::$_table_name.'.with_emoney',         
                self::$_table_name.'.license',
                self::$_table_name.'.source_url',
                self::$_table_name.'.place_category_type_id',                
                array('place_categories.id', 'place_category_id'),
                array('place_categories.name', 'place_category_name'),
                self::$_table_name.'.place_sub_category_type_id',
                array('place_sub_categories.id', 'place_sub_category_id'),
                array('place_sub_categories.name', 'place_sub_category_name'),
                // DB::expr("IF(ISNULL(place_favorites.id),0,1) AS is_favorite"),
                // 'place_favorites.favorite_type',
                DB::expr(self::sql_distance($param)),
                'place_pins.user_id',
                self::$_table_name.'.indoor_url'
            )
            ->from(self::$_table_name)    
            ->join('place_pins', 'LEFT')
            ->on(self::$_table_name.'.id', '=', 'place_pins.place_id')
            // ->join(
            //     DB::expr(
            //         "
            //             (SELECT id, place_id, favorite_type
            //             FROM place_favorites
            //             WHERE user_id = {$param['login_user_id']}
            //                 AND (favorite_type&1) <> 0
            //                 AND disable = 0) place_favorites
            //         "
            //     ),
            //     'LEFT'
            // )
            // ->on(self::$_table_name.'.id', '=', 'place_favorites.place_id')
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
            ->on(self::$_table_name.'.place_category_type_id', '=', 'place_categories.type_id')
            ->join(
                DB::expr(
                    "(  SELECT *
                           FROM place_sub_categories 
                           WHERE disable = 0 
                           AND language_type={$param['language_type']}
                       ) AS place_sub_categories"
                ),
                'LEFT'
            )
            ->on(self::$_table_name.'.place_sub_category_type_id', '=', 'place_sub_categories.type_id')
            ->where(self::$_table_name.'.disable', 0);
        if (!empty($param['google_place_id'])) {
            $query->where(self::$_table_name.'.google_place_id', '=', $param['google_place_id']);
        }
        if (!empty($param['id'])) {
            $query->where(self::$_table_name.'.id', '=', $param['id']);
        }
        $data = Model_Place_Information::merge_info(
            $query->execute(self::$slave_db)->offsetGet(0),
            $param['language_type']
        );

        if (!empty($data)) {
            $data['place_image_path'] = '';
            $data['place_thm_image_path'] = '';
            $data['place_images'] = Model_Place_Image::get_all(
                array(
                    'place_id' => $data['id'],                        
                    'limit' => isset($param['get_place_images']) ? 8 : 1,                        
                    //'review_image_only' => 1
                )
            );
            $favorites = Model_Place_Favorite::find('first',
                array(
                    'where'=>array(
                        array('place_id' ,"=", $data['id']),
                        array('user_id' ,"=", $param['login_user_id']),
                        array('favorite_type' , '&1<>', '0'),
                        array('disable', "=" , 0),
                    )
                )
            );
            if (!empty($data['place_images'])) {
                foreach ($data['place_images'] as $image) {
                    if ($image['is_default'] == 1) {
                        $data['place_image_path'] = $image['image_path'];
                        $data['place_thm_image_path'] = $image['thm_image_path'];
                        break;                            
                    }
                }                
                if (empty($image['image_path']) && !empty($data['place_images'][0]['image_path'])) {
                    $data['place_image_path'] = $data['place_images'][0]['image_path'];
                    $data['place_thm_image_path'] = $data['place_images'][0]['thm_image_path'];
                }
            } 
            if (!empty($favorites)){
                $data['is_favorite'] = 1;
                $data['favorite_type'] = $favorites[0]['favorite_type'];
            } else {
                $data['is_favorite'] = 0;
                $data['favorite_type'] = 0;
            }
            if (isset($param['get_place_reviews'])) {
                $data['place_reviews'] = Model_Place_Review::get_all(
                    array(
                        'login_user_id' => $param['login_user_id'],
                        'place_id' => $data['id'],
                        'get_place_images' => '1',
                        'limit' => $param['review_limit']
                    )
                );
            }
        } elseif (empty ($data) && !empty ($param['id'])) {// KienNH 2016/05/17: return error when spot not found
            static::errorNotExist('place_id');
            return FALSE;
        } elseif (isset($param['google_place_id'])) {
            Package::load('gmap');
            $gMap = new \Gmap();
            $detail = $gMap->get_place_detail($param);
            if ($detail === false) {
                static::errorParamInvalid('google_place_id');
                return false;
            }
            $photo_url = !empty($detail['photo_url']) ? $detail['photo_url'] : array();
            for ($i = count($photo_url) - 1; $i >= 0; $i--) {
                if (empty($photo_url[$i]['image_path']) || empty($photo_url[$i]['thm_image_path'])) {
                    unset($photo_url[$i]);
                }
            }
            $data = array(
                'id'                         => 0,
                'place_category_type_id'     => 0,
                'place_sub_category_type_id' => 0,
                'google_place_id'            => $detail['place_id'],
                'google_category_name'       => implode(',', $detail['types']),
                'name'                       => $detail['name'],
                'name_kana'                  => '',
                'latitude'                   => $detail['geometry']['location']['lat'],
                'longitude'                  => $detail['geometry']['location']['lng'],
                'review_point'               => 0,
                'entrance_steps'             => -1,
                'is_flat'                    => -1,
                'is_spacious'                => -1,
                'is_silent'                  => -1,
                'is_bright'                  => -1,
                'is_universal_manner'        => -1,
                'count_parking'              => -1,
                'count_wheelchair_parking'   => -1,
                'count_wheelchair_rent'      => -1,
                'count_babycar_rent'         => -1,
                'count_elevator'             => -1,
                'count_wheelchair_wc'        => -1,
                'count_ostomate_wc'          => -1,
                'count_nursing_room'         => -1,
                'count_smoking_room'         => -1,
                'count_plug'                 => -1,
                'count_wifi'                 => -1,
                'count_follow'               => 0,
                'count_favorite'             => 0,
                'count_review'               => 0,
                'total_reviewer'             => 0,
                'with_assistance_dog'        => -1,                
                'with_creadit_card'          => -1,
                'with_emoney'                => -1,
                'address'                    => !empty($detail['formatted_address']) ? $detail['formatted_address'] : '',
                'tel'                        => !empty($detail['formatted_phone_number']) ? $detail['formatted_phone_number'] : '',
                'station_near_by'            => '',
                'business_hours'             => '',
                'regular_holiday'            => '',
                'place_memo'                 => '',
                'place_image_path'           => '',
                'place_thm_image_path'       => '',
                'is_favorite'                => '0',
                'place_images'               => array_slice($photo_url, 0, 8),
                'place_reviews'              => array(),
            );
            $data['distance' ] = self::php_distance(array(
                'location' => !empty($param['location']) ? $param['location'] : '',
                'latitude' => !empty($data['latitude']) ? $data['latitude'] : 0,
                'longitude' => !empty($data['longitude']) ? $data['longitude'] : 0,
            ));
            if (!empty($detail['photo_url'][0])) {
                $data['place_image_path'] = $detail['photo_url'][0]['image_path'];
                $data['place_thm_image_path'] = $detail['photo_url'][0]['thm_image_path'];
            }
            $subCategory = Model_Place_Sub_Category::get_detail_by_google_name(
                array(
                    'google_name' => $detail['types'],
                    'language_type' => $param['language_type'],
                )
            );
            if (!empty($subCategory[0])) {
                $data['place_category_type_id'] = $subCategory[0]['category_type_id'];
                $data['place_sub_category_type_id'] = $subCategory[0]['type_id'];
                $data['place_category_id'] = $subCategory[0]['category_id'];
                $data['place_category_name'] = $subCategory[0]['category_name'];
            }
        }
        if (isset($param['get_place_categories'])) {
            $data['categories'] = Model_Place_Category::get_all(array(
                'language_type' => $param['language_type'],
            ));
        }
        if (!empty($data['place_category_type_id'])) {
            $data['subcategories'] = Model_Place_Sub_Category::get_all(array(
                'category_type_id' => $data['place_category_type_id'],
                'language_type' => $param['language_type'],
            ));
        }
        if (empty($data['place_image_path'])) {
            $data['place_image_path'] = \Config::get('no_image_place');
            $data['place_thm_image_path'] = \Config::get('no_image_place');
        }
        $share_url = \Config::get('fe_url') . 'top#';
        $share_url .= !empty($data['google_place_id']) ? $data['google_place_id'] : '0';
        $share_url .= '|';
        $share_url .= !empty($data['id']) ? $data['id'] : '0';
        if (!empty($param['get_share_url'])) {
            $data['share_url'] = \Lib\Util::googleShortUrl($share_url);
        } else {
            $data['share_url'] = $share_url;
        }
        
        // KienNH 2016/03/24 begin
        if (!empty($param['get_my_review'])) {
            if (!empty($param['login_user_id'])) {
                $my_review = Model_Place_Review::find('first', array(
                    'where' => array(
                        'user_id' => $param['login_user_id'],
                        'place_id' => $data['id'],
                        'is_newest' => 1,
                        'disable' => 0
                    )
                ));
                if (!empty($my_review)) {
                    $my_review = Model_Place_Review::get_detail(array(
                        'login_user_id' => $param['login_user_id'],
                        'id' => $my_review['id'],
                        'language_type' => $my_review['language_type'],
                    ));
                    if (!empty($my_review)) {
                        $data['my_review'] = $my_review;
                    }
                }
            }
        }
        // KienNH end
        
        return (array)$data;
    }

    /**
     * Create SQL to get distance
     *
     * @author Thai Lai
     * @param array $param Input data
     * @return array|bool Detail Place or false if error
     */
    public static function sql_distance($param)
    {
        $latitude = $longitude = 0;
        if (!empty($param['location'])) {
            list($latitude, $longitude) = explode(',', urldecode($param['location']));
            return "ROUND((
                6371000 * 2 * ASIN(SQRT(
                POWER(SIN(({$latitude} - abs(latitude)) * pi()/180 / 2),
                2) + COS({$latitude} * pi()/180 ) * COS(abs(latitude) *
                pi()/180) * POWER(SIN(({$longitude} - longitude) *
                pi()/180 / 2), 2) ))),0) AS `distance` 
            ";
        }
        return '0 AS `distance`';        
    }
    
    /**
     * Get distance by PHP
     *
     * @author Thai Lai
     * @param array $param Input data
     * @return array|bool Detail Place or false if error
     */
    public static function php_distance($param)
    {
        if (!empty($param['location']) && !empty($param['latitude']) && !empty($param['longitude'])) {
            list($latitude, $longitude) = explode(',', urldecode($param['location']));
            return round((
                6371000 * 2 * asin(sqrt(
                pow(sin(($latitude - abs($param['latitude'])) * pi()/180 / 2),
                2) + COS($latitude * pi()/180 ) * cos(abs($param['latitude']) *
                pi()/180) * pow(sin(($longitude - $param['longitude']) *
                pi()/180 / 2), 2) ))),0);  
        }
        return 0;        
    }
    
    /**
     * Search Place
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array|bool Detail Place or false if error
     */
    public static function get_search($param)
    {
        if (!empty($param['google_place_id'])) {
            return array(self::get_detail(array(
                'google_place_id' => $param['google_place_id'],
                'language_type' => $param['language_type'],
                'location' => $param['location'],
            )));
        } elseif (!empty($param['place_id'])) {
            return array(self::get_detail(array(
                'id' => $param['place_id'],
                'language_type' => $param['language_type'],
                'location' => $param['location'],
            )));
        }
        
        $limitPin = 20;
        $textSearch = !empty($param['text_search']) ? true : false;
        
        // get all sub categories
        $subCategories = Model_Place_Sub_Category::get_all(
            array(
                'language_type' => $param['language_type']
            )
        );
        if (empty($param['radius'])) {
            $param['radius'] = \Config::get('gmap.radius', 1000);
        }
        if (empty($param['keyword'])) {
            $param['keyword'] = '';
        }
        $where = array();
        if (isset($param['review_point']) && $param['review_point'] !== '') { 
            $where[] = array(self::$_table_name.'.review_point', '>=', 0);
            $where[] = array(self::$_table_name.'.review_point', '>=', $param['review_point']);
        }
        if (isset($param['entrance_steps']) && $param['entrance_steps'] !== '') {
            $where[] = array(self::$_table_name.'.entrance_steps', '>=', 0);
            $where[] = array(self::$_table_name.'.entrance_steps', '<=', $param['entrance_steps']);
        }
        if (!empty($param['is_flat'])) {
            $where[] = array(self::$_table_name.'.is_flat', '=', $param['is_flat']);
        }
        if (!empty($param['is_spacious'])) {
            $where[] = array(self::$_table_name.'.is_spacious', '=', $param['is_spacious']);
        }
        if (!empty($param['is_silent'])) {
            $where[] = array(self::$_table_name.'.is_silent', '=', $param['is_silent']);
        }
        if (!empty($param['is_bright'])) {
            $where[] = array(self::$_table_name.'.is_bright', '=', $param['is_bright']);
        }
        if (!empty($param['is_universal_manner'])) {
            $where[] = array(self::$_table_name.'.is_universal_manner', '=', $param['is_universal_manner']);
        }
        if (!empty($param['count_parking'])) {
            $where[] = array(self::$_table_name.'.count_parking', '>=', $param['count_parking']);
        }
        if (!empty($param['count_wheelchair_parking'])) {
            $where[] = array(self::$_table_name.'.count_wheelchair_parking', '>=', $param['count_wheelchair_parking']);
        }
        if (!empty($param['count_wheelchair_rent'])) {
            $where[] = array(self::$_table_name.'.count_wheelchair_rent', '>=', $param['count_wheelchair_rent']);
        }
        if (!empty($param['count_babycar_rent'])) {
            $where[] = array(self::$_table_name.'.count_babycar_rent', '>=', $param['count_babycar_rent']);
        }        
        if (!empty($param['count_elevator'])) {
            $where[] = array(self::$_table_name.'.count_elevator', '>=', $param['count_elevator']);
        }
        if (!empty($param['count_wheelchair_wc'])) {
            $where[] = array(self::$_table_name.'.count_wheelchair_wc', '>=', $param['count_wheelchair_wc']);
        }
        if (!empty($param['count_ostomate_wc'])) {
            $where[] = array(self::$_table_name.'.count_ostomate_wc', '>=', $param['count_ostomate_wc']);
        }
        if (!empty($param['count_nursing_room'])) {
            $where[] = array(self::$_table_name.'.count_nursing_room', '>=', $param['count_nursing_room']);
        }
        if (!empty($param['count_smoking_room'])) {
            $where[] = array(self::$_table_name.'.count_smoking_room', '>=', $param['count_smoking_room']);
        }
        if (!empty($param['count_plug'])) {
            $where[] = array(self::$_table_name.'.count_plug', '>=', $param['count_plug']);
        }
        if (!empty($param['count_wifi'])) {
            $where[] = array(self::$_table_name.'.count_wifi', '>=', $param['count_wifi']);
        }
        if (!empty($param['with_assistance_dog'])) {
            $where[] = array(self::$_table_name.'.with_assistance_dog', '=', $param['with_assistance_dog']);
        }       
        if (!empty($param['with_credit_card'])) {
            $where[] = array(self::$_table_name.'.with_credit_card', '=', $param['with_credit_card']);
        }
        if (!empty($param['with_emoney'])) {
            $where[] = array(self::$_table_name.'.with_emoney', '=', $param['with_emoney']);
        }
        if (!empty($param['place_id'])) {
            $where[] = array(self::$_table_name.'.id', '=', $param['place_id']);
        }        
        $searchType = 'google';
        if (!empty($where) || !empty($param['physical_type_id']) && empty($param['keyword'])) {            
            $searchType = 'bmaps';
        }        
        list($latitude, $longitude) = explode(',', urldecode($param['location'])); 
        // get all place
        $query = DB::select(
                self::$_table_name.'.id',
                self::$_table_name.'.google_place_id',
                self::$_table_name.'.latitude',
                self::$_table_name.'.longitude',               
                self::$_table_name.'.review_point',
                self::$_table_name.'.entrance_steps',
                self::$_table_name.'.is_flat',
                self::$_table_name.'.is_spacious',
                self::$_table_name.'.is_silent',
                self::$_table_name.'.is_bright',
                self::$_table_name.'.is_universal_manner',
                self::$_table_name.'.count_parking',
                self::$_table_name.'.count_wheelchair_parking',
                self::$_table_name.'.count_wheelchair_rent',
                self::$_table_name.'.count_babycar_rent',
                self::$_table_name.'.count_elevator',
                self::$_table_name.'.count_wheelchair_wc',
                self::$_table_name.'.count_ostomate_wc',
                self::$_table_name.'.count_nursing_room',
                self::$_table_name.'.count_smoking_room',
                self::$_table_name.'.count_plug',
                self::$_table_name.'.count_wifi',
                self::$_table_name.'.count_follow',
                self::$_table_name.'.count_favorite',
                self::$_table_name.'.count_review',
                self::$_table_name.'.with_assistance_dog',                
                self::$_table_name.'.with_credit_card',
                self::$_table_name.'.with_emoney',
                self::$_table_name.'.license',
                self::$_table_name.'.source_url',
                array('place_categories.type_id', 'place_category_type_id'),
                array('place_categories.id', 'place_category_id'),
                array('place_categories.name', 'place_category_name'),
                array('place_sub_categories.id', 'place_sub_category_id'),
                array('place_sub_categories.name', 'place_sub_category_name'),
                array('place_images.image_path', 'place_image_path'),
                array('place_images.thm_image_path', 'place_thm_image_path'), 
                DB::expr(self::sql_distance($param)),
                self::$_table_name.'.indoor_url'
            )
            ->from(self::$_table_name)           
            ->join('place_informations')
            ->on(self::$_table_name.'.id', '=', 'place_informations.place_id')
            //->and_on('place_informations.language_type', '=', "'{$param['language_type']}'")
            ->and_on('place_informations.disable', '=', "'0'")
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
            ->on(self::$_table_name.'.place_category_type_id', '=', 'place_categories.type_id')
            ->join(
                DB::expr(
                    "(  SELECT *
                                FROM place_sub_categories 
                                WHERE disable = 0 
                                AND language_type={$param['language_type']}
                            ) AS place_sub_categories"
                ),
                'LEFT'
            )
            ->on(self::$_table_name.'.place_sub_category_type_id', '=', 'place_sub_categories.type_id')
            ->join(
                DB::expr(
                    "(  SELECT  place_id,
                                MIN(image_path) AS image_path, 
                                MIN(thm_image_path) AS thm_image_path
                        FROM place_images 
                        WHERE disable = 0 
                        AND is_default = 1
                        GROUP BY place_id
                    ) AS place_images"
                ),
                'LEFT'
            )
            ->on(self::$_table_name.'.id', '=', 'place_images.place_id')
            ->where(self::$_table_name.'.disable', '0');
                  
        $query->and_where_open();        
        $query->where($where);
        
        if (!$textSearch) {
            $query->where(DB::expr("            
                (
                    6371000 * 2 * ASIN(SQRT(
                    POWER(SIN(({$latitude} - abs(latitude)) * pi()/180 / 2),
                    2) + COS({$latitude} * pi()/180 ) * COS(abs(latitude) *
                    pi()/180) * POWER(SIN(({$longitude} - longitude) *
                    pi()/180 / 2), 2) ))
                ) <= {$param['radius']}
            "));
        }
        
        // search on Bmaps database only
        if ($searchType == 'bmaps') {
            $query->where_close();  
            if (!empty($param['physical_type_id'])) {
                $query->where(DB::expr(" 
                    places.id IN (
                        SELECT place_id 
                        FROM place_reviews JOIN users ON place_reviews.user_id = users.id
                        WHERE place_reviews.disable= 0 
                        AND users.disable= 0 
                        AND users.user_physical_type_id IN ({$param['physical_type_id']})
                    )
                "));
            }
            // KienNH, 2016/01/22 begin: add condition place_category_type_id
            if (!empty($param['place_category_type_id'])) {
                $query->where(self::$_table_name.'.place_category_type_id', $param['place_category_type_id']);
            }
            // KienNH end
            $query->group_by(self::$_table_name . '.id');
            $data = Model_Place_Information::merge_info(
                Lib\Arr::rand($query->execute(self::$slave_db)->as_array(), $limitPin * 2), // random n pinned places 
                $param['language_type'],
                $param['keyword']
            );
            return $data;
        }
        
        // search on google + Bmaps        
        Package::load('gmap');
        $gMap = new \Gmap();
        if (!empty($param['place_category_type_id'])) {
            foreach ($subCategories as $subCategory) {
                if ($subCategory['category_type_id'] == $param['place_category_type_id']) {
                    $googleTypes[] = $subCategory['google_name'];
                }
            }
            if (!empty($googleTypes)) {
                $param['types'] = implode('|', $googleTypes);
            }
            $query->where(self::$_table_name.'.place_category_type_id', $param['place_category_type_id']);
        }
        if (!empty($param['keyword'])) {
            $query->where(DB::expr("            
                places.id IN ( 
                    SELECT place_id 
                    FROM place_informations
                    WHERE disable = '0'
                        AND (name LIKE '%{$param['keyword']}%' OR name_kana LIKE '%{$param['keyword']}%')
                )
            ")); 
        }
        
        if ($textSearch) {
            $param['query'] = !empty($param['keyword']) ? $param['keyword'] : '';
        }
        
        $gmapData = $gMap->search_place($param, $textSearch);
        if (!empty($gmapData['results'])) {               
            $googlePlaceId = Lib\Arr::field($gmapData['results'], 'place_id'); 
            $query->or_where(self::$_table_name.'.google_place_id', 'IN', $googlePlaceId); 
        }
        $query->where_close();
        $query->order_by('distance');
        $query->group_by(self::$_table_name . '.id');
        $data = Model_Place_Information::merge_info(
            $query->execute(self::$slave_db)->as_array(), 
            $param['language_type'],
            $param['keyword']
        );
        $result = array();
        $places = array();
        foreach ($data as $place) {
            if (!empty($param['place_category_type_id']) && $param['place_category_type_id'] != $place['place_category_type_id']) {
                continue;
            }
            if (!empty($googlePlaceId) 
                && is_array($googlePlaceId) 
                && !in_array($place['google_place_id'], $googlePlaceId)) {
                $result[] = $place;               
            } else {
                $places[$place['google_place_id']] = $place;
            }
        }
        $result = Lib\Arr::rand($result, $limitPin); // random n pinned places 
        $subCategories = Lib\Arr::key_values($subCategories, 'google_name');
        foreach ($gmapData['results'] as &$location) {            
            $place = isset($places[$location['place_id']]) ? $places[$location['place_id']] : array();
            if (!isset($location['vicinity'])) {
                $location['vicinity'] = '';
            }
            if (empty($place['distance'])) {
                $place['distance'] = ((acos(sin($latitude * pi() / 180) * sin($location['geometry']['location']['lat'] * pi() / 180) + cos($latitude * pi() / 180) * cos($location['geometry']['location']['lat'] * pi() / 180) * cos(($longitude - $location['geometry']['location']['lng']) * pi() / 180)) * 180 / pi()) * 60 * 1.1515)*1000;
            }            
            $row = array(
                'id'                         => !empty($place['id']) ? $place['id'] : 0,
                'place_id'                   => !empty($place['id']) ? $place['id'] : 0,
                'google_place_id'            => $location['place_id'],
                'latitude'                   => !empty($place['latitude']) ? $place['latitude'] : $location['geometry']['location']['lat'],
                'longitude'                  => !empty($place['longitude']) ? $place['longitude'] : $location['geometry']['location']['lng'],
                'name'                       => !empty($place['name']) ? $place['name'] : $location['name'],
                'name_kana'                  => !empty($place['name_kana']) ? $place['name_kana'] : '',
                'address'                    => !empty($place['address']) ? $place['address'] : $location['vicinity'],
                'tel'                        => !empty($place['tel']) ? $place['tel'] : '',
                'review_point'               => !empty($place['review_point']) ? $place['review_point'] : 0,
                'entrance_steps'             => isset($place['entrance_steps']) ? $place['entrance_steps'] : '-1',
                'is_flat'                    => isset($place['is_flat']) ? $place['is_flat'] : '-1',
                'is_spacious'                => isset($place['is_spacious']) ? $place['is_spacious'] : '-1',
                'is_silent'                  => isset($place['is_silent']) ? $place['is_silent'] : '-1',
                'is_bright'                  => isset($place['is_bright']) ? $place['is_bright'] : '-1',
                'is_universal_manner'        => isset($place['is_universal_manner']) ? $place['is_universal_manner'] : '-1',
                'count_parking'              => isset($place['count_parking']) ? $place['count_parking'] : '-1',
                'count_wheelchair_parking'   => isset($place['count_wheelchair_parking']) ? $place['count_wheelchair_parking'] : '-1',
                'count_wheelchair_rent'      => isset($place['count_wheelchair_rent']) ? $place['count_wheelchair_rent'] : '-1',
                'count_babycar_rent'         => isset($place['count_babycar_rent']) ? $place['count_babycar_rent'] : '-1',
                'count_elevator'             => isset($place['count_elevator']) ? $place['count_elevator'] : '-1',
                'count_wheelchair_wc'        => isset($place['count_wheelchair_wc']) ? $place['count_wheelchair_wc'] : '-1',
                'count_ostomate_wc'          => isset($place['count_ostomate_wc']) ? $place['count_ostomate_wc'] : '-1',
                'count_nursing_room'         => isset($place['count_nursing_room']) ? $place['count_nursing_room'] : '-1',
                'count_smoking_room'         => isset($place['count_smoking_room']) ? $place['count_smoking_room'] : '-1',
                'count_plug'                 => isset($place['count_plug']) ? $place['count_plug'] : '-1',
                'count_wifi'                 => isset($place['count_wifi']) ? $place['count_wifi'] : '-1',
                'count_follow'               => !empty($place['count_follow']) ? $place['count_follow'] : 0,
                'count_favorite'             => !empty($place['count_favorite']) ? $place['count_favorite'] : 0,
                'with_assistance_dog'         => isset($place['with_assistance_dog']) ? $place['with_assistance_dog'] : '-1',
                'with_credit_card'           => isset($place['with_credit_card']) ? $place['with_credit_card'] : '-1',
                'with_emoney'                => isset($place['with_emoney']) ? $place['with_emoney'] : '-1',
                'place_category_type_id'     => !empty($place['place_category_type_id']) ? $place['place_category_type_id'] : 0,
                'place_category_id'          => !empty($place['place_category_id']) ? $place['place_category_id'] : 0,
                'place_category_name'        => !empty($place['place_category_name']) ? $place['place_category_name'] : '',
                'place_sub_category_type_id' => !empty($place['place_sub_category_type_id']) ? $place['place_sub_category_type_id'] : 0,
                'place_sub_category_id'      => !empty($place['place_sub_category_id']) ? $place['place_sub_category_id'] : 0,
                'place_sub_category_name'    => !empty($place['place_sub_category_name']) ? $place['place_sub_category_name'] : '',
                'place_image_path'           => !empty($place['place_image_path']) ? $place['place_image_path'] : '',
                'place_thm_image_path'       => !empty($place['place_thm_image_path']) ? $place['place_thm_image_path'] : '',
                'distance'                   => floatval($place['distance'])
            );
           
            // set images for new location
            if (empty($row['id'])
                && !empty($location['photos'][0]['photo_reference'])
            ) {
                $row['place_image_path'] = $gMap->get_place_photo(
                    array(
                        'maxwidth' => $location['photos'][0]['width'],
                        'photoreference' => $location['photos'][0]['photo_reference']
                    ),
                    false
                );
                $row['place_thm_image_path'] = $gMap->get_place_photo(
                    array(
                        'maxwidth' => 200,
                        'photoreference' => $location['photos'][0]['photo_reference']
                    ),
                    false
                );
            }
            
            // set category for new location by location type
            if (!empty($subCategories)
                && !empty($location['types'])
                && (empty($row['place_category_type_id'])
                    || empty($row['place_sub_category_type_id']))
            ) {
                // search Bmaps category by location type
                foreach ($location['types'] as $type) {
                    if (!empty($subCategories[$type])) {
                        $subCategory = $subCategories[$type];
                        break;
                    }
                }
                if (!empty($subCategory)) {
                    if (empty($row['place_category_type_id'])) {
                        $row['place_category_type_id'] = $subCategory['category_type_id'];
                        $row['place_category_id'] = $subCategory['category_id'];
                        $row['place_category_name'] = $subCategory['category_name'];
                    }
                    if (empty($row['place_sub_category_type_id'])) {
                        $row['place_sub_category_type_id'] = $subCategory['type_id'];
                        $row['place_sub_category_id'] = $subCategory['id'];
                        $row['place_sub_category_name'] = $subCategory['name'];
                    }
                    unset($subCategory);
                }
            }
            if (empty($row['name'])) {
                continue; 
            }
            if (!empty($param['place_category_type_id'])
                && !empty($row['place_category_type_id'])
                && $row['place_category_type_id'] != $param['place_category_type_id']
            ) {
                continue;                
            }
            $result[] = $row;
        }
        if (!empty($param['google_place_id'])) {
            return \Lib\Arr::filter($result, 'google_place_id', $param['google_place_id']);
        }
        return $result;
    }
    
    public static function autocomplete($param) {
        Package::load('gmap');
        return Gmap\Gmap::autocomplete($param);
    }

    /**
     * Set want to visit with place
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array|bool Detail Place or false if error
     */
    public static function want_to_visit($param)
    {
        if (empty($param['place_id'])) {
            static::errorNotExist('place_id');
            return false;
        }

        // remove favorite and follow
        if (isset($param['remove'])) {
            $error = 0;
            Model_Place_Favorite::disable_by_wanttovisit(
                array(
                    'user_id'  => $param['login_user_id'],
                    'place_id' => $param['place_id'],
                )
            );
            if (self::error()) {
                static::$error_code_validation = array();
                $error++;
            }
            Model_Follow_Place::disable(
                array(
                    'user_id'  => $param['login_user_id'],
                    'place_id' => $param['place_id'],
                )
            );
            if (self::error()) {
                $error++;
            }
            if ($error == 2) {
                return false;
            }
            static::$error_code_validation = array();
            return true;
        }

        $duplicateErrorCnt = 0;
        Model_Place_Favorite::add(
            array(
                'login_user_id' => $param['login_user_id'],
                'place_id' => $param['place_id'],
                'favorite_type' => 1
            )
        );
        
        if (self::hasError(self::ERROR_CODE_FIELD_NOT_EXIST)) {
            return false;
        }
        if (self::hasError(self::ERROR_CODE_FIELD_DUPLICATE)) {
            static::$error_code_validation = array();
            $duplicateErrorCnt++;
        }

        Model_Follow_Place::add(
            array(
                'login_user_id' => $param['login_user_id'],
                'place_id' => $param['place_id']
            )
        );
        if (self::hasError(self::ERROR_CODE_FIELD_NOT_EXIST)) {
            return false;
        }
        if (self::hasError(self::ERROR_CODE_FIELD_DUPLICATE)) {
            $duplicateErrorCnt++;
        }

        // if both duplicate error
        if ($duplicateErrorCnt == 2) {
            return false;
        }
        static::$error_code_validation = array();
        
        // only add point when action want to visit
        if (!isset($param['remove'])) {
            Model_User_Point::add(array(
                'user_id' => $param['login_user_id'],
                'type' => 4, // see config user_points_type
                'place_id' => $param['place_id'],
                'review_id' => 0,
                'comment_id' => 0
            ));
            if (self::error()) {
                return false;
            }
        }  
        return true;
    }

    /**
     * Add place by Google Place Id
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return int|bool Place id or false if error
     */
    public static function add_place_by_google_place_id($param)
    {
        $place = self::find(
            'first',
            array(
                'where' => array(
                    'google_place_id' => $param['google_place_id'],
                    'disable' => '0'
                )
            )
        );
        if (!empty($place)) {
            if (isset($param['license'])
                || isset($param['entrance_steps'])
                || isset($param['count_wheelchair_wc'])) {
                if (isset($param['entrance_steps'])) {
                    $place->set('entrance_steps', $param['entrance_steps']);  
                }
                if (isset($param['count_wheelchair_wc'])) {
                    $place->set('count_wheelchair_wc', $param['count_wheelchair_wc']);  
                }
                if (isset($param['license'])) {
                    $place->set('license', $param['license']);  
                }
                $place->save();
            }            
            return $place->get('id');
        }
        
        Package::load('gmap');
        $gMap = new \Gmap();
        $data = $gMap->get_place_detail($param);
        if ($data === false) {
            static::errorParamInvalid();
            return false;
        }
        if (empty($param['place_category_type_id']) || empty($param['place_sub_category_type_id'])) {
            $subCategories = Lib\Arr::key_values(
                Model_Place_Sub_Category::get_all(
                    array(
                        'language_type' => $param['language_type']
                    )
                ),
                'google_name'
            );
            foreach ($data['types'] as $type) {
                if (!empty($subCategories[$type])) {
                    $subCategory = $subCategories[$type];
                    break;
                }
            }
            if (!empty($subCategory)) {
                $param['place_category_type_id'] = $subCategory['category_type_id'];
                $param['place_sub_category_type_id'] = $subCategory['type_id'];
            }
        }
        foreach ($data['address_components'] as $address) {
            if (!empty($param['google_postal_code'])) {
                break;
            }
            foreach ($address['types'] as $addressType) {
                if ($addressType == 'postal_code') {
                    $param['google_postal_code'] = $address['short_name'];
                    break;
                }
            }
        }
        $placeId = self::add_update(
            array(
                'id'                         => !empty($param['id']) ? $param['id'] : 0,
                'place_category_type_id'     => !empty($param['place_category_type_id']) ? $param['place_category_type_id'] : 0,
                'place_sub_category_type_id' => !empty($param['place_sub_category_type_id']) ? $param['place_sub_category_type_id'] : 0,
                'google_place_id'            => $data['place_id'],
                'google_category_name'       => implode(',', $data['types']),
                'google_scope'               => $data['scope'],
                'google_postal_code'         => !empty($param['google_postal_code']) ? $param['google_postal_code'] : '',
                'name'                       => $data['name'],
                'name_kana'                  => '',
                'latitude'                   => $data['geometry']['location']['lat'],
                'longitude'                  => $data['geometry']['location']['lng'],
                'review_point'               => '0',
                'entrance_steps'             => isset($param['entrance_steps']) ? $param['entrance_steps'] : '-1',
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
                'count_wheelchair_wc'        => isset($param['count_wheelchair_wc']) ? $param['count_wheelchair_wc'] : '-1',
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
                'disable'                    => '0',
                'address'                    => !empty($data['formatted_address']) ? $data['formatted_address'] : '',
                'tel'                        => !empty($data['formatted_phone_number']) ? $data['formatted_phone_number'] : '',
                'language_type'              => $param['language_type'],
                'license'                    => isset($param['license']) ? $param['license'] : null,
            )
        );
        if ($placeId) {
            if (!empty($data['photo_url']) && isset($param['get_place_images'])) {
                Model_Place_Image::add_images_from_google(
                    array(
                        // 'user_id' => !empty($param['login_user_id']) ? $param['login_user_id'] : 0,// KienNH, 2016/03/02 Donot assign image for any user when get from Google
                        'place_id' => $placeId,
                        'photo_url' => $data['photo_url'],
                    )
                );
            }
            return $placeId;
        }
        return false;
    }

    /**
     * Get place for user's timeline
     *
     * @author thailh
     * @param array $param Input data
     * @return array|bool Detail Place or false if error
     */
    public static function get_for_timeline($param)
    {
        if (empty($param['page'])) {
            $param['page'] = 1;
        }
        $limitReview = 5;
        if (!isset($param['get_follow']) && !isset($param['get_near_place'])) {
            $param['get_follow'] = 1;
            $param['get_near_place'] = 1;
        }
        $user = Model_User::find($param['login_user_id']);
        if (empty($user)) {
            static::errorNotExist('user_id');
            return false;
        }
        $options['where'] = array(
            'disable' => '0',
            'user_id' => $param['login_user_id']
        );
        $follow_users = Lib\Arr::field(Model_Follow_User::find('all', $options), 'follow_user_id');
        $query = DB::select(
                self::$_table_name.'.id',
                self::$_table_name.'.google_place_id',
                self::$_table_name.'.google_category_name',
                self::$_table_name.'.google_postal_code',               
                self::$_table_name.'.latitude',
                self::$_table_name.'.longitude',
                self::$_table_name.'.review_point',
                self::$_table_name.'.entrance_steps',
                self::$_table_name.'.is_flat',
                self::$_table_name.'.is_spacious',
                self::$_table_name.'.is_silent',
                self::$_table_name.'.is_bright',
                self::$_table_name.'.is_universal_manner',
                self::$_table_name.'.count_parking',
                self::$_table_name.'.count_wheelchair_parking',
                self::$_table_name.'.count_wheelchair_rent',
                self::$_table_name.'.count_babycar_rent',
                self::$_table_name.'.count_elevator',
                self::$_table_name.'.count_wheelchair_wc',
                self::$_table_name.'.count_ostomate_wc',
                self::$_table_name.'.count_nursing_room',
                self::$_table_name.'.count_smoking_room',
                self::$_table_name.'.count_plug',
                self::$_table_name.'.count_wifi',
                self::$_table_name.'.count_follow',
                self::$_table_name.'.count_review',
                self::$_table_name.'.count_favorite',
                self::$_table_name.'.with_assistance_dog',                
                self::$_table_name.'.with_credit_card',
                self::$_table_name.'.with_emoney',               
                self::$_table_name.'.place_category_type_id',
                self::$_table_name.'.place_sub_category_type_id',
                array('place_categories.id', 'place_category_id'),
                array('place_categories.name', 'place_category_name'),
                // array('place_images.image_path', 'place_image_path'),
                // array('place_images.thm_image_path', 'place_thm_image_path'),
                // DB::expr("IF(ISNULL(place_favorites.id),0,1) AS is_favorite"),
                // 'place_favorites.favorite_type',
                self::$_table_name.'.indoor_url'
            )
            //->distinct()
            ->from(self::$_table_name)           
            ->join(
                DB::expr(
                    "(
                        SELECT * 
                        FROM place_categories 
                        WHERE disable = 0 
                        AND language_type = {$param['language_type']}
                   ) AS place_categories"
                ),
                'LEFT'
            )
            ->on(self::$_table_name.'.place_category_type_id', '=', 'place_categories.type_id')
            // ->join(
            //     DB::expr(
            //         "(
            //             SELECT * 
            //             FROM place_favorites 
            //             WHERE disable = 0   
            //             AND user_id = {$param['login_user_id']}
            //             AND (favorite_type&1) <> 0
            //        ) AS place_favorites"
            //     ),
            //     'LEFT'
            // )
            // ->on(self::$_table_name.'.id', '=', 'place_favorites.place_id')
            // ->join(
            //     DB::expr(
            //         "(  SELECT  place_id,
            //                     MIN(image_path) AS image_path, 
            //                     MIN(thm_image_path) AS thm_image_path
            //             FROM place_images 
            //             WHERE disable = 0 
            //             AND is_default = 1
            //             GROUP BY place_id
            //         ) AS place_images"
            //     ),
            //     'LEFT'
            // )
            // ->on(self::$_table_name.'.id', '=', 'place_images.place_id')
            ->where(self::$_table_name.'.disable', '=', 0);
        
        $where_or = '';
        if (isset($param['get_follow'])) {
            $where_or = "(";
            $where_or .= "
                places.id IN (
                    SELECT place_id 
                    FROM place_favorites
                    WHERE user_id = {$param['login_user_id']}  
                        AND disable = 0
                    )
            ";
            if (!empty($follow_users)) {
                $follow_user_id = implode(',', $follow_users);
                $where_or .= "
                OR places.id IN (
                    SELECT place_id 
                    FROM place_reviews 
                    WHERE user_id IN ({$follow_user_id})
                        AND disable = 0
                    Group by place_id 
                    )
                ";
            }
            $where_or .= ")";
        }
        if (isset($param['get_near_place'])) {
            $zipcode = !empty($user->get('zipcode')) ? $user->get('zipcode') : '';
            if (!empty($where_or)) {
                $where_or .= ' OR ';
            }
            $where_or .= "(
                places.count_review > 0 
                AND SUBSTRING(places.google_postal_code, 1, 3) = SUBSTRING('{$zipcode}', 1, 3)
            )";
        }
        if (!empty($param['place_category_type_id'])) { 
            $query->where(self::$_table_name.'.place_category_type_id', '=', $param['place_category_type_id']);
        }
        if (!empty($param['place_sub_category_type_id'])) {
            $query->where(self::$_table_name.'.place_sub_category_type_id', '=', $param['place_sub_category_type_id']);
        }
        $query->where(DB::expr('(' . $where_or . ')'));
        $query->group_by(self::$_table_name . '.id');
        $query->order_by(self::$_table_name.'.updated', 'DESC');
        if (!empty($param['page']) && !empty($param['limit'])) {
            $offset = ($param['page'] - 1) * $param['limit'];
            $query->limit($param['limit'])->offset($offset);
        }
        $places = $query->execute(self::$slave_db)->as_array(); 
        $total = !empty($places) ? DB::count_last_query(self::$slave_db) : 0;
        $data = Model_Place_Information::merge_info(
            $places,
            $param['language_type']
        );   
        if (!empty($data)) {
            $placeId = Lib\Arr::field($data, 'id');

            // get last place review
            $reviews = Model_Place_Review::get_all(
                array(
                    'place_id' => $placeId,
                    'login_user_id' => $param['login_user_id'],
                    'get_place_images' => 1,
                )
            );

            // get place's images
            $images = Model_Place_Image::get_all(
                array(
                    'place_id' => $placeId,
                    'is_default' => '1',
                )
            );
            $favorites = Model_Place_Favorite::find('all',
                array(
                     'where' => array(
                        array('user_id' , '=', $param['login_user_id']),
                        array('favorite_type','&1<>','0'),
                        array('disable','=', '0'),
                    )
                )
            );            
            foreach ($data as &$row) {
                $image = Lib\Arr::filter($images, 'place_id', $row['id'], false, false);
                $favorite = Lib\Arr::filter($favorites, 'place_id', $row['id'], false, false);
                if (!empty($image[0])) {
                   $row['place_image_path'] = $image[0]['image_path'];
                    $row['place_thm_image_path'] = $image[0]['thm_image_path'];
                    if(!empty($favorite)){
                        $row['is_favorite'] = 1;
                        $row['favorite_type'] = $favorite[0]['favorite_type'];    
                    } else {
                        $row['is_favorite'] = 0;
                        $row['favorite_type'] = 0;
                    }
                }

                // find reviews by place_id
                $user_reviews = array();
                foreach ($reviews as $review) {
                    if ($review['place_id'] == $row['id']) {
                        $user_reviews[$review['user_id']] = $review;
                    }
                }
                $row['place_reviews'] = array_slice(
                    $user_reviews,
                    0,
                    $limitReview
                );
            }
            unset($row);
        }
        return array('total' => $total, 'data' => $data);
    }

    /**
     * Get place for user's timeline
     *
     * @author thailh
     * @param array $param Input data
     * @return array|bool Detail Place or false if error
     */
    public static function get_for_profile($param)
    {        
        if (empty($param['login_user_id'])) {
            $param['login_user_id'] = 0;
        }
        if (!isset($param['get_follow']) && !isset($param['get_near_place'])) {
            $param['get_follow'] = 1;
            $param['get_near_place'] = 1;
        }
        $user = Model_User::find($param['user_id']);
        if (empty($user)) {
            static::errorNotExist('user_id');
            return false;
        }
        $query = DB::select(
                self::$_table_name.'.id',
                array(self::$_table_name.'.id', 'place_id'),
                self::$_table_name.'.google_place_id',
                self::$_table_name.'.google_category_name',
                self::$_table_name.'.google_postal_code',
                /*
                'place_informations.name',
                'place_informations.name_kana', */
                self::$_table_name.'.latitude',
                self::$_table_name.'.longitude',
                self::$_table_name.'.review_point',
                self::$_table_name.'.entrance_steps',
                self::$_table_name.'.is_flat',
                self::$_table_name.'.is_spacious',
                self::$_table_name.'.is_silent',
                self::$_table_name.'.is_bright',
                self::$_table_name.'.is_universal_manner',
                self::$_table_name.'.count_parking',
                self::$_table_name.'.count_wheelchair_parking',
                self::$_table_name.'.count_wheelchair_rent',
                self::$_table_name.'.count_babycar_rent',
                self::$_table_name.'.count_elevator',
                self::$_table_name.'.count_wheelchair_wc',
                self::$_table_name.'.count_ostomate_wc',
                self::$_table_name.'.count_nursing_room',
                self::$_table_name.'.count_smoking_room',
                self::$_table_name.'.count_plug',
                self::$_table_name.'.count_wifi',
                self::$_table_name.'.count_follow',
                self::$_table_name.'.count_favorite',
                self::$_table_name.'.count_review',
                self::$_table_name.'.with_assistance_dog',                
                self::$_table_name.'.with_credit_card',
                self::$_table_name.'.with_emoney',
                /*
                'place_informations.address',
                'place_informations.tel',
                'place_informations.station_near_by',
                'place_informations.business_hours',
                'place_informations.regular_holiday',
                'place_informations.place_memo', */
                self::$_table_name.'.place_category_type_id',
                array('place_categories.id', 'place_category_id'),
                array('place_categories.name', 'place_category_name'),
                self::$_table_name.'.place_sub_category_type_id',
                array('place_sub_categories.id', 'place_sub_category_id'),
                array('place_sub_categories.name', 'place_sub_category_name'),
                DB::expr("IF(place_favorites.favorite_type&1,1,0) AS is_favorite"),
                self::$_table_name.'.indoor_url'
            )
            ->distinct()
            ->from(self::$_table_name)
            ->join('place_informations')
            ->on(self::$_table_name.'.id', '=', 'place_informations.place_id')            
            ->join(
                DB::expr(
                    "(
                        SELECT * 
                        FROM place_categories 
                        WHERE disable = 0 
                        AND language_type = {$param['language_type']}
                   ) AS place_categories"
                ),
                'LEFT'
            )
            ->on(self::$_table_name.'.place_category_type_id', '=', 'place_categories.type_id')
            ->join(
                DB::expr(
                    "(  SELECT *
                           FROM place_sub_categories 
                           WHERE disable = 0 
                           AND language_type={$param['language_type']}
                       ) AS place_sub_categories"
                ),
                'LEFT'
            )
            ->on(self::$_table_name.'.place_sub_category_type_id', '=', 'place_sub_categories.type_id')
            ->join('place_favorites')
            ->on('places.id', '=', 'place_favorites.place_id')
            ->where('places.disable', '=', 0)
            ->where('place_favorites.disable', '=', 0)
            ->where(DB::expr('(place_favorites.favorite_type&2)<>0'))
            ->where('place_favorites.user_id', '=', $param['user_id'])
            ->order_by('places.created', 'DESC');
        if (!empty($param['place_category_type_id'])) {
            $query->where(self::$_table_name.'.place_category_type_id', '=', $param['place_category_type_id']);
        }
        if (!empty($param['place_sub_category_type_id'])) {
            $query->where(self::$_table_name.'.place_sub_category_type_id', '=', $param['place_sub_category_type_id']);
        }
        if (!empty($param['page']) && !empty($param['limit'])) {
            $offset = ($param['page'] - 1) * $param['limit'];
            $query->limit($param['limit'])->offset($offset);
        }    
        $places = $query->execute(self::$slave_db)->as_array();
        $total = !empty($places) ? DB::count_last_query(self::$slave_db) : 0;
        $data = Model_Place_Information::merge_info(
            $places,
            $param['language_type']
        );        
        if (!empty($data)) {
            $placeId = Lib\Arr::field($data, 'id');
            
            // get default image
            $images = Model_Place_Image::get_all(
                array(
                    'place_id' => $placeId,
                    'is_default' => '1',
                )
            );                       
            
            // get last place review
            $reviews = Model_Place_Review::get_all(
                array(
                    'place_id' => $placeId,
                    'login_user_id' => $param['login_user_id'],
                    'user_id' => $param['user_id'],
                    'get_place_images' => 1
                )
            );    
            
            foreach ($data as &$row) {
                $image = Lib\Arr::filter($images, 'place_id', $row['id'], false, false);
                if (!empty($image[0])) {
                    $row['place_image_path'] = $image[0]['image_path'];
                    $row['place_thm_image_path'] = $image[0]['thm_image_path'];
                }
                $row['place_reviews'] = Lib\Arr::filter($reviews, 'place_id', $row['id'], false, false);
            }
            unset($row);
        }
        return array('total' => $total, 'data' => $data);
    }

    /**
     * Get Place's recommend
     *
     * @author diennvt
     * @param array $param Input data
     * @return array List Place's recommend
     */
    public static function get_recommend($param)
    {        
        if (empty($param['login_user_id'])) {
            $param['login_user_id'] = 0;
        }
        if (empty($param['limit'])) {
            $param['limit'] = 10;
        }
        if (empty($param['page'])) {
            $param['page'] = 1;
        }
        if (empty($param['language_type'])) {
            $param['language_type'] = 1;
        }
               
        $query = DB::select(
                self::$_table_name.'.id',
                self::$_table_name.'.google_place_id',
                self::$_table_name.'.google_category_name',
                self::$_table_name.'.google_postal_code',               
                self::$_table_name.'.latitude',
                self::$_table_name.'.longitude',
                self::$_table_name.'.review_point',
                self::$_table_name.'.entrance_steps',
                self::$_table_name.'.is_flat',
                self::$_table_name.'.is_spacious',
                self::$_table_name.'.is_silent',
                self::$_table_name.'.is_bright',
                self::$_table_name.'.is_universal_manner',
                self::$_table_name.'.count_parking',
                self::$_table_name.'.count_wheelchair_parking',
                self::$_table_name.'.count_wheelchair_rent',
                self::$_table_name.'.count_babycar_rent',
                self::$_table_name.'.count_elevator',
                self::$_table_name.'.count_wheelchair_wc',
                self::$_table_name.'.count_ostomate_wc',
                self::$_table_name.'.count_nursing_room',
                self::$_table_name.'.count_smoking_room',
                self::$_table_name.'.count_plug',
                self::$_table_name.'.count_wifi',
                self::$_table_name.'.count_follow',
                self::$_table_name.'.count_favorite',
                self::$_table_name.'.with_assistance_dog',                
                self::$_table_name.'.with_credit_card',
                self::$_table_name.'.with_emoney',       
                self::$_table_name.'.license',
                self::$_table_name.'.source_url',
                self::$_table_name.'.place_category_type_id',
                array('place_categories.id', 'place_category_id'),
                array('place_categories.name', 'place_category_name'),
                self::$_table_name.'.place_sub_category_type_id',
                array('place_sub_categories.id', 'place_sub_category_id'),
                array('place_sub_categories.name', 'place_sub_category_name'),
            //    DB::expr("IF(ISNULL(place_favorites.id),0,1) AS is_favorite"),
            //    'place_favorites.favorite_type',
                DB::expr(self::sql_distance($param)),
                self::$_table_name.'.indoor_url'
            )
            ->from(self::$_table_name)           
            // ->join(
            //     DB::expr(
            //         "
            //             (SELECT id, place_id, favorite_type
            //             FROM place_favorites
            //             WHERE user_id = {$param['login_user_id']}
            //                 AND (favorite_type&1) <> 0
            //                 AND disable = 0) place_favorites
            //         "
            //     ),
            //     'LEFT'
            // )
            // ->on(self::$_table_name.'.id', '=', 'place_favorites.place_id')
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
            ->on(self::$_table_name.'.place_category_type_id', '=', 'place_categories.type_id')
            ->join(
                DB::expr(
                    "(  SELECT *
                           FROM place_sub_categories 
                           WHERE disable = 0 
                           AND language_type={$param['language_type']}
                       ) AS place_sub_categories"
                ),
                'LEFT'
            )
            ->on(self::$_table_name.'.place_sub_category_type_id', '=', 'place_sub_categories.type_id')
            ->where(self::$_table_name.'.disable', 0)            
            ->order_by(self::$_table_name.'.count_favorite', 'DESC')
            ->order_by(self::$_table_name.'.review_point', 'DESC')
            ->order_by(self::$_table_name.'.count_review', 'DESC');
        if (!empty($param['page']) && !empty($param['limit'])) {
            $offset = ($param['page'] - 1) * $param['limit'];
            $query->limit($param['limit'])->offset($offset);
        }     
        $data = $query->execute(self::$slave_db)->as_array();
        $total = !empty($data) ? DB::count_last_query(self::$slave_db) : 0;
        $data = Model_Place_Information::merge_info(
            $data,
            $param['language_type']
        );


        
        if (!empty($data)) {
            $placeId = Lib\Arr::field($data, 'id');   
            // get place's images
            $images = Model_Place_Image::get_all(
                array(
                    'place_id' => $placeId,
                    'is_default' => '1',
                )
            );
            $favorites = Model_Place_Favorite::find('all',
                array(
                     'where' => array(
                        array('user_id' , '=', $param['login_user_id']),
                        array('favorite_type','&1<>','0'),
                        array('disable','=', '0'),
                    )
                )
            );
            foreach ($data as &$row) {
                $image = Lib\Arr::filter($images, 'place_id', $row['id'], false, false);
                $favorite = Lib\Arr::filter($favorites, 'place_id', $row['id'], false, false);
                if (!empty($image[0])) {
                    $row['place_image_path'] = $image[0]['image_path'];
                    $row['place_thm_image_path'] = $image[0]['thm_image_path'];
                    if(!empty($favorite)){
                        $row['is_favorite'] = 1;
                        $row['favorite_type'] = $favorite[0]['favorite_type'];    
                    } else {
                        $row['is_favorite'] = 0;
                        $row['favorite_type'] = 0;
                    }
                }
            }
            unset($row);
        }
        return array('total' => $total, 'data' => $data);
    }

    /**
     * Count place by category
     *
     * @author thailh
     * @param array $param Input data
     * @return array List Place Favorite
     */
    public static function count_by_category($param)
    {
        $query = DB::select(
            'place_category_type_id',
            DB::expr('COUNT(id) AS count_place')
        )
            ->from(self::$_table_name)
            ->where('disable', '=', '0')
            ->group_by('place_category_type_id');
        // filter by keyword
        if (!empty($param['place_category_type_id'])) {
            if (!is_array($param['place_category_type_id'])) {
                $param['place_category_type_id'] = array($param['place_category_type_id']);
            }
            $query->where('place_category_type_id', 'IN', $param['place_category_type_id']);
        }
        $data = $query->execute(self::$slave_db)->as_array();
        return $data;
    }
    
    /**
     * Get detail for edit
     *
     * @author thailh
     * @param array $param Input data
     * @return array|bool Detail Help or false if error
     */
    public static function get_detail_for_edit($param)
    { 
        if (!empty($param['language_type']) && !empty($param['place_id'])) {
            $options['where'] = array(
                array('place_id', '=', $param['place_id']),
                array('language_type', '=', $param['language_type'])
            ); 
            $data = self::find('first', $options); 
            if (empty($data)) {
                return array(
                    'id' => !empty($param['id']) ? $param['id'] : 0,
                    'place_id' => $param['place_id'],
                    'language_type' => $param['language_type'],
                );
            }
        } elseif (!empty($param['id'])) {
            $options['where'] = array(
                array('id', '=', $param['id']),
            );
            $data = self::find('first', $options);
            if (empty($data)) {
                self::errorNotExist('id');
                return false;
            }
        }
        $data = Model_Place_Information::merge_info(
            $data->_data,
            $param['language_type']
        );
        if (!empty($param['language_type'])) {
            $data['language_type'] = $param['language_type'];
        }                
        return $data;
    }  
    
    /**
     * Add or update info for Place
     *
     * @author Caolp
     * @param array $param Input data
     * @return int|bool Place id or false if error
     */
    public static function updatePlace($param)
    {
        $id = !empty($param['id']) ? $param['id'] : 0;        
        // check exist
        if (!empty($id)) {
            $place = self::find(
                $id,
                array(
                    'from_cache' => false
                )
            );
            if (empty($place)) {
                self::errorNotExist('place_id');
                return false;
            }
        }
        if (!empty($param['sub_category_id'])) {
            $subCategory = Model_Place_Sub_Category::get_detail(
                array(
                    'id' => $param['sub_category_id']
                )
            );
            if (empty($subCategory)) {
                static::errorNotExist('sub_category_id');
                return false;
            }
            $param['place_category_type_id'] = $subCategory->get('category_type_id');
            $param['place_sub_category_type_id'] = $subCategory->get('type_id');
        }
        if (isset($param['place_category_type_id'])) {
            $place->set('place_category_type_id', $param['place_category_type_id']);
        }
        if (isset($param['place_sub_category_type_id'])) {
            $place->set('place_sub_category_type_id', $param['place_sub_category_type_id']);
        } 
        if (isset($param['entrance_steps'])) {
            $place->set('entrance_steps', $param['entrance_steps']);
        }
        if (isset($param['is_flat'])) {
            $place->set('is_flat', $param['is_flat']);
        }
        if (isset($param['is_spacious'])) {
            $place->set('is_spacious', $param['is_spacious']);
        }
        if (isset($param['is_silent'])) {
            $place->set('is_silent', $param['is_silent']);
        }
        if (isset($param['is_bright'])) {
            $place->set('is_bright', $param['is_bright']);
        }
        if (isset($param['is_universal_manner'])) {
            $place->set('is_universal_manner', $param['is_universal_manner']);
        }
        if (isset($param['count_parking'])) {
            $place->set('count_parking', $param['count_parking']);
        }
        if (isset($param['count_wheelchair_parking'])) {
            $place->set('count_wheelchair_parking', $param['count_wheelchair_parking']);
        }
        if (isset($param['count_wheelchair_rent'])) {
            $place->set('count_wheelchair_rent', $param['count_wheelchair_rent']);
        }
        if (isset($param['count_babycar_rent'])) {
            $place->set('count_babycar_rent', $param['count_babycar_rent']);
        }
        if (isset($param['count_elevator'])) {
            $place->set('count_elevator', $param['count_elevator']);
        }
        if (isset($param['count_wheelchair_wc'])) {
            $place->set('count_wheelchair_wc', $param['count_wheelchair_wc']);
        }
        if (isset($param['count_ostomate_wc'])) {
            $place->set('count_ostomate_wc', $param['count_ostomate_wc']);
        }
        if (isset($param['count_nursing_room'])) {
            $place->set('count_nursing_room', $param['count_nursing_room']);
        }
        if (isset($param['count_smoking_room'])) {
            $place->set('count_smoking_room', $param['count_smoking_room']);
        }
        if (isset($param['count_plug'])) {
            $place->set('count_plug', $param['count_plug']);
        }
        if (isset($param['count_wifi'])) {
            $place->set('count_wifi', $param['count_wifi']);
        }
        if (isset($param['with_assistance_dog'])) {
            $place->set('with_assistance_dog', $param['with_assistance_dog']);
        }       
        if (isset($param['with_credit_card'])) {
            $place->set('with_credit_card', $param['with_credit_card']);
        }
        if (isset($param['with_emoney'])) {
            $place->set('with_emoney', $param['with_emoney']);
        }
        if (isset($param['disable']) && $param['disable'] !== '') {
            $place->set('disable', $param['disable']);
        }
        if (isset($param['license'])) {
            $place->set('license', $param['license']);
        }
        if (isset($param['source_url'])) {
            $place->set('source_url', $param['source_url']);
        }
        if (isset($param['indoor_url'])) {
            $place->set('indoor_url', $param['indoor_url']);
        }
        // save to database      
        if ($place->save()) {            
            if (isset($param['name'])
                || isset($param['name_kana'])
                || isset($param['address'])
                || isset($param['tel'])
                || isset($param['station_near_by'])
                || isset($param['business_hours'])
                || isset($param['regular_holiday'])
                || isset($param['place_memo'])
            ) {
                $param['place_id'] = $place->id;
                if (!Model_Place_Information::add_update($param)) {
                    \LogLib::warning("Can not add/update place_informations", __METHOD__, $param);
                    return false;
                }
            }
            self::DeleteCacheDetail($param,__METHOD__);
            return !empty($place->id) ? $place->id : 0;
        }
        return false;
    }

    /**
     * Delete Detail Cache
     * self::DeleteCacheDetail
     * @author K.Shogo
     * @param array $param Input data
     * @return bool when delete success return true
     */
    public static function DeleteCacheDetail ($param,$backtrace = __METHOD__) {
            
        if (empty($param['language_type'])){
            $param['language_type'] = 1;
        }
        if (!empty($param['place_id'])){
            $deleteID = $param['place_id'];
        } elseif (!empty($param['id'])) {
            $deleteID = $param['id'];
        } else {
            return false;
        }

        #prepare for using cache
        $cacheTitles[] = 'language_type=' . $param['language_type'];
        $cacheTitles[] = 'id=' . $deleteID;
        
        $tmptxt = implode('&' , $cacheTitles);
        $cacheTitle = "PlacesDetail" . md5($tmptxt);
        

        $result = Cache::delete($cacheTitle);
        \LogLib::info("[Cache] deleted:", $backtrace, $cacheTitle);

        return true;
        
    }

}
