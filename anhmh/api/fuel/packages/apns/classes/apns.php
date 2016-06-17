<?php

/**
 * Fuel
 *
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Apns
 * @version    1.0
 * @author     ThaiLH
 * @license    MIT License
 * @copyright  OCEANIZE, Inc
 * @link       http://fuelphp.com
 */

namespace Apns;

include (__DIR__ . "/Apns/ApnsPHP/Autoload.php");

class Apns {
    
    public static function sendMessage($param = array()) {
        \Config::load('file', true); 
        if (empty($param['apple_regid']) || empty($param['message'])) {
            \LogLib::info('Param is invalid', __METHOD__, $param);
            return false;
        }
        \LogLib::info('Apns Start:', __METHOD__, $param);
        try {
            $env = \Fuel::$env;
            if ($env == 'development' || $env == 'test' || $env == 'staging' || $env == 'mike_dev') {
                $_enviroment = \ApnsPHP_Abstract::ENVIRONMENT_SANDBOX;
                $_ertificateFile = \Config::get('apns.local_cert_dev');
            } else {
                $_enviroment = \ApnsPHP_Abstract::ENVIRONMENT_PRODUCTION;
                $_ertificateFile = \Config::get('apns.local_cert');
            }
            
            $push = new \ApnsPHP_Push(
                $_enviroment,
                $_ertificateFile
            );
            $push->connect();
            $message = new \ApnsPHP_Message($param['apple_regid']);

            // Set a text　message
            $message->setText($param['message']);
            
            // Set custom data
            if (!empty($param['custom'])) {
                $message->setCustomProperty('bmaps', $param['custom']);
            }

            // Play the default sound
            if (!empty($param['ios_sound'])) {
                $message->setSound();
            }

            // Set the expiry value to 30 seconds
            $message->setExpiry(\Config::get('apns.expiry', 30));

            // Add the message to the message queue
            $push->add($message);

            // Send all messages in the message queue
            $push->send();

            // Disconnect from the Apple Push Notification Service
            $push->disconnect();

            \LogLib::info('Apns End:', __METHOD__, $param);
            
            return true;
       
        } catch (\Exception $e) {   
            \LogLib::error(sprintf("Apns Exception\n"
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
            //throw new \Exception($e->getMessage(), 500); 
        }       
        return false;
    }

}
