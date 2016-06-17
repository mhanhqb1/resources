<?php

/**
 * Any query for model Push Messages.
 *
 * @package Model
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Model_Push_Message extends Model_Abstract {

    protected static $_properties = array(
        'id',
        'receive_user_id',
        'message',
        'is_sent',
        'sent_date',
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
    protected static $_table_name = 'push_messages';

    protected static $_has_many = array('user_notifications' => array(
        'model_to' => 'Model_User_Notification',
        'key_from' => 'receive_user_id',
        'key_to' => 'user_id',
    ));
    
    /**
     * Enable/disable a or any push messages.
     *
     * @author Le Tuan Tu
     * @param array $param Input data.
     * @return bool Returns the boolean.
     */
    public static function disable($param) {
        if (empty($param['id'])) {
            return false;
        }
        $ids = explode(',', $param['id']);
        foreach ($ids as $id) {
            $self = self::find($id);
            if ($self) {
                $self->set('disable', $param['disable']);
                if (!$self->update()) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Add or update info for push messages.
     *
     * @author thailh
     * @param array $param Input data.
     * @throws Exception If the provided is not of type array.
     * @return bool|int Returns the boolean or the integer.
     */
    public static function add_update($param) {

        //check id if existing
        $id = !empty($param['id']) ? $param['id'] : 0;
        $self = new self;
        if (!empty($id)) {
            $self = self::find($id);
            if (empty($self)) {
                static::errorNotExist('id', $id);
                return false;
            }
        }
        if (isset($param['receive_user_id'])) {
            $self->set('receive_user_id', $param['receive_user_id']);
        }
        if (isset($param['message'])) {
            $self->set('message', $param['message']);
        }
        if (isset($param['android_icon'])) {
            $self->set('android_icon', $param['android_icon']);
        }
        if (isset($param['is_sent'])) {
            $self->set('is_sent', $param['is_sent']);
        }
        if (isset($param['sent_date'])) {
            $self->set('sent_date', $param['sent_date']);
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
     * Get list push messages for Task PushMessage to device.
     *
     * @author thailh
     * @param array $param Input data.
     * @return array Returns the array.
     */
    public static function get_for_task() {        
        $data = self::find('all', array(
            'select' => array(
                'receive_user_id',
                'is_sent',
                'message',               
            ),
            'related' => array(
                'user_notifications' => array(
                    'select' => array(                       
                        'google_regid',
                        'apple_regid',
                    ),
                    'where' => array(
                        array('disable', '0'),                            
                    ),
                )
            ),
            'where' => array(
                array('disable', '0'),
                array('is_sent', '0'),
            ),
            'order_by' => array('created' => 'asc'),           
        ));
        return $data;
    }

}
