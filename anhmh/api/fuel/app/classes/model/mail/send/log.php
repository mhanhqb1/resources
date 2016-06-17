<?php

class Model_Mail_Send_Log extends Model_Abstract
{
	protected static $_properties = array(
		'id',	
		'user_id',
		'type',
		'title',
		'content',
		'created',
        'disable',
        'to_email',
        'status',
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

	protected static $_table_name = 'mail_send_logs';


    const TYPE_EMAIL_REGISTER = 1;    
    const TYPE_EMAIL_FORGET_PASSWORD = 2;
    const TYPE_EMAIL_ADMIN_CREATE_USER = 3;  
    const TYPE_EMAIL_REGISTER_ACTIVE = 4;
    const TYPE_EMAIL_QUIT_USER = 5;
    const TYPE_EMAIL_CONTACT = 6;
        
    /**
     * Get list of mail's logs
     *
     * @author Tran Xuan Khoa
     * @param array $param Input data.
     * @return array Mail's logs
     */
    public static function get_list($param)
    {
        $query = DB::select(
                self::$_table_name . '.*',               
                array('users.first_name', 'user_first_name'),
                array('users.last_name', 'user_last_name'),
                array('users.email', 'user_email'),
                array('users.phone', 'user_phone'),
                array('shops.name', 'shop_name'),
                array('nailists.name', 'nailist_name')
            )
            ->from(self::$_table_name)
            ->join('users', 'INNER')
            ->on('users.id', '=', self::$_table_name . '.user_id')

            ->join('shops', 'INNER')
            ->on('shops.id', '=', self::$_table_name . '.shop_id')

            ->join('nailists', 'INNER')
            ->on('nailists.id', '=', self::$_table_name . '.nailist_id');

        // filter by keyword
        if (!empty($param['user_id'])) {
            $query->where(self::$_table_name . '.user_id', "{$param['user_id']}");
        }
        if (!empty($param['title'])) {
            $query->where('title', 'LIKE', "%{$param['title']}%");
        }
        if (!empty($param['to_email'])) {
            $query->where(self::$_table_name . '.to_email', 'LIKE', "%{$param['to_email']}%");
        }
        if (isset($param['disable']) && $param['disable'] != '') {
            $query->where(self::$_table_name . '.disable', '=', $param['disable']);
        }
        if (isset($param['status']) && $param['status'] != '') {
            $query->where(self::$_table_name . '.status', '=', $param['status']);
        }

        if (!empty($param['sort'])) {
            // KienNH 2016/04/20 check valid sort
            if(!self::checkSort($param['sort'])) {
                self::errorParamInvalid('sort');
                return false;
            }
            
            $sortExplode = explode('-', $param['sort']);
            $query->order_by(self::$_table_name . '.' . $sortExplode[0],
               !empty($sortExplode[1]) ? $sortExplode[1] : 'DESC');
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
        return array($total, $data);
    }

    /**
     * Add an mail's log
     *
     * @author Tran Xuan Khoa
     * @param array $param Input data.
     * @return bool|int Mail Log Id or False
     */
    public static function add($param)
    {
        $mailLog = new self;
        unset($param['id']);      
        $properties = self::$_properties;
        foreach ($param as $field => $value) {            
            //if (isset($properties[$field])) {
                $mailLog->set($field, $value);
            //}
        }
        if ($mailLog->save()) {
            if (empty($mailLog->id)) {
                $mailLog->id = self::cached_object($mailLog)->_original['id'];
            }
            return !empty($mailLog->id) ? $mailLog->id : 0;
        }
        return false;
    }
    
     /**
     * Get list email is not send
     *
     * @author Cao Dinh Tuan
     * @param array array $param Input data.
     * @return 
     */
     public static function resendmail() {
        $options['where'] = array(
            'disable' => 0,
            'status' => 0,
            array('to_email', 'IS NOT', NULL),
            array('to_email', '<>', '')
        );
        $data = self::find('all', $options);
        $result = array();
        if (!empty($data)) {
            foreach ($data as $item) {
                if (empty($item->get('to_email'))) {
                    \LogLib::warning('Email is null or empty', __METHOD__, $item);
                    $result[$item->get('id')] = 'Email is null or empty.';
                } elseif (!\Lib\Email::resendEmail($item)) {
                    \LogLib::warning('Can not send resent email', __METHOD__, $item);
                    $result[$item->get('to_email')] = 'FAIL';
                } else {
                    $result[$item->get('to_email')] = 'OK';
                    $item->set('status', '1');
                    $item->update();
                }
            }
        }
        return $result;
    }
    
    /**
     * Send contact mail
     * 
     * @param array $param
     * @return boolean
     */
    public static function contact($param) {
        if ($param['language_type'] == 1 && empty($param['name_kana'])) {
            static::errorParamInvalid('name_kana');
            return false;
        }
        
        $error = '';
        $check = \Lib\Email::sendContactEmail($param, $error);
        if (!$check) {
            if (empty($error)) {
                $error = 'Can not send email';
            }
            static::errorOther(self::ERROR_CODE_OTHER_1, 'email', $error);
            return false;
        }
        
        return true;
    }

}
