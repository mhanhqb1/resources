<?php

class Model_Violation_Report extends Model_Abstract {

    protected static $_properties = array(
        'id',
        'user_id',
        'place_id',
        'review_id',
        'comment_id',
        'report_id',
        'report_comment',
        'created',
        'updated',
        'disable',
    );
    
    protected static $_observers = array(
        'Orm\Observer_CreatedAt' => array(
            'events' => array('before_insert'),
            'mysql_timestamp' => false,
        ),
        'Orm\Observer_UpdatedAt' => array(
            'events' => array('before_update'),
            'mysql_timestamp' => false,
        ),
    );
    
    protected static $_table_name = 'violation_reports';

    /**
     * Get all user reporting place/comment
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array List Place Review Comment
     */
    public static function get_all($param)
    {
        $query = DB::select(
                self::$_table_name . '.user_id',
                DB::expr("IFNULL(IF(users.image_path='',NULL,users.image_path), '" . \Config::get('no_image_user') . "') AS image_path"),
                DB::expr("IFNULL(IF(users.cover_image_path='',NULL,users.cover_image_path), '" . \Config::get('no_image_cover') . "') AS cover_image_path"),
                'users.name',
                self::$_table_name . '.place_id',
                self::$_table_name . '.review_id',
                self::$_table_name . '.comment_id',
                self::$_table_name . '.report_id',
                self::$_table_name . '.report_comment',
                self::$_table_name . '.created'
            )
            ->from(self::$_table_name)
            ->join('users')            
            ->on(self::$_table_name . '.user_id', '=', 'users.id')
            ->where(self::$_table_name . '.disable', '=', '0');       
        if (!empty($param['place_id'])) {
            $query->where(self::$_table_name . '.place_id', '=', $param['place_id']);
        }
        if (!empty($param['review_id'])) {
            $query->where(self::$_table_name . '.review_id', '=', $param['review_id']);
        }        
        if (!empty($param['comment_id'])) {
            $query->where(self::$_table_name . '.comment_id', '=', $param['comment_id']);
        }        
        $query->order_by(self::$_table_name . '.created', 'DESC');
        $data = $query->execute(self::$slave_db)->as_array();       
        return $data;
    }
    
    /**
     * Add info for Question Favorite
     *
     * @author Le Tuan Tu
     * @param array $param Input data.
     * @return int|bool Question Favorite id or false if error
     *
     */
    public static function add($param) {        
        if (!empty($param['comment_id'])) {
            $comment = Model_Place_Review_Comment::find($param['comment_id']);
            if (empty($comment)) {
                static::errorNotExist('comment_id', $param['comment_id']);
                return false;
            }
            $param['review_id'] = $comment->get('place_review_id');     
            $param['report_id'] = 0;
        }
        if (!empty($param['review_id'])) {
            $review = Model_Place_Review::find($param['review_id']);
            if (empty($review)) {
                static::errorNotExist('review_id', $param['review_id']);
                return false;
            }
            $param['place_id'] = $review->get('place_id');            
        }
        if (!empty($param['place_id'])) {
            $place = Model_Place::find($param['place_id']);
            if (empty($place)) {
                static::errorNotExist('place_id', $param['place_id']);
                return false;
            }
        }        
        if (empty($param['review_id'])) {
            $param['review_id'] = 0;
        }
        if (empty($param['comment_id'])) {
            $param['comment_id'] = 0;
        }
        if (empty($param['report_id'])) {
            $param['report_id'] = 0;
        }
        if (empty($param['report_comment'])) {
            $param['report_comment'] = '';
        }
        if (!empty($param['report_id']) && empty($param['report_comment'])) {
            foreach (\Config::get('violation_reports')['jp'] as $report) {
                if ($report['id'] == $param['report_id']) {
                    $param['report_comment'] = $report['message'];
                    break;
                }
            }            
        }
        $self = self::find('first', array(
            'where' => array(
                'user_id' => $param['user_id'],
                'place_id' => $param['place_id'],
                'review_id' => $param['review_id'],
                'comment_id' => $param['comment_id'],                
                'report_id' => $param['report_id'],
                'report_comment' => $param['report_comment']
            ),
            'from_cache' => false
        ));        
        if (!empty($self)) {
            $self->set('report_id', $param['report_id']);
            $self->set('report_comment', $param['report_comment']);
            $self->set('disable', '0');
        } else {
            $self = new self;
            $self->set('user_id', $param['user_id']);
            $self->set('place_id', $param['place_id']);        
            $self->set('review_id', $param['review_id']);
            $self->set('comment_id', $param['comment_id']);
            $self->set('report_id', $param['report_id']);
            $self->set('report_comment', $param['report_comment']);
        }
        if ($self->save()) {
            if (!empty($comment)) {
                $count = self::count(array(
                    'where' => array(                       
                        'comment_id' => $param['comment_id'],                
                        'disable' => '0'              
                    ),
                    'from_cache' => false
                ));
                $comment->set('count_user_report', $count);
                $comment->save();
            } elseif (!empty($review)) {
                $count = self::count(array(
                    'where' => array(                                             
                        'place_id' => $param['place_id'],                
                        'review_id' => $param['review_id'],               
                        'comment_id' => '0',         
                        'disable' => '0'
                    ),
                    'from_cache' => false
                ));
                $review->set('count_user_report', $count);
                $review->save();
            } elseif (!empty($place)) {
                $count = self::count(array(
                    'where' => array(                                             
                        'place_id' => $param['place_id'],                
                        'review_id' => '0',               
                        'comment_id' => '0',         
                        'disable' => '0'
                    ),
                    'from_cache' => false
                ));
                $place->set('count_user_report', $count);
                $place->save();
            }            
            return $self->id;
        }
        return false;
    }

}
