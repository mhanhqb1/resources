<?php

/**
 * Fuel
 *
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Gcm
 * @version    1.0
 * @author     ThaiLH
 * @license    MIT License
 * @copyright  OCEANIZE, Inc
 * @link       http://fuelphp.com
 */

namespace Gcm;

class Gcm {

    //private static $_url = 'https://android.googleapis.com/gcm/send';
    private static $_url = 'https://gcm-http.googleapis.com/gcm/send';

    /**
     * Push message to android
     *
     * @author thailh
     * @param array $param Input data
     * @return bool Success or otherwise
     * @see https://developers.google.com/cloud-messaging/
     * @see https://developers.google.com/cloud-messaging/server-ref#params 
     */
    public static function sendMessage($param = array()) {
        if (empty($param['google_regid']) || empty($param['message'])) {
            \LogLib::info('Param is invalid', __METHOD__, $param);
            return false;
        }
        \LogLib::info('GCM Start:', __METHOD__, $param);
        try {
            if (!is_array($param['google_regid'])) {
                $param['google_regid'] = array($param['google_regid']);
            }
            $headers = array(
                'Content-Type: application/json',
                'Authorization: key=' . \Config::get('gcm.authorization_key')
            );
            /*
            $postFields = array(
                'registration_ids' => $param['google_regid'],
                'collapse_key' => 'score_update',
                'data' => array(
                    'message' => $param['message'],
                    'title' => !empty($param['title']) ? $param['title'] : '',
                )
            );
            * 
            */         
            $postFields = array(
                'registration_ids' => $param['google_regid'],               
                'data' => json_decode($param['message'], false)
            );
            $ch = curl_init();
            $options = array(
                CURLOPT_URL => static::$_url,
                CURLOPT_HEADER => false,
                CURLOPT_POST => true,
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_POSTFIELDS => json_encode($postFields),
                CURLOPT_FAILONERROR => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SAFE_UPLOAD => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_TIMEOUT => \Config::get('gcm.timeout', 30),
            );
            curl_setopt_array($ch, $options);
            $jsonResponse = curl_exec($ch);
            \LogLib::info("GCM End:", __METHOD__, $jsonResponse);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $errno = curl_errno($ch);
            if (empty($errno) && $httpcode == 200) {
                $result = json_decode($jsonResponse, true);
                return !empty($result['success']) ? true : false;
            }
            $error = curl_error($ch);
            \LogLib::info("GCM End:", __METHOD__, $error);
            curl_close($ch);
        } catch (\Exception $e) {
            \LogLib::error(sprintf("GCM Exception\n"
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
        }
        return false;
    }

}
