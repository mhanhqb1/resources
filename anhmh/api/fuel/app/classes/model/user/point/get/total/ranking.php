<?php

/**
 * Any query in Model User Point Get Total Ranking
 *
 * @package Model
 * @created 2015-03-23
 * @version 1.0
 * @author KienNH
 * @copyright Oceanize INC
 */
class Model_User_Point_Get_Total_Ranking extends Model_Abstract {
    
    /** @var array $_properties field of table */
    protected static $_properties = array(
        'id',
        'user_id',
        'point',
        'rank',
        'created',
        'updated'
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
    protected static $_table_name = 'user_point_get_total_rankings';
    
    /**
     * Get list coin ranking
     * 
     * @param array $param
     * @return array
     */
    public static function get_ranking($param) {
        // Get ranking of logged-in user
        if (empty($param['login_user_id'])) {
            $param['login_user_id'] = 0;
        }
        $user = self::get_current_user_ranking($param['login_user_id']);
        
        // Get list ranking
        $rankingCoins = array();
        $query = DB::select(
                    self::$_table_name . '.*',
                    array('users.name', 'user_name'),
                    array('users.image_path', 'user_avatar'),
                    array('users.email', 'user_email')
                )
                ->from(self::$_table_name)
                ->join('users')
                ->on(self::$_table_name . '.user_id', '=' , 'users.id')
                ->where('users.disable', '=', 0)
                ->order_by(self::$_table_name . '.rank', 'ASC')
                ->limit(20)->offset(0);
        
        $data = $query->execute(self::$slave_db)->as_array();
        if (!empty($data)) {
            foreach ($data as $ranking) {
                $rankingCoins[] = array(
                    'ranking'     => $ranking['rank'],
                    'coin'        => $ranking['point'],
                    'user_id'     => $ranking['user_id'],
                    'user_name'   => !empty($ranking['user_name']) ? $ranking['user_name'] : (!empty($ranking['user_email']) ? $ranking['user_email'] : ''),
                    'user_avatar' => $ranking['user_avatar'],
                );
            }
        }
        
        $result = array(
            'ranking' => $rankingCoins
        );
        if (!empty($user)) {
            $result['user'] = $user;
        }
        
        return $result;
    }
    
    /**
     * Get current user ranking
     * 
     * @param integer $user_id
     * @return array
     */
    public static function get_current_user_ranking($user_id) {
        $user = array();
        if (!empty($user_id)) {
            $user = Model_User::find($user_id);
            if (!empty($user)) {
                $userRanking = self::find('first', array(
                    'where' => array(
                        'user_id' => $user_id
                    )
                ));
                $user = array(
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'avatar' => $user['image_path'],
                    'number_ranking' => !empty($userRanking['rank']) ? $userRanking['rank'] : 0,
                    'coin' => !empty($user['point_get_total']) ? $user['point_get_total'] : 0
                );
            }
        }
        return $user;
    }
    
    /**
     * Rebuild ranking
     */
    public static function rebuild() {
        $data = Model_User_Point_Log::get_list_for_batch_ranking();
        $rank = 0;
        if (!empty($data)) {
            try {
                DB::start_transaction();
                
                // Delete old data
                DB::query("DELETE FROM user_point_get_total_rankings")->execute();
                
                // Insert new data
                $query = \DB::insert('user_point_get_total_rankings')
                        ->columns(array('user_id', 'point', 'rank'));
                
                foreach ($data as $ranking) {
                    $rank++;
                    $query->values(array($ranking['user_id'], $ranking['point_get_total'], $rank));
                }
                $query->execute();
                
                // Done
                DB::commit_transaction();
            } catch (Exception $ex) {
                $rank = 0;
                DB::rollback_transaction();
            }
        }
        return $rank;
    }
    
}
