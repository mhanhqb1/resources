<?php

/* 
 * Description: Contain global function
 * Author     : KienNH
 * Date       : 2015/12/18
 */

class helper {
    
    /**
     * Send notification for ios device
     * @param string $deviceToken
     * @param string $message
     * @param json $custom_data
     * @return boolean
     */
    public static function send_ios_notification($deviceToken, $message, $custom_data = NULL, &$error_response = null) {
        // Validate params
        if (empty($deviceToken) || empty($message)) {
            $error_response = 'Empty token or message';
            return FALSE;
        }
        
        // Send
        $check = FALSE;
        
        try {
            $ctx = stream_context_create();
            
            $env = \Fuel::$env;
            if ($env == 'development' || $env == 'test' || $env == 'staging' || $env == 'mike_dev') {
                $pem_name = \Config::get('apns.local_cert_dev');
                $SSL_URL  = 'ssl://gateway.sandbox.push.apple.com:2195';
            } else {
                $pem_name = \Config::get('apns.local_cert');
                $SSL_URL  = 'ssl://gateway.push.apple.com:2195';
            }

            stream_context_set_option($ctx, 'ssl', 'local_cert', $pem_name);
            stream_context_set_option($ctx, 'ssl', 'passphrase', '');

            $fp = null;
            $i  = 0;

            while (!$fp && $i < 4) {
                // Open a connection to the APNS server
                $fp = stream_socket_client($SSL_URL, $errno, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);
                $i++;
            }

            if ($fp) {
                // Create the payload body
                $body['aps'] = array(
                    'alert' => $message,
                    'badge' => 0
                );

                if (!empty($custom_data)) {
                    $body['bmaps'] = $custom_data;
                }

                // Encode the payload as JSON
                $payload = json_encode($body);

                // Build the binary notification
                $msg = chr(0) . pack('n', 32) . pack('H*', str_replace(' ', '', $deviceToken)) . pack('n', strlen($payload)) . $payload;

                // Send it to the server
                $i = 0;
                $result = FALSE;
                while ($result === FALSE && $i < 4) {
                    // Open a connection to the APNS server
                    try {
                        $result = fwrite($fp, $msg, strlen($msg));
                    } catch (Exception $ex) {
                        
                    }
                    $i++;
                    
                    // Delay for resend
                    if ($result === FALSE && $i < 4) {
                        sleep(1); //sleep for 1 seconds
                    }
                }
                
                if ($result === FALSE) {
                    if ($error_response) {
                        $error_response = fread($fp, 6);
                    }
                } else {
                    $error_response = 'OK';
                    $check = TRUE;
                }
            }
        } catch (Exception $ex) {
            $error_response = $ex->getMessage();
        }
        
        // Close socket
        try {
            fclose($fp);
        } catch (Exception $ex) {
            // Do nothing
        }
        
        return $check;
    }
}
