<?php

/**
 * Any query in Model Notice
 *
 * @package Model
 * @created 2015-07-08
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Model_Notice extends Model_Abstract
{
    /** @var array $_properties field of table */
    protected static $_properties = array(
        'id',
        'receive_user_id',
        'user_id',
        'place_id',
        'place_review_id',
        'place_review_comment_id',
        'type',
        'is_read',       
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
    protected static $_table_name = 'notices';

    /**
     * Get list Notice (using array count)
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array List Notice
     */
    public static function get_list($param)
    {
        $param['page'] = !empty($param['page']) ? $param['page'] : Config::get('page_default', 1);
        $param['limit'] = !empty($param['limit']) ? $param['limit'] : Config::get('limit_default', 10);
        $offset = ($param['page'] - 1) * $param['limit']; 
        
        $query = DB::select(
                self::$_table_name.'.*',                                             
                'users.name',  
                DB::expr("(SELECT count_follow FROM users WHERE disable = 0 AND id={$param['login_user_id']}) AS count_follow"),
                'place_reviews.count_like',
                'place_reviews.count_comment',
                'place_review_comments.comment'
            )
            ->from(self::$_table_name)          
            ->join('users')
            ->on(self::$_table_name.'.user_id', '=', 'users.id')
                        
            ->join('places', 'LEFT')
            ->on(self::$_table_name.'.place_id', '=', 'places.id')
                        
            ->join('place_reviews', 'LEFT')
            ->on(self::$_table_name.'.place_review_id', '=', 'place_reviews.id')
            ->and_on(self::$_table_name.'.place_id', '=', 'place_reviews.place_id')
                        
            ->join('place_review_likes', 'LEFT')
            ->on(self::$_table_name.'.user_id', '=', 'place_review_likes.user_id')
            ->and_on(self::$_table_name.'.place_review_id', '=', 'place_review_likes.place_review_id')
                                    
            ->join('place_review_comments', 'LEFT')
            ->on(self::$_table_name.'.user_id', '=', 'place_review_comments.user_id')
            ->and_on(self::$_table_name.'.place_review_id', '=', 'place_review_comments.place_review_id')            
            ->and_on(self::$_table_name.'.place_review_comment_id', '=', 'place_review_comments.id')
                   
            ->where(self::$_table_name.'.disable', '0')
            ->where(self::$_table_name.'.receive_user_id', $param['login_user_id'])   
            //->where('places.disable', '0')// KienNH, 2015/12/17
            ->where(DB::expr("(notices.place_id = 0 OR places.disable='0')"))            
            ->where(DB::expr("(notices.place_review_id = 0 OR place_reviews.disable='0')"))
            ->where(DB::expr("(notices.place_review_comment_id = 0 OR place_review_comments.disable='0')"))
            ->where(DB::expr("(place_review_likes.disable IS NULL OR place_review_likes.disable='0')"))
            ->where(DB::expr("(place_review_comments.disable IS NULL OR place_review_comments.disable='0')"));
        if (!empty($param['user_id'])) {
            $query->where('notices.user_id', $param['user_id']);
        }
        if (!empty($param['type'])) {
            $query->where('notices.type', $param['type']);           
        }
        if (!empty($param['place_id'])) {
            $query->where('notices.place_id', $param['place_id']);   
        }
        if (!empty($param['place_review_id'])) {
            $query->where('notices.place_review_id', $param['place_review_id']);
        }
        if (!empty($param['place_review_comment_id'])) {
            $query->where('notices.place_review_comment_id', $param['place_review_comment_id']);
        }
        if (!empty($param['place_review_like_id'])) {
            $query->where('place_review_likes.id', $param['place_review_like_id']);
        }
        $query->group_by('notices.receive_user_id', 'notices.user_id', 'notices.place_id', 'notices.place_review_id');// KienNH, 2015/12/17
        $query->order_by('notices.created', 'DESC')
            ->limit($param['limit'])->offset($offset);
        $data = $query->execute(self::$slave_db)->as_array();
        $total = !empty($data) ? DB::count_last_query(self::$slave_db) : 0;
        if (empty($param['without_merge_place'])) {
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
        }
        
        if ($data) {            
            // find place_review_id of login user
            $place_review_id = array();
            foreach ($data as $item) {
                if (!empty($item['place_review_id']) && !in_array($item['place_review_id'], $place_review_id)) {
                    $place_review_id[] = $item['place_review_id'];
                }
            }
            $place_review_id = !empty($place_review_id) ? implode(',', $place_review_id) : 0;
            $no_image_user = \Config::get('no_image_user');  
            $users = DB::select(
                array('users.id', 'user_id'),                                 
                array('users.name', 'name'),                                 
                DB::expr("IFNULL(IF(image_path='',NULL,image_path),'{$no_image_user}') AS image_path"),
                'place_review_id', 
                'type'
            )              
            ->from('users')            
            ->join(DB::expr("(
                        SELECT CONCAT('follow_user', id) AS id, user_id, 0 AS place_review_id, '1' AS 'type'
                        FROM follow_users
                        WHERE disable = 0 
                        AND follow_user_id = {$param['login_user_id']}

                        UNION

                        SELECT CONCAT('place_review_like', id) AS id, user_id, place_review_id, '2' AS 'type'
                        FROM place_review_likes
                        WHERE disable = 0
                        AND place_review_id IN ({$place_review_id})

                        UNION

                        SELECT CONCAT('place_review_comment', id) AS id, user_id, place_review_id, '3' AS 'type'
                        FROM place_review_comments
                        WHERE disable = 0
                        AND place_review_id IN ({$place_review_id})               
                    ) A")
                )          
            ->on('users.id', '=', 'A.user_id')
            ->where('users.disable', '0')
            ->execute(self::$slave_db)
            ->as_array();
            
            foreach ($data as &$item) {
                $item['users'] = array();
                foreach ($users as $user) {
                    if ($item['type'] == $user['type'] 
                        && $item['place_review_id'] == $user['place_review_id']                       
                    ) {
                        $item['users'][$user['user_id']] = $user;
                    }
                } 
                $item['users'] = array_values($item['users']);
                if ($item['type'] == 2) {
                    $item['count_like'] = count($item['users']);                
                }
                if ($item['type'] == 3) {
                    $item['count_comment'] = count($item['users']);
                }
                $custom_notice = '';
                $item['notice'] = self::get_notice_string(
                    array(
                        'type' => $item['type'],
                        'language_type' => $param['language_type'],
                        'user_id' => $item['user_id'],
                        'name' => $item['name'],
                        'users' => $item['users'],
                        'place_name' => !empty($item['place_name']) ? $item['place_name'] : '',
                        'count_follow' => !empty($item['count_follow']) ? $item['count_follow'] - 1 : 0,
                        'count_like' => !empty($item['count_like']) ? $item['count_like'] - 1 : 0,
                        'count_comment' => !empty($item['count_comment']) ? $item['count_comment'] - 1 : 0,
                    ),
                    $custom_notice
                );
                $item['notice_custom'] = $custom_notice;
            }
            unset($item);
        }       
        // KienNH, 2015/12/17: add without_admin_notices
        if ($param['page'] == 1 && empty($param['without_admin_notices'])) {
            $data = array_merge(Model_Admin_Notice::get_all(array(
                'language_type' => $param['language_type']
            )), $data);
        }
        return array(
            'total' => $total, 
            'data' => $data
        );        
    }

    /**
     * Get notice string
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array List Notice
     */
    public static function get_notice_string($param, &$custom_notice = '')
    {        
        $count = array(
            1 => $param['count_follow'],
            2 => $param['count_like'],
            3 => $param['count_comment'],
        );        
        $notice = array(
            'single' => Config::get('notice_string')[$param['type']][$param['language_type']]['single'],
            'two' => Config::get('notice_string')[$param['type']][$param['language_type']]['two'],
            'multi' => Config::get('notice_string')[$param['type']][$param['language_type']]['multi']
        );       
        if ($count[$param['type']] == 0) {
            $custom_notice = sprintf($notice['single'], '', $param['place_name']);
            return sprintf($notice['single'], $param['name'], $param['place_name']);
        } elseif ($count[$param['type']] == 1) {
            $name2 = '';
            if (count($param['users']) == 2) {
                foreach ($param['users'] as $user) {
                    if ($user['user_id'] != $param['user_id']) {
                        $name2 = $user['name'];
                        break;
                    }
                }
            }
            $custom_notice = sprintf($notice['two'], '', $name2, $param['place_name']);
            return sprintf($notice['two'], $param['name'], $name2, $param['place_name']);
        } else {
            $custom_notice = sprintf($notice['multi'], '', $count[$param['type']] . ' others', $param['place_name']);
            return sprintf($notice['multi'], $param['name'], $count[$param['type']] . ' others', $param['place_name']);
        }
        
        $custom_notice = '';
        return '';        
    }

    /**
     * Check read for Notice
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return bool Success or otherwise
     */
    public static function is_read($param)
    {
        if (empty($param['id'])) {
            return false;
        }
        $ids = explode(',', $param['id']);
        foreach ($ids as $id) {
            $notice = self::find($id);
            if (!empty($notice)) {
                $notice->set('is_read', $param['is_read']);
                if (!$notice->save()) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Get detail Notice
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array|bool Detail Notice or false if error
     */
    public static function get_detail($param)
    {
        $data = self::find($param['id']);
        if (empty($data)) {
            static::errorNotExist('notice_id');
            return false;
        }
        $type = $data->get('type');
        $receiveUserId = $data->get('receive_user_id');
        $placeReviewId = $data->get('place_review_id');
        $sql = '';
        switch ($type) {
            case 1:
                $sql = "
                    SELECT follow_users.*,
                           users.name
                    FROM follow_users
                    JOIN users ON follow_users.user_id = users.id
                    WHERE follow_user_id = {$receiveUserId}
                        AND follow_users.disable = 0
                        AND users.disable = 0
                    ORDER BY follow_users.created DESC
                ";
                break;
            case 2:
                $sql = "
                    SELECT places.name AS place_name,
                           place_review_id,
                           place_review_likes.user_id,
                           users.name
                    FROM place_review_likes
                    JOIN users ON place_review_likes.user_id = users.id
                    JOIN place_reviews ON place_review_likes.place_review_id = place_reviews.id
                    LEFT JOIN
                        ( SELECT places.id,
                                 place_informations.name
                         FROM place_informations
                         JOIN places ON place_informations.place_id = places.id
                         WHERE places.disable = 0
                             AND place_informations.disable = 0) places ON place_reviews.place_id = places.id
                    WHERE place_reviews.user_id = {$receiveUserId}
                        AND place_reviews.id = {$placeReviewId}
                        AND place_review_likes.disable = 0
                        AND users.disable = 0
                        AND place_reviews.disable = 0
                ";
                break;
            case 3:
                $sql = "
                    SELECT places.name AS place_name,
                           place_review_id,
                           place_review_comments.user_id,
                           place_review_comments.comment,
                           users.name
                    FROM place_review_comments
                    JOIN users ON place_review_comments.user_id = users.id
                    JOIN place_reviews ON place_review_comments.place_review_id = place_reviews.id
                    LEFT JOIN
                        (SELECT places.id,
                                place_informations.name
                         FROM place_informations
                         JOIN places ON place_informations.place_id = places.id
                         WHERE places.disable = 0
                             AND place_informations.disable = 0) places ON place_reviews.place_id = places.id
                    WHERE place_reviews.user_id = {$receiveUserId}
                        AND place_reviews.id = {$placeReviewId}
                        AND place_review_comments.disable = 0
                        AND users.disable = 0
                        AND place_reviews.disable = 0
                ";
                break;
        }
        $notice = DB::query($sql)->execute(self::$slave_db)->as_array();
        $data['notice'] = !empty($notice) ? $notice : array();
        return $data;
    }
    
    /**
     * Add message to Push message
     *
     * @author thailh
     * @param array $param Input data
     * @return bool true or false if error
     */
    public static function add_push_message($obj, $param)
    {
        try {
            if (empty($obj)) {
                return false;
            }

            if ($obj instanceof Model_Place_Review_Comment || $obj instanceof Model_Place_Review_Like) {
                if ($obj instanceof Model_Place_Review_Comment) {
                    $review = Model_Place_Review::find($obj->get('place_review_id'));
                    $param['type'] = \Config::get('notices.type.comment_review');
                    $param['setting_name'] = 'comment_review';
                    $_customKey = 'place_review_comment_id';
                } elseif ($obj instanceof Model_Place_Review_Like) {
                    $review = Model_Place_Review::find($obj->get('place_review_id'));
                    $param['type'] = \Config::get('notices.type.like_review');
                    $param['setting_name'] = 'like_review';
                    $_customKey = 'place_review_like_id';
                }

                if (empty($review)) {
                    return false;
                }

                $notice = self::get_list(array(
                    'login_user_id'           => $review->get('user_id'),
                    'user_id'                 => $obj->get('user_id'),
                    'place_review_id'         => $review->get('id'),
                    $_customKey               => $obj->get('id'),
                    'type'                    => $param['type'],
                    'language_type'           => $param['language_type'],
                    'limit'                   => 1,
                    'without_admin_notices'   => 1,
                ));
                if (empty($notice['data'][0]['notice'])) {
                    return true;// notice not exists, ignore send message
                } else {
                    $message = json_encode($notice['data'][0]);
                    $userId = $review->get('user_id');
                }
            } elseif ($obj instanceof Model_Follow_User) {
                $param['type'] = \Config::get('notices.type.follow_user'); 
                $param['setting_name'] = 'follow_user';

                $notice = self::get_list(array(
                    'login_user_id'           => $obj->get('follow_user_id'),
                    'user_id'                 => $param['login_user_id'],
                    'type'                    => $param['type'],
                    'language_type'           => $param['language_type'],
                    'limit'                   => 1,
                    'without_admin_notices'   => 1,
                    'without_merge_place'     => 1,
                ));
                if (empty($notice['data'][0]['notice'])) {
                    return true;// notice not exists, ignore send message
                } else {
                    $message = json_encode($notice['data'][0]);
                    $userId = $obj->get('follow_user_id');
                }
            }

            if (empty($message)) {
                return false;
            }

            $devices = Model_User_Notification::find(
                'first',
                array(
                    'where' => array(
                        'user_id' => $userId
                    )
                )
            );
            if (empty($devices)) {
                return true;// user not regist yet device_id, ignore send message
            }

            if (!Model_Push_Message::add_update(array(
                'receive_user_id' => $userId,
                'message' => $message,
                'is_sent' => 0,            
            ))) {
                \LogLib::error('Can not insert to push_message', __METHOD__, $param);
                return false; 
            }        
            return true;
        } catch (Exception $e) {
            \LogLib::error(sprintf("add_push_message Exception\n"
                                . " - Message : %s\n"
                                . " - Code : %s\n"
                                . " - File : %s\n"
                                . " - Line : %d\n"
                                . " - Stack trace : \n"
                                . "%s", 
                                $e->getMessage(), 
                                $e->getCode(), 
                                $e->getFile(), 
                                $e->getLine(), 
                                $e->getTraceAsString()), 
                __METHOD__, $param);
            return false;
        }
    }
    
}
