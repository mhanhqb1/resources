<?php

namespace Fuel\Tasks;

use Fuel\Core\Cli;
use Fuel\Core\Config;

/**
 * Push message to device
 *
 * @package             Tasks
 * @create              2015-07-27
 * @version             1.0
 * @author              thailh
 * @run                 php oil refine pushmessage
 * @run                 FUEL_ENV=test php oil refine pushmessage
 * @run                 FUEL_ENV=production php oil refine pushmessage
 * @copyright           Oceanize INC
 */
class PushMessage {
    
    private static $lock_filename = 'tasks_pushmessage.tmp';// KienNH 2016/06/07

    public static function run() {
        // KienNH 2016/06/07: Check lock
        $check_lock = \Lib\Util::checkTaskLock(self::$lock_filename);
        if ($check_lock) {
            \LogLib::info('BREAK [Push message] ' . date('Y-m-d H:i:s'), __METHOD__, array());
            Cli::write("BREAK [Push message] " . date('Y-m-d H:i:s'));
            return false;
        }
        
        ini_set('memory_limit', -1);// KienNH 2016/06/07
        
        try {
            \Package::load('gcm');
            \LogLib::info('BEGIN [Push message] ' . date('Y-m-d H:i:s'), __METHOD__, array());
            Cli::write("BEGIN [Push message] ".date('Y-m-d H:i:s')." PROCESSING \n\n . . . . ! \n");
            
            $messages = \Model_Push_Message::get_for_task();
            if (empty($messages)) {
                Cli::write('There are no message to sent');
                \Lib\Util::deleteTaskLock(self::$lock_filename);// KienNH 2016/06/07
                return false;
            }
            
            foreach ($messages as $message) {
                foreach ($message->user_notifications as $user_notification) {
                    $apple_regid = $user_notification->get('apple_regid');
                    $google_regid = $user_notification->get('google_regid');
                    $is_sent = 0;
                    
                    // Data for send
                    $_message_raw = json_decode($message->get('message'), false);
                    $_messageIos = $_message_raw->notice;
                    $_message = json_encode(array(
                        'id'              => intval($_message_raw->id),
                        'user_id'         => intval($_message_raw->user_id),
                        'receive_user_id' => intval($_message_raw->receive_user_id),
                        'place_id'        => intval(!empty($_message_raw->place_id) ? $_message_raw->place_id : 0),
                        'place_review_id' => intval(!empty($_message_raw->place_review_id) ? $_message_raw->place_review_id : 0),
                        'type'            => intval($_message_raw->type),
                        'name'            => !empty($_message_raw->name) ? $_message_raw->name : '',
                        'place_name'      => !empty($_message_raw->place_name) ? $_message_raw->place_name : '',
                        'count_follow'    => intval($_message_raw->count_follow),
                        'count_like'      => intval($_message_raw->count_like),
                        'count_comment'   => intval($_message_raw->count_comment)
                    ));
                    
                    // Send to Android device
                    if (!empty($google_regid)) {
                        Cli::write('Send message to Android device ' . $google_regid);
                        $check = \Gcm::sendMessage(array(
                            'google_regid' => $google_regid,
                            'message' => $_message,
                        ));
                        
                        if ($check) {
                            $is_sent = 1;
                        } else {
                            \LogLib::error('Can not send message to Android device ', __METHOD__, $google_regid);
                        }
                    }
                    
                    // Send to iOS device
                    if (!empty($apple_regid)) {
                        $_error_response = '';
                        Cli::write('Send message to iOS device ' . $apple_regid);
                        $check = \Helper::send_ios_notification($apple_regid, $_messageIos, $_message, $_error_response);
                        
                        if ($check) {
                            $is_sent = 1;
                        } else {
                            \LogLib::error('Can not send message to iOS device ', __METHOD__, $apple_regid);
                            if (!empty($_error_response)) {
                                \LogLib::error('=> ' . $_error_response, __METHOD__, $apple_regid);
                                Cli::write(' => ' . $_error_response);
                            }
                        }
                    }
                    
                    // Update db
                    if ($is_sent) {               
                        $message->set('is_sent', '1');
                        $message->set('sent_date', time());
                        $message->save();
                    }
                }
            }
        } catch (Exception $ex) {
            \LogLib::error(sprintf("Exception\n"
                . " - Message : %s\n"
                . " - Code : %s\n"
                . " - File : %s\n"
                . " - Line : %d\n"
                . " - Stack trace : \n"
                . "%s", $ex->getMessage(), $ex->getCode(), $ex->getFile(), $ex->getLine(), $ex->getTraceAsString()), __METHOD__);
            Cli::write($ex->getMessage());
        }
        
        \LogLib::info('END [Push message] ' . date('Y-m-d H:i:s'), __METHOD__, array());
        Cli::write("END [Push message] ".date('Y-m-d H:i:s')."\n");
        \Lib\Util::deleteTaskLock(self::$lock_filename);// KienNH 2016/06/07
        exit;
    }

}
