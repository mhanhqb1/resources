<?php

/**
 * Any query in Model Place Review Comment
 *
 * @package Model
 * @created 2015-07-03
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Model_Place_Review_Comment extends Model_Abstract
{
    /** @var array $_properties field of table */
    protected static $_properties = array(
        'id',
        'user_id',
        'place_review_id',
        'comment',
        'count_user_report',
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
    protected static $_table_name = 'place_review_comments';

    /**
     * Add or update info for Place Review Comment
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return int|bool Place Review Comment id or false if error
     */
    public static function add_update($param)
    {
        $id = !empty($param['id']) ? $param['id'] : 0;
        $comment = new self;
        $new = true;
        if (!empty($id)) {
            $comment = self::find($id);
            if (empty($comment)) {
                self::errorNotExist('place_review_comment_id');
                return false;
            }
            $new = false;
        }
        // set value
        if (!empty($param['login_user_id'])) {
            $comment->set('user_id', $param['login_user_id']);
        }
        if (!empty($param['place_review_id'])) {
            $comment->set('place_review_id', $param['place_review_id']);
        }
        if (isset($param['comment'])) {
            $comment->set('comment', $param['comment']);
        }
        // save to database
        if ($comment->save()) {
            if (empty($comment->id)) {
                $comment->id = self::cached_object($comment)->_original['id'];
            }
            if ($new) {
                if (!empty($param['place_review_id'])) {
                    $_options['where'] = array(
                        'id' => $param['place_review_id']
                    );
                    $_place = Model_Place_Review::find('first', $_options);
                    if (!empty($_place)) {
                        $_placeId = $_place->get('place_id');
                        Model_User_Point::add(array(
                            'user_id' => $param['login_user_id'],
                            'type' => 3, // see config user_points_type
                            'place_id' => $_placeId,
                            'review_id' => $param['place_review_id'],
                            'comment_id' => $comment->id
                        ));
                        if (self::error()) {
                            return false;
                        }
                    }
                }
            }
            // new comment, send message to device
            if (empty($param['id'])) {
                Model_Notice::add_push_message($comment, $param);
            }
            $param['place_id'] = $_place['place_id'];
            Model_Place::DeleteCacheDetail($param,__METHOD__);        
            return !empty($comment->id) ? $comment->id : 0;
        }
        return false;
    }

    /**
     * Get list Place Review Comment (using array count)
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array List Place Review Comment
     */
    public static function get_list($param)
    {
        $query = DB::select(
                array('users.name', 'user_name'),
                array('users.image_path', 'user_image_path'),
                array('place_reviews.place_id', 'place_id'),
                self::$_table_name . '.*'
            )
            ->from(self::$_table_name)
            ->join('users')
            ->on(self::$_table_name . '.user_id', '=', 'users.id')
            ->join('place_reviews')
            ->on(self::$_table_name . '.place_review_id', '=', 'place_reviews.id');
        // filter by keyword
        if (!empty($param['user_id'])) {
            $query->where(self::$_table_name . '.user_id', '=', $param['user_id']);
        }
        if (!empty($param['place_review_id'])) {
            $query->where(self::$_table_name . '.place_review_id', '=', $param['place_review_id']);
        }
        if (!empty($param['comment'])) {
            $query->where(self::$_table_name . '.comment', 'LIKE', "%{$param['comment']}%");
        }
        if (isset($param['disable']) && $param['disable'] !== '') {
            $_disable = !empty($param['disable']) ? 1 : 0;
            $query->where(self::$_table_name . '.disable', '=', $_disable);
        }
        if (isset($param['report']) && $param['report'] !== '') {
            $query->where(self::$_table_name.'.count_user_report', '>', 0);
            if ($param['report'] == 0) {      
                $query->where(self::$_table_name . '.disable', '=', 1);
            } else {
                $query->where(self::$_table_name . '.disable', '=', 0);
            }
        }
        // KienNH 2016/05/13 begin
        if (!empty($param['user_name'])) {
            $query->where('users.name', 'LIKE', "%{$param['user_name']}%");
        }
        // KienNH end
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
     * Get all Place Review Comment (without array count)
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array List Place Review Comment
     */
    public static function get_all($param)
    {
        $query = DB::select(
                self::$_table_name . '.*'
            )
            ->from(self::$_table_name)
            ->join('users')
            ->on(self::$_table_name . '.user_id', '=', 'users.id')
            ->join('place_reviews')
            ->on(self::$_table_name . '.place_review_id', '=', 'place_reviews.id')
            ->where(self::$_table_name . '.disable', '=', '0');
        // filter by keyword
        if (!empty($param['user_id'])) {
            $query->where(self::$_table_name . '.user_id', '=', $param['user_id']);
        }
        if (!empty($param['place_review_id'])) {
            $query->where(self::$_table_name . '.place_review_id', '=', $param['place_review_id']);
        }
        if (!empty($param['comment'])) {
            $query->where(self::$_table_name . '.comment', 'LIKE', "%{$param['comment']}%");
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
            $query->order_by(self::$_table_name . '.id', 'ASC');
        }
        // get data
        $data = $query->execute(self::$slave_db)->as_array();
        return $data;
    }

    /**
     * Disable/Enable list Place Review Comment
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return bool Success or otherwise
     */
    public static function disable($param)
    {
        $ids = explode(',', $param['id']);
        foreach ($ids as $id) {
            $comment = self::find($id);
            if ($comment) {
                $comment->set('disable', $param['disable']);
                if (!$comment->save()) {
                    return false;
                }
            } else {
                self::errorNotExist('place_review_comment_id');
                return false;
            }
        }
        return true;
    }    
    
    /**
     * Get detail Place Review Comment
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array|bool Detail Place Review Comment or false if error
     */
    public static function get_detail($param)
    {
        $data = self::find($param['id']);
        if (empty($data)) {
            static::errorNotExist('place_review_comment_id');
            return false;
        }
        return $data;
    }

    /**
     * Get all Place Review Comment by Place Review Id (using array count)
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array List Place Review Comment
     */
    public static function get_all_comment_by_place_review_id($param)
    {
        if (empty($param['login_user_id'])) {
            $param['login_user_id'] = 0;
        }
        $query = DB::select(
                self::$_table_name . '.id',
                self::$_table_name . '.place_review_id',
                self::$_table_name . '.comment',
                self::$_table_name . '.created',
                DB::expr("IF(ISNULL(place_review_comment_likes.id),0,1) AS is_like"),
                self::$_table_name . '.user_id',
                'users.name',
                'users.image_path'
            )
            ->from(self::$_table_name)
            ->join('users')
            ->on(self::$_table_name . '.user_id', '=', 'users.id')
            ->join(DB::expr("(
                SELECT * 
                FROM place_review_comment_likes 
                WHERE disable = 0 
                AND user_id = {$param['login_user_id']}
            ) AS place_review_comment_likes"), 'LEFT')
            ->on(self::$_table_name . '.id', '=', 'place_review_comment_likes.place_review_comment_id')
            ->where(self::$_table_name . '.disable', '=', '0');
        // filter by keyword
        if (!empty($param['place_review_id'])) {
            $query->where(self::$_table_name . '.place_review_id', '=', $param['place_review_id']);
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
        return $data;
    }
    
    /**
     * Update info for comment
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return int|bool Place Review id or false if error
     */
    public static function update_comment($param)
    {   
        $id = !empty($param['id']) ? $param['id'] : 0;
        // check exist
        if (!empty($id)) {
            $self = self::find($id);
            if (empty($self)) {
                self::errorNotExist('comment_id');
                return false;
            }
        }        
        $self->set('comment', $param['comment']);
        // save to database
        if ($self->save()) {            
            return !empty($self->id) ? $self->id : 0;
        }
        return false;
    }
}
