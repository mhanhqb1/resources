<?php
/**
 * Support functions for Email
 *
 * @package Lib
 * @created 2014-11-25
 * @version 1.0
 * @author thailh
 * @copyright Oceanize INC
 */
namespace Lib;

use Fuel\Core\Config;

class Email {

    public static function beforeSend() {
        $send = Config::get('send_email', true);
        if ($send == false) {
            return false;
        }
        return true;
    }
    
    /**
     * Send email to test email (For testing)
     *
     * @author thailh
     * @param string email Email
     * @return string Real email | test email
     */
    public static function to($email) {
        $test_email = Config::get('test_email', '');
        return !empty($test_email) ? $test_email : $email;
    }
    
    /**
     * Send email if forgetting password
     *
     * @author thailh
     * @param array $param Information for sending email
     * @return bool Return true if successful ortherwise return false
     */
    public static function sendForgetPasswordEmail($param) {
        if (self::beforeSend() == false) {
            return true;
        }
        $to = $param['email'];
        $subject = self::getSubject($param, 'forget_password');
        $view = self::getBodyView($param, 'pc', 'forget_password');
        
        $email = \Email::forge('jis');
        $email->from(Config::get('system_email.noreply'), 'Bmaps No reply');
        $email->subject($subject);
        
        $data['url'] = Config::get('fe_url') . "resetpassword/{$param['token']}";
        $data['token']= $param['token'];
        $data['user_name']= $param['name'];
        $body = \View::forge($view, $data);
        $email->html_body($body);
        $email->to(self::to($to));
        $ok = 0;
        try {
            \LogLib::info("Sent email to {$to}", __METHOD__, $param);
            if ($email->send()) {
                $ok = 1;
            }
        } catch (\EmailSendingFailedException $e) {
            \LogLib::warning($e, __METHOD__, $param);
        } catch (\EmailValidationFailedException $e) {
    		\LogLib::warning($e, __METHOD__, $param);
    	}
        \Model_Mail_Send_Log::add(array(
            'user_id' => !empty($param['user_id']) ? $param['user_id'] : 0,
            'type' => \Model_Mail_Send_Log::TYPE_EMAIL_FORGET_PASSWORD,
            'title' => $subject,
            'content' => $body,
            'to_email' => $to,
            'status' => $ok
        ));
        return (boolean) $ok;
    }
    
    /**
     * Send email if forgetting password for mobile only
     *  
     * @author thailh
     * @param array $param Information for sending email
     * @return bool Return true if successful ortherwise return false
     */
    public static function sendForgetPasswordEmailForMobile($param) {
        if (self::beforeSend() == false) {
            return true;
        }
        $to = $param['email'];
        $subject = self::getSubject($param, 'forget_password');
        $view = self::getBodyView($param, 'mobile', 'forget_password');
        
        $email = \Email::forge('jis');
        $email->from(Config::get('system_email.noreply'), 'Bmaps No reply');
        $email->subject($subject);
        
        $data['user_name'] = $param['name'];
        $data['token'] = $param['token'];
        $body = \View::forge($view, $data);
        $email->html_body($body);
        $email->to(self::to($to));
        $ok = 0;
        try {
            \LogLib::info("Sent email to {$to}", __METHOD__, $param);
            if ($email->send()) {
                $ok = 1;
            }
        } catch (\EmailSendingFailedException $e) {
            \LogLib::warning($e, __METHOD__, $param);
        } catch (\EmailValidationFailedException $e) {
    		\LogLib::warning($e, __METHOD__, $param);
    	}
        \Model_Mail_Send_Log::add(array(
            'user_id' => !empty($param['user_id']) ? $param['user_id'] : 0,
            'type' => \Model_Mail_Send_Log::TYPE_EMAIL_FORGET_PASSWORD,
            'title' => $subject,
            'content' => $body,
            'to_email' => $to,
            'status' => $ok
        ));
        return (boolean) $ok;
    }
    
    /**
     * Send create user
     *
     * @author thailh
     * @param array $param Information for sending email
     * @return bool Return true if successful ortherwise return false
     */
    public static function sendCreateUser($param) {
        if (self::beforeSend() == false) {
            return true;
        }
        
        $subject = self::getSubject($param, 'create_user');
        $view = self::getBodyView($param, 'pc', 'create_user');
        $to = $param['email'];
        $email = \Email::forge('jis');
        $email->from(Config::get('system_email.noreply'), 'Bmaps No reply');
        $email->subject($subject);
        $data['url']= Config::get('fe_url') . "login";
        $data['password'] = $param['password'];
        $body = \View::forge($view, $data);
        $email->html_body($body);
        $email->to(self::to($to));
        $ok = 0;
        try {
            \LogLib::info("Sent email to {$to}", __METHOD__, $param);
            if ($email->send()) {
                $ok = 1;
            }
        } catch (\EmailSendingFailedException $e) {
            \LogLib::warning($e, __METHOD__, $param);
        } catch (\EmailValidationFailedException $e) {
            \LogLib::warning($e, __METHOD__, $param);
        }
        \Model_Mail_Send_Log::add(array(
            'user_id' => !empty($param['user_id']) ? $param['user_id'] : 0,
            'type' => \Model_Mail_Send_Log::TYPE_EMAIL_ADMIN_CREATE_USER,
            'title' => $subject,
            'content' => $body,
            'to_email' => $to,
            'status' => $ok
        ));
        return (boolean) $ok;
    }
    
