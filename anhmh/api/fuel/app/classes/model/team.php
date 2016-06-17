<?php

/**
 * Any query in Model Team
 *
 * @package Model
 * @created 2015-07-01
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Model_Team extends Model_Abstract
{
    /** @var array $_properties field of table */
    protected static $_properties = array(
        'id',
        'user_id',
        'name',
        'language_type',
        'section_id',
        'point',
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
    protected static $_table_name = 'teams';

    /**
     * Add or update info for Team
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return int|bool Team id or false if error
     */
    public static function add_update($param)
    {
        $id = !empty($param['id']) ? $param['id'] : 0;
        $self = new self;
        if (!empty($id)) {
            $self = self::find($id);
            if (empty($self)) {
                self::errorNotExist('id');
                return false;
            }
            $searchName = self::find('first', array(
                'where' => array('name' => $param['name'])
            ));
            if (!empty($searchName)) {
                if ($searchName->get('id') != $id) {
                    self::errorDuplicate('name');
                    return false;
                }
            }
        } else {            
            $self = self::find('first', array(
                'where' => array('name' => $param['name'])
            ));
            if (!empty($self)) {
                self::errorDuplicate('name');
                return false;
            }
            $self = new self;
            if (!empty($param['login_user_id'])) { // from FE          
                $self->set('user_id', $param['login_user_id']);
                $self->set('language_type', $param['language_type']);
            } else { // from admin
                $self->set('user_id', '0');
                $self->set('language_type', 1);
            }
            $self->set('point', '0');
        }         
        if (isset($param['name'])) {
            $self->set('name', $param['name']);
        }        
        if (isset($param['section_id'])) {
            $self->set('section_id', $param['section_id']);
        }
        if ($self->save()) {
            if (empty($self->id)) {
                $self->id = self::cached_object($self)->_original['id'];
            }            
            return !empty($self->id) ? $self->id : 0;
        }
        return false;
    }

    /**
     * Get list Team (using array count)
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array List Team
     */
    public static function get_list($param)
    {
        $query = DB::select(
                self::$_table_name . '.id',
                self::$_table_name . '.name',
                self::$_table_name . '.point',
                self::$_table_name . '.section_id',
                self::$_table_name . '.user_id',
                self::$_table_name . '.disable',
                array('users.name', 'user_name'),
                DB::expr("IFNULL(IF(image_path='',NULL,image_path),'" . \Config::get('no_image_user') . "') AS image_path"),
                DB::expr("IFNULL(IF(cover_image_path='',NULL,cover_image_path),'" . \Config::get('no_image_cover') . "') AS cover_image_path"),
                DB::expr("FROM_UNIXTIME(teams.created, '%Y-%m-%d') AS created"),
                array('team_member.total', 'team_member')
            )
            ->from(self::$_table_name)
            ->join('users', 'LEFT')
            ->on(self::$_table_name . '.user_id', '=', 'users.id')
            ->join(DB::expr("(
                SELECT team_id, COUNT(*) AS total
                FROM users 
                GROUP BY team_id
            ) AS team_member"), 'LEFT')
            ->on('team_member.team_id', '=', self::$_table_name . '.id');
        if (!empty($param['login_user_id'])) {
            $param['disable'] = '0';
            $query->where(self::$_table_name . '.point', '>', '0');
        }
        if (!empty($param['id'])) {
            $query->where(self::$_table_name . '.id', '=', $param['id']);
        }      
        if (!empty($param['name'])) {
            $query->where(self::$_table_name . '.name', 'LIKE', "%{$param['name']}%");
        }
        if (!empty($param['section_id'])) {
            $query->where(self::$_table_name . '.section_id', '=', $param['section_id']);
        }        
        if (isset($param['disable']) && $param['disable'] != '') {
            $query->where(self::$_table_name . '.disable', '=', $param['disable']);
        }
        // KienNH 2016/03/07 begin add search by created
        if (!empty($param['created_from']) && strtotime($param['created_from']) > 0 && strtotime($param['created_from']) != '') {
            $query->where(DB::expr("FROM_UNIXTIME(teams.created, '%Y-%m-%d') >= '" . date('Y-m-d', strtotime($param['created_from'])) . "'"));
        }
        if (!empty($param['created_to']) && strtotime($param['created_to']) > 0 && strtotime($param['created_to']) != '') {
            $query->where(DB::expr("FROM_UNIXTIME(teams.created, '%Y-%m-%d') <= '" . date('Y-m-d', strtotime($param['created_to'])) . "'"));
        }
        // KienNH end
        if (!empty($param['sort'])) {
            // KienNH 2016/04/20 check valid sort
            if (!self::checkSort($param['sort'], self::$_properties, 'member')) {
                self::errorParamInvalid('sort');
                return false;
            }
            
            $sortExplode = explode('-', $param['sort']);
            if ($sortExplode[0] == 'member') {
                $sortExplode[0] = 'team_member.total';
            } else {
                $sortExplode[0] = self::$_table_name . '.' . $sortExplode[0];
            }
            $query->order_by($sortExplode[0], $sortExplode[1]);
        } else {
            $query->order_by(self::$_table_name . '.point', 'DESC');            
        }
        $query->order_by(self::$_table_name . '.created', 'DESC');
        if (!empty($param['page']) && !empty($param['limit'])) {
            $offset = ($param['page'] - 1) * $param['limit'];
            $query->limit($param['limit'])->offset($offset);
        }
        $data = $query->execute(self::$slave_db)->as_array();        
        $total = !empty($data) ? DB::count_last_query(self::$slave_db) : 0;
        
        $teamId = Lib\Arr::field($data, 'id');  
        if (!empty($teamId)) {
            $points = DB::select( 
                    'user_points.team_id',
                    'user_id',
                    'users.name',
                    DB::expr("IFNULL(IF(image_path='',NULL,image_path),'" . \Config::get('no_image_user') . "') AS image_path"),
                    DB::expr("IFNULL(IF(cover_image_path='',NULL,cover_image_path),'" . \Config::get('no_image_cover') . "') AS cover_image_path"),
                    DB::expr("MAX(point) AS point")
                )
                ->from(DB::expr("(
                    SELECT team_id, user_id, SUM(point) AS point
                    FROM user_points
                    WHERE disable = 0
                    AND team_id IN (" . implode(',', $teamId) . ")  
                    GROUP BY team_id, user_id
                ) AS user_points"))        
                ->join('users', 'LEFT')
                ->on('user_points.user_id', '=', 'users.id')
                ->group_by('team_id')
                ->group_by('user_id')
                ->order_by('point', 'DESC')
                ->execute(self::$slave_db)
                ->as_array();
            
            $rank = 1;
            foreach ($data as &$row) {
                $row['rank'] = $rank++;
                foreach ($points as $point) {
                    if ($point['team_id'] == $row['id']) {
                        $row['user_id'] = $point['user_id'];
                        $row['user_name'] = $point['name'];
                        $row['image_path'] = $point['image_path'];
                        $row['cover_image_path'] = $point['cover_image_path'];
                        break;
                    }
                }
            }
        }
        return array('total' => $total, 'data' => $data);
    }

    /**
     * Get all Team (without array count)
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array List Team
     */
    public static function get_all($param)
    {
        $query = DB::select(
                self::$_table_name . '.id',
                self::$_table_name . '.name',
                self::$_table_name . '.point',
                self::$_table_name . '.section_id',
                self::$_table_name . '.user_id',
                array('users.name', 'user_name'),
                DB::expr("IFNULL(IF(image_path='',NULL,image_path),'" . \Config::get('no_image_user') . "') AS image_path"),
                DB::expr("IFNULL(IF(cover_image_path='',NULL,cover_image_path),'" . \Config::get('no_image_cover') . "') AS cover_image_path")
            )
            ->from(self::$_table_name)  
            ->join('users', 'LEFT')
            ->on(self::$_table_name . '.user_id', '=', 'users.id')
            ->where(self::$_table_name . '.disable', '=', '0');
        // filter by keyword       
        if (!empty($param['name'])) {
            $query->where(self::$_table_name . '.name', 'LIKE', "%{$param['name']}%");
        }
        if (!empty($param['section_id'])) {
            $query->where(self::$_table_name . '.section_id', '=', $param['section_id']);
        }
        $query->order_by(self::$_table_name . '.id', 'ASC');
        // get data
        $data = $query->execute(self::$slave_db)->as_array();
        $teamId = Lib\Arr::field($data, 'id');  
        if (!empty($teamId)) {
            $points = DB::select( 
                    'user_points.team_id',
                    'user_id',
                    'users.name',
                    DB::expr("IFNULL(IF(image_path='',NULL,image_path),'" . \Config::get('no_image_user') . "') AS image_path"),
                    DB::expr("IFNULL(IF(cover_image_path='',NULL,cover_image_path),'" . \Config::get('no_image_cover') . "') AS cover_image_path"),
                    DB::expr("MAX(point) AS point")
                )
                ->from(DB::expr("(
                    SELECT team_id, user_id, SUM(point) AS point
                    FROM user_points
                    WHERE disable = 0
                    AND team_id IN (" . implode(',', $teamId) . ")  
                    GROUP BY team_id, user_id
                ) AS user_points"))        
                ->join('users', 'LEFT')
                ->on('user_points.user_id', '=', 'users.id')
                ->group_by('team_id')
                ->group_by('user_id')
                ->order_by('point', 'DESC')
                ->execute(self::$slave_db)
                ->as_array();

            foreach ($data as &$row) {
                foreach ($points as $point) {
                    if ($point['team_id'] == $row['id']) {
                        $row['user_id'] = $point['user_id'];
                        $row['user_name'] = $point['name'];
                        $row['image_path'] = $point['image_path'];
                        $row['cover_image_path'] = $point['cover_image_path'];
                        break;
                    }
                }
            }
        }
        return $data;
    }

    /**
     * Disable/Enable list Team
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return bool Success or otherwise
     */
    public static function disable($param)
    {
        // KienNH 20016/03/04 check disable team
        $ids = explode(',', $param['id']);
        $idsNotFound = array();
        $idsNG = array();
        $namesNG = array();
        
        foreach ($ids as $id) {
            $team = self::find($id);
            if ($team) {
                $continue = true;
                if ($param['disable'] == 1) {
                    $options['where'] = array(
                        'team_id' => $id,
                        'disable' => 0
                    );
                    $users = Model_User::find('all', $options);
                    if (!empty($users)) {
                        $continue = false;
                    }
                }
                
                if ($continue) {
                    $team->set('disable', $param['disable']);
                    if (!$team->save()) {
                        $idsNG[] = $id;
                        $namesNG[] = $team['name'];
                    }
                } else {
                    $idsNG[] = $id;
                    $namesNG[] = $team['name'];
                }
            } else {
                $idsNotFound[] = $id;
            }
        }
        
        if (!empty($idsNG) || !empty($namesNG) || !empty($idsNotFound)) {
            self::errorOther('ERROR_SUMMARY', 'id', (array(
                'idsNG' => $idsNG,
                'namesNG' => $namesNG,
                'idsNotFound' => $idsNotFound
            )));
            return false;
        }
        
        return true;
    }
    
    /**
     * Delete Team member
     */
    public static function deletemember($param) {
        if (empty($param['team_id']) || empty($param['user_ids'])) {
            self::errorNotExist('id');
            return false;
        }
        
        $user_ids = explode(',', $param['user_ids']);
        foreach ($user_ids as $user_id) {
            $options['where'] = array(
                'team_id' => $param['team_id'],
                'id' => $user_id
            );
            $users = Model_User::find('first', $options);
            if (!empty($users)) {
                $users->set('team_id', NULL);
                $users->save();
            }
        }
        
        return true;
    }

    /**
     * Get detail Team
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array|bool Detail Team or false if error
     */
    public static function get_detail($param)
    {
        $data = self::find($param['id']);
        if (empty($data)) {
            static::errorNotExist('id');
            return false;
        }
        
        // Get list Users
        if (!empty($param['get_list_user'])) {
            $paramUser = array(
                'team_id' => $param['id']
            );
            if (isset($param['page'])) {
                $paramUser['page'] = $param['page'];
            }
            if (isset($param['limit'])) {
                $paramUser['limit'] = $param['limit'];
            }
            
            $users = Model_User::get_list($paramUser);
            if (!empty($users)) {
                $data['users'] = array(
                    'total' => $users[0],
                    'data' => $users[1]
                );
            } else {
                $data['users'] = null;
            }
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
        if (!isset($param['data'])) {
            static::errorParamInvalid('data');
            return false;
        }
        $param = json_decode($param['data'], true);
        \LogLib::warning('Params: ', __METHOD__, $param);
        if (empty($param['type_id'])
            || empty($param['name'])
            || empty($param['name_en'])
            || empty($param['name_th'])
        ) {
            static::errorParamInvalid('type_id/name/name_en/name_th');
            return false;
        }
        $dataUpdate = array();
        $languageType = array(
            1 => $param['name'],
            2 => $param['name_en'],
            3 => $param['name_th'],
        );
        foreach ($languageType as $language => $name) {
            foreach ($param['type_id'] as $type_id) {
                if ($type_id == 0) {
                    $new_type_id = self::max('type_id') + 1;
                }
                $dataUpdate[] = array(
                    'type_id' => isset($new_type_id) ? $new_type_id : $type_id,
                    'language_type' => $language,
                    'section_id' => !empty($param['section_id'][$type_id]) ? $param['section_id'][$type_id] : 0,
                    'name' => !empty($name[$type_id]) ? $name[$type_id] : '',                    
                );              
            }
        }
        // execute insert/update
        if (!empty($dataUpdate) && !parent::batchInsert(
                self::$_table_name,
                $dataUpdate,
                array(
                    'section_id' => DB::expr('VALUES(section_id)'),
                    'name' => DB::expr('VALUES(name)'),
                    'disable' => DB::expr('VALUES(disable)')
                ),
                false
            )
        ) {
            \LogLib::warning('Can not update '.self::$_table_name, __METHOD__, $param);
            return false;
        }        
        return true;
    }
    
    
    
}
