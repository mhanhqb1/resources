<?php

use Fuel\Core\DB;
use Fuel\Core\Config;

/**
 * Any query in Model User Guest Id.
 *
 * @package Model
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Model_User_Guest_Id extends Model_Abstract
{
    protected static $_properties = array(
        'id',
        'type',
        'device',
        'device_id',
        'external_app_id',
        'external_app_name',
        'created',
        'updated',
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

    protected static $_table_name = 'user_guest_ids';

    /**
     * Add guest login.
     *
     * @author Le Tuan Tu
     * @param array $param Input data.
     * @return bool Returns the boolean.
     */
    public static function guest_login($param)
    {
        $type = 'guest';
        $device = \Lib\Util::deviceId($param['os']); 
        if ($device == 3 && !empty($param['device'])) { // for testing
            $device = $param['device'];
        }
        if ($device != 1 && $device != 2) {
            self::errorParamInvalid('device');
            return false;
        }        
        $options['where'] = array(
            'type' => $type,
            'device' => $device,
            'device_id' => $param['device_id']
        );
        $login = self::find('first', $options);
        if ($login) {   
            return $login->get('id');
        }       
        $login = new self;
        $login->set('type', $type);
        $login->set('device', $device);
        $login->set('device_id', $param['device_id']);
        if ($login->create()) {
            $login->id = self::cached_object($login)->_original['id'];
            return !empty($login->id) ? $login->id : 0;
        }
        return false;
    }
    
    /**
     * Create a user_id
     *
     * @author thailh
     * @param array $param Input data.
     * @return bool|int Returns the boolean or the integer.
     */
    public static function add($param)
    {
        $self = new self;
        if (isset($param['device_id'])) {
            $self->set('device_id', $param['device_id']);
        }
        $self->set('type', !empty($param['type']) ? $param['type'] : 'user');
        $self->set('device', !empty($param['os']) ? \Lib\Util::deviceId($param['os']) : 0);
        if (!$self->create()) {
            \LogLib::warning('Can not add user_guest_ids', __METHOD__, $param);
            return false;
        }
        return $self->id;
    }
    
   /**
     * Add info into user_guest_ids.
     *
     * @author truongnn
     * @param array $param Input data.
     * @return bool|int Returns the boolean or the integer.
     */
    public static function add_update($param)
    {
        $id = !empty($param['id']) ? $param['id'] : 0;
        $guestUser = new self;
        $guestUser = self::find($id);
        if (empty($guestUser)) {
            $guestUser = new self;
            $guestUser->set('id', $param['id']);
            $guestUser->set('type', $param['type']);
            $guestUser->set('device', $param['device']);
            $guestUser->set('device_id', $param['device_id']);
            if ($guestUser->create()) {
                return true;
            }
        } else {
            $guestUser->set('type', $param['type']);
            $guestUser->set('device', $param['device']);
            $guestUser->set('device_id', $param['device_id']);
            if ($guestUser->update()) {
                return true;
            }
        }
        return false;
    }
    /**
     * Function login tadacopy by guest.
     *
     * @author thailh
     * @param array $param Input data.
     * @return bool|int Returns the boolean or the integer.
     */
    public static function tadacopy_guest_login($param)
    {
        if (empty($param['tadacopy_app_id'])) {
            self::errorParamInvalid('tadacopy_app_id');
            return false;
        } 
        $type = 'guest';
        $param['tadacopy_app_name'] = \Config::get('tadacopy_name');
        $param['device'] = \Lib\Util::deviceId($param['os']); 
        if ($param['device'] == 3) {
            $param['device'] = 0;
        }  
        if (empty($param['device_id'])) {
            $param['device_id'] = '';
        }
        $options['where'] = array(
            'type' => $type,            
            'external_app_id' => $param['tadacopy_app_id'],
            'external_app_name' => $param['tadacopy_app_name'],
        );
        $login = self::find('first', $options);
        if ($login) {   
            return $login->get('id');
        }   
        $login = new self;
        $login->set('type', $type);        
        $login->set('device', $param['device']);
        $login->set('device_id', $param['device_id']);
        $login->set('external_app_id', $param['tadacopy_app_id']);
        $login->set('external_app_name', $param['tadacopy_app_name']);
        if ($login->create()) {
            $login->id = self::cached_object($login)->_original['id'];
            return !empty($login->id) ? $login->id : 0;
        }
        return false;
    }
}