    /**
     * Send register email
     *
     * @author thailh
     * @param array $param Information for sending email
     * @return bool Return true if successful ortherwise return false
     */
    public static function sendRegisterEmail($param) {
        if (self::beforeSend() == false) {
            return true;
        }
        $subject = self::getSubject($param, 'register');
        $view = self::getBodyView($param, 'pc', 'register');
        
    	$to = $param['email'];
    	$email = \Email::forge('jis');
    	$email->from(Config::get('system_email.noreply'), 'Bmaps No reply');
    	$email->subject($subject);
        $param['url']= Config::get('fe_url') . "active/{$param['token']}";
    	$body = \View::forge($view, $param);
    	$email->html_body($body);
    	$email->to(self::to($to));
        $ok = 0;
    	try {
    		\LogLib::info("Sent email to {$to}", __METHOD__, $param);
            if ($email->send()) {
                $ok = 1;
            }
    	} catch (\EmailSendingFailedException $e) {
    		\LogLib::warning($e, __METHOD__, $param);
    	} catch (\EmailValidationFailedException $e) {
    		\LogLib::warning($e, __METHOD__, $param);
    	}
        \Model_Mail_Send_Log::add(array(
            'user_id' => !empty($param['user_id']) ? $param['user_id'] : 0,
            'type' => \Model_Mail_Send_Log::TYPE_EMAIL_REGISTER,
            'title' => $subject,
            'content' => $body,
            'to_email' => $to,
            'status' => $ok
        ));
        return (boolean) $ok;
    }
    
    /**
     * send mail to user's email when user be activated
     *
     * @author Le Tuan Tu
     * @param array $param Information for sending email
     * @return bool Return true if successful otherwise return false
     */
    public static function sendRegisterActiveEmail($param){
        if (self::beforeSend() == false) {
            return true;
        }
        $to = $param['email'];
        $subject = self::getSubject($param, 'register_active');
        $view = self::getBodyView($param, 'pc', 'register_active');
        $email = \Email::forge('jis');
        $email->from(Config::get('system_email.noreply'), 'Bmaps No reply');
        $email->subject($subject);
        $body = \View::forge($view);
        $email->body($body);
        $email->to($to);
        $ok = 0;
    	try {
    		\LogLib::info("Sent email to {$to}", __METHOD__, $param);
            if ($email->send()) {
                $ok = 1;
            }
    	} catch (\EmailSendingFailedException $e) {
    		\LogLib::warning($e, __METHOD__, $param);
    	} catch (\EmailValidationFailedException $e) {
    		\LogLib::warning($e, __METHOD__, $param);
    	}
        \Model_Mail_Send_Log::add(array(
            'user_id' => !empty($param['user_id']) ? $param['user_id'] : 0,
            'type' => \Model_Mail_Send_Log::TYPE_EMAIL_REGISTER_ACTIVE,
            'title' => $subject,
            'content' => $body,
            'to_email' => $to,
            'status' => $ok
        ));
        return (boolean) $ok;
    }
    
     /**
     * Send when user quit
     *
     * @author Cao Dinh Tuan
     * @param array $param Information for sending email
     * @return bool Return true if successful ortherwise return false
     */
    public static function sendUserQuitEmail($param) {
        if (self::beforeSend() == false) {
            return true;
        }
        $subject = self::getSubject($param, 'cancel_user');
        $view = self::getBodyView($param, 'pc', 'cancel_user');
        $to = $param['email'];
        $email = \Email::forge('jis');
        $email->from(Config::get('system_email.noreply'), 'Bmaps No reply');
        $email->subject($subject);
        $param['name'] = !empty($param['name']) ? $param['name'] : '';
        $body = \View::forge($view, $param);
        $email->html_body($body);
        $email->to(self::to($to));
        $ok = 0;
        try {
            \LogLib::info("Sent email to {$to}", __METHOD__, $param);
            if ($email->send()) {
                $ok = 1;
            }
        } catch (\EmailSendingFailedException $e) {
            \LogLib::warning($e, __METHOD__, $param);
        } catch (\EmailValidationFailedException $e) {
            \LogLib::warning($e, __METHOD__, $param);
        }
        \Model_Mail_Send_Log::add(array(
            'user_id' => !empty($param['user_id']) ? $param['user_id'] : 0,
            'shop_id' => 0,
            'nailist_id' => 0,
            'type' => \Model_Mail_Send_Log::TYPE_EMAIL_QUIT_USER,
            'title' => $subject,
            'content' => $body,
            'to_email' => $to,
            'status' => $ok
        ));
        return (boolean) $ok;
    }
    
