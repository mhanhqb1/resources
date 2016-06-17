<?php

/**
 * Any query in Model Place Review Like
 *
 * @package Model
 * @created 2015-06-30
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Model_Place_Review_Like extends Model_Abstract
{
    /** @var array $_properties field of table */
    protected static $_properties = array(
        'id',
        'user_id',
        'place_review_id',
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
    protected static $_table_name = 'place_review_likes';

    /**
     * Add info for Place Review Like
     *
     * @author Le Tuan Tu
     * @param array $param Input data.
     * @return int|bool Place Review Like id or false if error
     */
    public static function add($param)
    {
        $query = DB::select(
            array('place_reviews.id', 'place_review_id'),
            array('place_review_likes.id', 'like_id'),
            array('place_review_likes.user_id', 'user_id'),
            array('place_review_likes.disable', 'like_disable')
        )
            ->from('place_reviews')
            ->join(
                DB::expr(
                    "(SELECT * FROM place_review_likes
                     WHERE user_id = {$param['login_user_id']}) AS place_review_likes"
                ),
                'LEFT'
            )
            ->on('place_reviews.id', '=', 'place_review_likes.place_review_id')
            ->where('place_reviews.id', '=', $param['place_review_id'])
            ->where('place_reviews.disable', '=', '0');
        $data = $query->execute()->offsetGet(0);
        if (empty($data['place_review_id'])) {
            static::errorNotExist('place_review_id');
            return false;
        }
        if (!empty($data['user_id']) && $data['like_disable'] == 0) {
            static::errorDuplicate('user_id');
            return false;
        }
        $new = false;
        if (!empty($data['user_id']) && $data['like_disable'] == 1) {
            $dataUpdate = array(
                'id'      => $data['like_id'],
                'disable' => '0'
            );
        } else {
            $new = true;
            $dataUpdate = array(
                'place_review_id' => $data['place_review_id'],
                'user_id'         => $param['login_user_id']
            );
        }
        $like = new self($dataUpdate, $new);
        if ($like->save()) {
            if ($new == true) {
                $like->id = self::cached_object($like)->_original['id'];
            }
            // KienNH, 2015/12/18: Add push message
            if ($like->get('disable') == 0) {
                $like->set('place_review_id', $param['place_review_id']);
                $like->set('user_id', $param['login_user_id']);
                Model_Notice::add_push_message($like, $param);
            }
            // KienNH, end
            return $like->id;
        }
        return false;
    }

    /**
     * Get list Place Review Like (using array count)
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array List Place Review Like
     */
    public static function get_list($param)
    {
        $query = DB::select(
                array('users.name', 'user_name'),
                array('users.image_path', 'user_image_path'),
                array('place_reviews.comment', 'review_comment'),
                self::$_table_name . '.*'
            )
            ->from(self::$_table_name)
            ->join('place_reviews')
            ->on(self::$_table_name . '.place_review_id', '=', 'place_reviews.id')
            ->join('users')
            ->on(self::$_table_name . '.user_id', '=', 'users.id')
            ->where('place_reviews.disable', '=', '0');
        // filter by keyword
        if (!empty($param['place_review_id'])) {
            $query->where(self::$_table_name . '.place_review_id', '=', $param['place_review_id']);
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
     * Disable a Place Review Like
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
                'place_review_id' => $param['place_review_id'],
                'user_id'         => $param['login_user_id'],
                'disable'         => '0'
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
     * Get all users liked Review
     *
     * @author thailh
     * @param array $param Input data
     * @return array List Place Review Comment
     */
    public static function get_all_by_place_review_id($param)
    {
        if (empty($param['login_user_id'])) {
            $param['login_user_id'] = 0;
        }
        $query = DB::select(
                self::$_table_name . '.id',
                self::$_table_name . '.place_review_id',
                self::$_table_name . '.created',               
                self::$_table_name . '.user_id',
                'users.name',
                'users.image_path'
            )
            ->from(self::$_table_name)
            ->join('users')
            ->on(self::$_table_name . '.user_id', '=', 'users.id')            
            ->where(self::$_table_name . '.disable', '=', '0')
            ->where(self::$_table_name . '.place_review_id', '=', $param['place_review_id'])
            ->order_by(self::$_table_name . '.created', 'DESC');        
        $data = $query->execute(self::$slave_db)->as_array();
        return $data;
    }
    
}