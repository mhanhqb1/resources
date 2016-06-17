<?php

/**
 * Any query in Model Help
 *
 * @package Model
 * @created 2015-07-08
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Model_Help extends Model_Abstract
{
    /** @var array $_properties field of table */
    protected static $_properties = array(
        'id',
        'type_id',
        'language_type',
        'title',
        'content',
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
    protected static $_table_name = 'helps';

    /**
     * Add or update info for Help
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return int|bool Help id or false if error
     */
    public static function add_update($param)
    {
        $cacheTitle['language_type'] = !empty($param['language_type'])? $param['language_type'] : 'ALL' ;
        $cacheTitle['type_id'] = !empty($param['type_id'])? $param['type_id'] : 'ALL' ;

        $id = !empty($param['id']) ? $param['id'] : 0;
        $help = new self;
        // check exist
        if (!empty($id)) {
            $help = self::find($id);
            if (empty($help)) {
                self::errorNotExist('help_id');
                return false;
            }
            $param['type_id'] = $help['type_id'];
        } else {
            $param['type_id'] = self::max('type_id') + 1;
        }
        if ($param['language_type'] != $help['language_type']) {
            $help = new self;            
        }        
        $help->set('language_type', $param['language_type']);
        if (isset($param['type_id'])) {
            $help->set('type_id', $param['type_id']);
        }
        if (isset($param['title'])) {
            $help->set('title', $param['title']);
        }
        if (isset($param['content'])) {
            $help->set('content', $param['content']);
        }        
        // save to database
        if ($help->save()) {
            if (empty($help->id)) {
                $help->id = self::cached_object($help)->_original['id'];
            }
            Cache::delete('HelpsAllLang'.$cacheTitle['language_type'].'Type'.$cacheTitle['type_id']);
            return !empty($help->id) ? $help->id : 0;
        }
        return false;
    }

    /**
     * Get list Help (using array count)
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array List Help
     */
    public static function get_list($param)
    {
        $query = DB::select(
            self::$_table_name.'.*'
        )
            ->from(self::$_table_name);
        // filter by keyword
        if (!empty($param['id'])) {
            $query->where(self::$_table_name.'.id', '=', $param['id']);
        }
        if (!empty($param['type_id'])) {
            $query->where(self::$_table_name.'.type_id', '=', $param['type_id']);
        }
        if (!empty($param['language_type'])) {
            $query->where(self::$_table_name.'.language_type', '=', $param['language_type']);
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
            $query->order_by(self::$_table_name.'.created', 'DESC');
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
     * Get all Help (without array count)
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array List Help
     */
    public static function get_all($param)
    {
        /*$cacheTitle['language_type'] = !empty($param['language_type'])? $param['language_type'] : 'ALL' ;
        $cacheTitle['type_id'] = !empty($param['type_id'])? $param['type_id'] : 'ALL' ;
        try{
            $data = Cache::get('HelpsAllLang'.$cacheTitle['language_type'].'Type'.$cacheTitle['type_id']);
        }
        catch (\CacheNotFoundException $e)
        {
            $query = DB::select(
                self::$_table_name.'.*'
            )
                ->from(self::$_table_name)
                ->where(self::$_table_name.'.disable', '=', '0');
            // filter by keyword
            if (!empty($param['type_id'])) {
                $query->where(self::$_table_name.'.type_id', '=', $param['type_id']);
            }
            if (!empty($param['language_type'])) {
                $query->where(self::$_table_name.'.language_type', '=', $param['language_type']);
            }
            $query->order_by(self::$_table_name.'.id', 'ASC');
            // get data
            $data = $query->execute()->as_array();
            Cache::set('HelpsAllLang'.$cacheTitle['language_type'].'Type'.$cacheTitle['type_id'], $data, 3600 * 1);
        }*/
        
        $query = DB::select(
                        self::$_table_name . '.*'
                )
                ->from(self::$_table_name)
                ->where(self::$_table_name . '.disable', '=', '0');
        // filter by keyword
        if (!empty($param['type_id'])) {
            $query->where(self::$_table_name . '.type_id', '=', $param['type_id']);
        }
        if (!empty($param['language_type'])) {
            $query->where(self::$_table_name . '.language_type', '=', $param['language_type']);
        }
        $query->order_by(self::$_table_name . '.id', 'ASC');
        // get data
        $data = $query->execute(self::$slave_db)->as_array();

        return $data;
    }

    /**
     * Disable/Enable list Help
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return bool Success or otherwise
     */
    public static function disable($param)
    {
        $ids = explode(',', $param['id']);
        foreach ($ids as $id) {
            $help = self::find($id);
            if ($help) {
                $help->set('disable', $param['disable']);
                if (!$help->save()) {
                    return false;
                }
            } else {
                self::errorNotExist('help_id');
                return false;
            }
        }
        return true;
    }

    /**
     * Get detail Help
     *
     * @author Le Tuan Tu
     * @param array $param Input data
     * @return array|bool Detail Help or false if error
     */
    public static function get_detail($param)
    {
        if (!empty($param['language_type']) && !empty($param['type_id'])) {
            $options['where'] = array(
                array('type_id', '=', $param['type_id']),
                array('language_type', '=', $param['language_type'])
            ); 
            $data = self::find('first', $options); 
            if (empty($data)) {
                return array(
                    'id' => !empty($param['id']) ? $param['id'] : 0,
                    'type_id' => $param['type_id'],
                    'language_type' => $param['language_type'],
                );
            }
        } elseif (!empty($param['id'])) {
            $options['where'] = array(
                array('id', '=', $param['id']),
            );
            $data = self::find('first', $options);   
            if (empty($data) && !empty($param['id'])) {
                self::errorNotExist('id');
                return false;
            }
        }
        return $data;
    }

    /**
     * Get view Help
     *
     * @author Le Tuan Tu
     * @return array|bool View Help
     */
    public static function get_view()
    {
        $query = DB::select(
            self::$_table_name.'.*'
        )
            ->from(self::$_table_name)
            ->where(self::$_table_name.'.language_type', '=', '1')
            ->where(self::$_table_name.'.disable', '=', '0');
        $query->order_by(self::$_table_name.'.id', 'ASC');
        // get data
        $data['data'] = $query->execute(self::$slave_db)->as_array();
        return Response::forge(View::forge('helps/view', $data));
    }

    /**
     * Get view Help
     *
     * @author Le Tuan Tu
     * @param array $id Input data
     * @return array|bool View Help
     */
    public static function get_view_detail($id = 0)
    {
        $query = DB::select(
            self::$_table_name.'.*'
        )
            ->from(self::$_table_name)
            ->where(self::$_table_name.'.id', '=', $id)
            ->where(self::$_table_name.'.disable', '=', '0');
        // get data
        $data['data'] = $query->execute(self::$slave_db)->offsetGet(0);
        return Response::forge(View::forge('helps/detail', $data));
    }
}