    /**
     * Send when user quite
     *
     * @author Cao Dinh Tuan
     * @param object $param Information for sending email
     * @return bool Return true if successful ortherwise return false
     */
    public static function resendEmail($param) {
        if (self::beforeSend() == false ) {
            return true;
        }
        if(empty($param->get('to_email'))){
             \LogLib::warning('Email is null or empty', __METHOD__, $param->get('to_email'));
            return false;
        }
        $to = $param->get('to_email');
        $email = \Email::forge('jis');
        $email->from(Config::get('system_email.noreply'), 'Bmaps No reply');
        $email->subject( $param->get('title'));
        $body = $param->get('content');
        $email->html_body($body);
        
        $email->to(self::to($to));
        try {
            \LogLib::info("Resent email to {$to}", __METHOD__, $param);
            return $email->send();
        } catch (\EmailSendingFailedException $e) {
            \LogLib::warning($e, __METHOD__, $param);
            return false;
        } catch (\EmailValidationFailedException $e) {
            \LogLib::warning($e, __METHOD__, $param);
            return false;
        }
    }
    
    /**
     * Send test
     *
     * @author thailh
     * @param array $param Information for sending email
     * @return bool Return true if successful ortherwise return false
     */
    public static function sendTest($param) {
        if (self::beforeSend() == false ) {
            return true;
        }
        $to = !empty($param['to']) ? $param['to'] : '';
        if (empty($to)) {
            \LogLib::warning('Email is null or empty', __METHOD__, $to);
            return false;
        }
        $email = \Email::forge('jis');
        $email->from(Config::get('system_email.noreply'), '[Test] Bmaps No reply');
        $email->subject('Test at ' . date('Y-m-d H:i'));
        $body  = 'This is message that sent from Bmaps.world.<br/><br/>';
        $email->html_body($body);
        $email->to(self::to($to));
        try {
            \LogLib::info("Resent email to {$to}", __METHOD__, $param);
            return $email->send();
        } catch (\EmailSendingFailedException $e) {
            \LogLib::warning($e, __METHOD__, $param);
            return false;
        } catch (\EmailValidationFailedException $e) {
            \LogLib::warning($e, __METHOD__, $param);
            return false;
        }
    }
    
    /**
     * Send contact email
     * 
     * @param array $param
     * @return boolean
     */
    public static function sendContactEmail($param, &$error = '') {
        if (self::beforeSend() == false ) {
            return true;
        }
        
        $emailConfig = Config::get('system_email');
        $to = $param['email'];
        $subject = self::getSubject($param, 'landing');
        $view = self::getBodyView($param, 'pc', 'landing');
        $body = \View::forge($view, $param);
        
        $email = \Email::forge('jis');
        $email->from($emailConfig['noreply'], 'Bmaps No reply');
        $email->subject($subject);
        $email->body($body);
        $email->to($to);
        if (!empty($emailConfig['bcc'])) {
            $email->bcc($emailConfig['bcc']);
        }
        $ok = 0;
        
        try {
            \LogLib::info("Sent email to {$to}", __METHOD__, $param);
            if ($email->send()) {
                $ok = 1;
            }
        } catch (\Exception $e) {
            \LogLib::warning($e, __METHOD__, $param);
            $error = $e->getMessage();
        }
        
        \Model_Mail_Send_Log::add(array(
            'user_id'  => !empty($param['login_user_id']) ? $param['login_user_id'] : 0,
            'type'     => \Model_Mail_Send_Log::TYPE_EMAIL_CONTACT,
            'title'    => $subject,
            'content'  => $body,
            'to_email' => $to,
            'status'   => $ok
        ));
        
        return (boolean) $ok;
    }
    
    /**
     * Get email view
     * 
     * @param array $param
     * @param string $path
     * @param string $view
     * @return string
     */
    public static function getBodyView($param, $path, $view) {
        $default_view = 'email/' . $path . '/' . $view;
        $lang_map = array(
            2 => 'en',
            3 => 'th',
            4 => 'vi',
            5 => 'es',
        );
        $language_type = !empty($param['language_type']) ? $param['language_type'] : 1;
        if (empty($lang_map[$language_type])) {
            return $default_view;
        }
        $view_check = 'email/' . $path . '/' . $lang_map[$language_type] . '/' . $view;
        if (file_exists(APPPATH . 'views/' . $view_check . '.php')) {
            return $view_check;
        }
        return $default_view;
    }
    
    /**
     * Get Email subject
     * 
     * @param array $param
     * @param string $type
     * @return string
     */
    public static function getSubject($param, $type) {
        // Init
        $default_subject = 'Bmaps';
        $subject_config = Config::get('email_subject');
        $language_type = !empty($param['language_type']) ? $param['language_type'] : 1;
        $default_language_type = 1;
        
        // Check valid
        if (empty($type) || empty($subject_config[$type])) {
            return $default_subject;
        }
        
        // Choose Subject
        if (!empty($subject_config[$type][$language_type])) {
            return $subject_config[$type][$language_type];
        } else if (!empty ($subject_config[$type][$default_language_type])) {
            return $subject_config[$type][$default_language_type];
        }
        
        return $default_subject;
    }
    
}
