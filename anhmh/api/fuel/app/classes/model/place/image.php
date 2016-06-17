<?php

/**
 * Any query in Model Place Image
 *
 * @package Model
 * @created 2015-06-29
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Model_Place_Image extends Model_Abstract
{
    /** @var array $_properties field of table */
    protected static $_properties = array(
        'id',
        'user_id',
        'place_id',
        'place_review_id',
        'image_path',
        'thm_image_path',
        'is_default',
        'is_review_default',
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
    protected static $_table_name = 'place_images';

    /**
     * Add or update info for Place Image
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return int|bool Place Image id or false if error
     */
    public static function add_update($param)
    {   
        $id = !empty($param['id']) ? $param['id'] : 0;
        $self = new self;
        // check exist
        if (!empty($id)) {
            $self = self::find($id);
            if (empty($self)) {
                self::errorNotExist('place_image_id');
                return false;
            }
        } else {
            if (empty($param['user_id']) 
                || empty($param['place_id']) 
                || empty($param['place_review_id']) 
                || empty($param['image_path']) 
                || empty($param['thm_image_path'])) {
                self::errorParamInvalid();
                return false;
            }
        }
        // set value
        if (isset($param['user_id'])) {
            $self->set('user_id', $param['user_id']);
        }
        if (!empty($param['place_id'])) {
            $self->set('place_id', $param['place_id']);
        }
        if (isset($param['place_review_id']) && $param['place_review_id'] !== '') {
            $self->set('place_review_id', $param['place_review_id']);
        }
        if (isset($param['image_path'])) {
            $self->set('image_path', $param['image_path']);
        }
        if (isset($param['thm_image_path'])) {
            $self->set('thm_image_path', $param['thm_image_path']);
        }
        // save to database
        if ($self->save()) {
            if (empty($self->id)) {
                $self->id = self::cached_object($self)->_original['id'];
            }
            return !empty($self->id) ? $place->id : 0;
        }
        return false;
    }

    /**
     * Get list Place Image (using array count)
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array List Place Image
     */
    public static function get_list($param)
    {
        $query = DB::select(
                self::$_table_name.'.*',
                'place_reviews.comment',
                'place_reviews.count_like',
                array('users.name', 'user_name'),
                array('place_informations.name', 'place_name')
            )
            ->from(self::$_table_name)
            
            ->join('users')
            ->on(self::$_table_name.'.user_id', '=', 'users.id')
            
            ->join('places')
            ->on(self::$_table_name.'.place_id', '=', 'places.id')
            
            ->join('place_reviews')
            ->on(self::$_table_name.'.place_review_id', '=', 'place_reviews.id')
            
            ->join('place_informations', 'LEFT')
            ->on(self::$_table_name.'.place_id', '=', 'place_informations.place_id')
            ->and_on('place_informations.language_type', '=', 'place_reviews.language_type');
        // filter by keyword
        if (!empty($param['user_id'])) {
            $query->where(self::$_table_name.'.user_id', '=', $param['user_id']);
        }
        if (!empty($param['place_id'])) {
            $query->where(self::$_table_name.'.place_id', '=', $param['place_id']);
        }
        if (!empty($param['place_review_id'])) {
            $query->where(self::$_table_name.'.place_review_id', '=', $param['place_review_id']);
        }
        if (!empty($param['image_path'])) {
            $query->where(self::$_table_name.'.image_path', 'LIKE', "%{$param['image_path']}%");
        }
        if (!empty($param['thm_image_path'])) {
            $query->where(self::$_table_name.'.thm_image_path', 'LIKE', "%{$param['thm_image_path']}%");
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
            $query->order_by('place_reviews.count_like', 'DESC');
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
     * Get list Place Image (using array count)
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array List Place Image
     */
    public static function get_for_profile($param)
    {
        $query = DB::select(
                self::$_table_name.'.id',
                self::$_table_name.'.place_id',
                self::$_table_name.'.place_review_id',
                self::$_table_name.'.is_default',
                self::$_table_name.'.is_review_default',
                self::$_table_name.'.image_path',
                self::$_table_name.'.thm_image_path'
            )
            ->from(self::$_table_name)
            ->join('places')
            ->on(self::$_table_name . '.place_id', '=', 'places.id')
            ->where(self::$_table_name.'.disable', '=', '0')
            ->where(self::$_table_name.'.user_id', '=', $param['user_id'])            
            ->order_by(self::$_table_name.'.created', 'DESC');
        if (!empty($param['page']) && !empty($param['limit'])) {
            $offset = ($param['page'] - 1) * $param['limit'];
            $query->limit($param['limit'])->offset($offset);
        }
        $data = $query->execute(self::$slave_db)->as_array();
        $total = !empty($data) ? DB::count_last_query(self::$slave_db) : 0;
        return array('total' => $total, 'data' => $data);
    }

    /**
     * Get all Place Image (without array count)
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array List Place Image
     */
    public static function get_all($param)
    {
        $query = DB::select(
                self::$_table_name.'.id',
                self::$_table_name.'.user_id',
                self::$_table_name.'.place_id',
                self::$_table_name.'.place_review_id',
                self::$_table_name.'.is_default',
                self::$_table_name.'.is_review_default',
                DB::expr("IFNULL(IF(image_path='',NULL,image_path), '" . \Config::get('no_image_place') . "') AS image_path"),
                DB::expr("IFNULL(IF(thm_image_path='',NULL,thm_image_path), '" . \Config::get('no_image_place') . "') AS thm_image_path")
            )
            ->from(self::$_table_name)
            ->join('places')
            ->on(self::$_table_name . '.place_id', '=', 'places.id')
            ->where(self::$_table_name.'.disable', '=', '0');
        if (empty($param['ignore_place_disable'])) {
            $query->where('places.disable', '=', '0');
        }
        // filter by keyword
        if (!empty($param['user_id'])) {
            if (!is_array($param['user_id'])) {
                $param['user_id'] = array($param['user_id']);
            }
            $query->where(self::$_table_name.'.user_id', 'IN', $param['user_id']);
        }
        if (!empty($param['place_id'])) {
            if (!is_array($param['place_id'])) {
                $param['place_id'] = array($param['place_id']);
            }
            $query->where(self::$_table_name.'.place_id', 'IN', $param['place_id']);
        }
        if (!empty($param['place_review_id'])) {
            if (!is_array($param['place_review_id'])) {
                $param['place_review_id'] = array($param['place_review_id']);
            }
            $query->where(self::$_table_name.'.place_review_id', 'IN', $param['place_review_id']);
        }
        if (!empty($param['is_default'])) {
            $query->where(self::$_table_name.'.is_default', '=', $param['is_default']);
        }
        if (!empty($param['is_review_default'])) {
            $query->where(self::$_table_name.'.is_review_default', '=', $param['is_review_default']);
        }
        // get review image only, not get google images
        if (isset($param['review_image_only'])) {
            $query->where(self::$_table_name.'.place_review_id', '>', '0');
        }
        $query->order_by(self::$_table_name.'.is_default', 'DESC');
        $query->order_by(self::$_table_name.'.updated', 'DESC');
        if (!empty($param['limit'])) {
            $query->limit($param['limit']);
        }
        // get data
        $data = $query->execute(self::$slave_db)->as_array();
        return $data;
    }

    /**
     * Disable/Enable list Place Image
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
            } else {
                self::errorNotExist('place_image_id');
                return false;
            }
        }
        return true;
    }

    /**
     * Get detail Place Image
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array|bool Detail Place Image or false if error
     */
    public static function get_detail($param)
    {
        $data = self::find($param['id']);
        if (empty($data)) {
            static::errorNotExist('place_image_id');
            return false;
        }
        return $data;
    }

    /**
     * Add or update multiple images
     *
     * @author Le Tuan Tu
     * @param array $param Array image path
     * @return int|bool Place Image id or false if error
     */
    public static function add_update_multiple($param)
    {
        if (empty($param['user_id'])
            || empty($param['place_id'])
            || empty($param['image_path'])
        ) {
            static::errorParamInvalid('user_id_or_place_id_or_image_path');
            return false;
        }
        $dataUpdate = array();
        foreach ($param['image_path'] as $imagePath) {
            $dataUpdate[] = array(
                'user_id'         => $param['user_id'],
                'place_id'        => $param['place_id'],
                'place_review_id' => !empty($param['place_review_id']) ? $param['place_review_id'] : 0,
                'image_path'      => $imagePath,
            );
        }
        // execute insert/update
        if (!empty($dataUpdate) && !parent::batchInsert(
                self::$_table_name,
                $dataUpdate,
                array('disable' => DB::expr('VALUES(disable)')),
                false
            )
        ) {
            \LogLib::warning('Can not update '.self::$_table_name, __METHOD__, $param);
            return false;
        }
        return true;
    }

    /**
     * Add multiple from google
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return int|bool Place Image id or false if error
     */
    public static function add_images_from_google($param)
    {
        // KienNH, 2016/03/02: Donot assign image for any user ($param['user_id'])
        if (/*empty($param['user_id'])
            || */empty($param['place_id'])
            || empty($param['photo_url'])
        ) {
            static::errorParamInvalid('place_id_or_photo_url');
            return false;
        }       
        $image = self::find(
            'first',
            array(
                'where' => array(
                    'place_id' => $param['place_id'],
                    'is_default' => '1',
                    'disable' => '0',
                )
            )
        );     
        $dataUpdate = array();
        foreach ($param['photo_url'] as $i => $photo) {
            // KienNH 2016/03/02 Check valid image
            if (empty($photo['image_path']) || empty($photo['thm_image_path'])) {
                continue;
            }
            $dataUpdate[] = array(
                'user_id' => 0,// KienNH, 2016/03/02: Donot assign image for any user ($param['user_id'])
                'place_id' => $param['place_id'],
                'place_review_id' => '0',
                'is_default' => ($i == 0 && empty($image)) ? 1 : 0,
                'image_path' => $photo['image_path'],
                'thm_image_path' => $photo['thm_image_path'],
            );
            // KienNH, 2016/03/02 add all image
            //break; // add one image only
        }
        // execute insert/update
        if (!empty($dataUpdate) && !parent::batchInsert(
                self::$_table_name,
                $dataUpdate,
                array(),
                false
            )
        ) {
            \LogLib::warning('Can not update '.self::$_table_name, __METHOD__, $param);
            return false;
        }
        return true;
    }

    /**
     * Add multiple from google
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return int|bool Place Image id or false if error
     */
    public static function upload_images_for_review($param)
    {
        if (empty($param['user_id'])
            || empty($param['place_id'])
            || empty($param['place_review_id'])
            || empty($param['image_path'])
        ) {
            static::errorParamInvalid('user_id_or_place_id_or_place_review_id_or_image_path');
            return false;
        }
        /*
        $uploadResult = \Lib\Util::uploadImage($thumb = 'places');
        if ($uploadResult['status'] != 200) {
            self::setError($uploadResult['error']);            
            return false;
        }
        * 
        */
        $images = self::find(
            'all',
            array(
                'where' => array(
                    'place_id' => $param['place_id'],                    
                    'disable' => '0',
                )
            )
        );
        $param['is_default'] = 1;
        $param['is_review_default'] = 1;
        if (!empty($images)) {
            foreach ($images as $image) {            
                // update is_default = 0 for google image
                if ($image->get('place_review_id') == 0 && $image->get('is_default') == 1) {
                    $image->set('is_default', '0');
                    $image->update();                
                }
                // find default image of a review
                if ($image->get('place_review_id') == $param['place_review_id'] 
                    && $image->get('is_review_default') == 1) {
                    $param['is_review_default'] = 0;
                }
                if ($image->get('place_review_id') > 0 && $image->get('is_default') == 1) {
                    $param['is_default'] = 0;
                }
            }
        }
        $thumb = 'places';
        $thumbConfig = Config::get('thumbs');
        if (!empty($thumb) && !empty($thumbConfig[$thumb][0])) {
            $thumbSize = $thumbConfig[$thumb][0];
        }        
        $dataUpdate = array();
        foreach ($param['image_path'] as $image_path) {
            $ext = strtolower(strrchr($image_path, '.'));
            $thm_image_path = $image_path;
            if (!empty($thumbSize)) {
                $thm_image_path = str_replace($ext, '_'.$thumbSize.$ext, $image_path);
            }            
            $dataUpdate[] = array(
                'user_id' => $param['user_id'],
                'place_id' => $param['place_id'],
                'place_review_id' => $param['place_review_id'],
                'is_default' => $param['is_default'],
                'is_review_default' => $param['is_review_default'],
                'image_path' => $image_path,
                'thm_image_path' => $thm_image_path,
            );
            if ($param['is_default'] == 1) {
                $param['is_default'] = 0;
            }
            if ($param['is_review_default'] == 1) {
                $param['is_review_default'] = 0;
            }
        }
        // execute insert/update
        if (!empty($dataUpdate) && !parent::batchInsert(
                self::$_table_name,
                $dataUpdate,
                array(),
                false
            )
        ) {
            \LogLib::warning('Can not update '.self::$_table_name, __METHOD__, $param);
            return false;
        }
        
        // update google image to default = 0
        /*
        $self = self::find(
            'first',
            array(
                'where' => array(
                    'is_default' => '1',
                    'place_id' => $param['place_id'],
                    'place_review_id' => '0',
                    'disable' => '0'
                )
            )
        );
        if (!empty($self)) {
            $self->set('is_default', '0');
            $self->save();
        }
        */
        return true;
    }
    
    /**
     * Change default image of Spot
     *
     * @author KienNH
     * @param array $param Input data
     * @return bool Success or otherwise
     */
    public static function change_default($param)
    {
        // Verify
        $image = self::find(
            'first',
            array(
                'where' => array(
                    'place_id' => $param['place_id'],
                    'id' => $param['image_id'],
                )
            )
        );
        
        if (empty($image)) {
            self::errorNotExist('place_image_id');
            return false;
        }
        
        // Update old data
        DB::update(self::$_table_name)
                ->value('is_default', 0)
                ->where('is_default', '=', 1)
                ->execute();
        
        // Set new data
        $image->set('is_default', 1);
        if (!$image->save()) {
            \LogLib::warning('Can not update default image '.self::$_table_name, __METHOD__, $param);
            return false;
        }
        
        return true;
    }

}
