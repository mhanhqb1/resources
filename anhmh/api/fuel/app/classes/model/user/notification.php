<?php

class Model_User_Notification extends Model_Abstract
{
	protected static $_properties = array(		
		'id',
		'user_id',
		'google_regid',
		'apple_regid',
		'disable',
		'created',
		'updated',
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

	protected static $_table_name = 'user_notifications';
    
    /**
     * Get field for update by os & device.
     *
     * @author Le Tuan Tu
     * @param array $param Input data.
     * @return string|bool Returns the string or the boolean.   
     */
    private static function _get_update_field_by_os($param = array())
    {
        if ($param['os'] == Config::get('os')['ios']) 
        {
            return 'apple_regid';
        } 
        elseif ($param['os'] == Config::get('os')['android']) 
        {
            return 'google_regid';            
        }
        elseif ($param['os'] == Config::get('os')['webos'] && !empty($param['device']) && $param['device'] == 'ios') 
        {
            return 'apple_regid';            
        }
        elseif ($param['os'] == Config::get('os')['webos'] && !empty($param['device']) && $param['device'] == 'android') 
        {
            return 'google_regid';            
        }
        return false;
    }
    
    /**
     * Register user notification.
     *
     * @author thailh
     * @param array $param Input data.
     * @return bool Returns the boolean.
     */
    public static function register($param) {        
        if (!$regIdField = self::_get_update_field_by_os($param)) {
            self::errorParamInvalid('regid');
            return false;
        }
        $options['where'] = array(
            'user_id' => $param['user_id'],                
            $regIdField => $param['regid'],                
        );
        $self = self::find('first', $options);
        if (!empty($self) && $self->get('disable') == 0) {
            // regId have already registered
            return $self->get('id');
        }
        if (empty($self)) {
            $self = new self;
        }
        $self->set('disable', '0');
        $self->set('user_id', $param['user_id']);        
        $self->set($regIdField, $param['regid']);
        if ($self->save()) {
            if (empty($self->id)) {
                $self->id = self::cached_object($self)->_original['id'];
            }
            return !empty($self->id) ? $self->id : 0;
        }
        return false;
    }
    
    /**
     * Unregister user notification by regid.
     *
     * @author thailh
     * @param array $param Input data.
     * @return bool Returns the array.
     */
    public static function unregister($param) {
        $regIdField = self::_get_update_field_by_os($param);
        $options['where'] = array(          
            'disable' => '0',
            $regIdField => $param['regid'],
        );       
        $selfs = self::find('all', $options);
        if (empty($selfs)) {
            static::errorNotExist('regid');
            return false;
        } 
        foreach ($selfs as $self) {            
            $self->set('disable', '1');        
            if ($self->update()) {
                return true;
            }              
        }              
        return false;
    }

    /**
     * Push message to device
     *
     * @author thailh
     * @param array $param Input data
     * @return bool true or false if error
     */
    public static function push_message($obj, $param)
    {
        \Package::load('gcm');   
        \Package::load('apns'); 
        if (empty($obj)) {
            self::errorParamInvalid();
            return false;
        }
        if ($obj instanceof Model_Place_Review_Comment) {
            $review = Model_Place_Review::find($obj->get('place_review_id'));            
            $param['type'] = \Config::get('notices.type.comment_review');            
            $param['setting_name'] = 'comment_review';            
        } elseif ($obj instanceof Model_Place_Review_Like) {
            $review = Model_Place_Review::find($obj->get('place_review_id'));
            $param['type'] = \Config::get('notices.type.like_review'); 
            $param['setting_name'] = 'like_review';
        }
        if (empty($review)) {
            self::errorNotExist('place_review_id', $obj->get('place_review_id'));
            return false;
        }
        $notice = Model_Notice::get_list(array(
            'login_user_id' => $review->get('user_id'),
            'user_id' => $obj->get('user_id'),                
            'place_review_id' => $review->get('id'),
            'place_review_comment_id' => $obj->get('id'),
            'type' => $param['type'],
            'language_type' => $param['language_type'],
            'limit' => 1,
        ));
        if (empty($notice['data'][0]['notice'])) {
            // notice not exists, ignore send message
            return true;
        } else {
            $param['message'] = $notice['data'][0]['notice'];
        }        
        \LogLib::info('Push message', __METHOD__, $param);        
        $self = self::find(
            'first',
            array(
                'where' => array(
                    'user_id' => $review->get('user_id'),
                )
            )
        );
        if (empty($self)) {
            // user not regist yet device_id, ignore send message
            return true;
        }   
        if (!empty($self->get('google_regid'))) {
            if (!\Gcm::sendMessage(array(
                'google_regid' => $self->get('google_regid'),
                'message' => $param['message']
            ))) {
                \LogLib::error('Can not send message to Android device', __METHOD__, $param);
                return false;   
            }     
        }
        if (!empty($self->get('apple_regid'))) {
            if (!\Apns::sendMessage(array(
                'apple_regid' => $self->get('apple_regid'),
                'message' => $param['message'],                
            ))) {
                \LogLib::error('Can not send message to iOS device', __METHOD__, $param);
                return false;   
            }
        }
        return true;
    }
    
}
