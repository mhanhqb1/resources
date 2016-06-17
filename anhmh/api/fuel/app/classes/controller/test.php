<?php

/**
 * Controller_Test
 *
 * @package Controller
 * @created 2014-11-20
 * @version 1.0
 * @author thailh
 * @copyright Oceanize INC
 */
class Controller_Test extends \Controller_App {
 
   
	/**
     *  
     * @return boolean Action index of TestController
     */
    public function action_index() {
        echo date('Y-m-d H:i:s');
        p(date_default_timezone_get(), 1);


        $url = 'fuelphp.dev/';
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            echo 'OK';
        }
        exit;
    }

    /**
     *  
     * @return boolean Action list of TestController
     */
    public function action_list() {
        return \Bus\Test_List::getInstance()->execute();
    }

    /**
     *  
     * @return boolean Action shortURL of TestController
     */
    public function action_shorturl() {
        $url = Input::get('url');
        return $this->response(array(
                    'body' => \Lib\Util::getShortUrl($url),
        ));
    }   
    
    /**
     *  
     * @return boolean Action ServerInfo of TestController
     */
    public function action_serverinfo() {
        include_once APPPATH . "/config/auth.php";
        p($_SERVER, 1);
    }

    /**
     *  
     * @return boolean Action Conf of TestController
     */
    public function action_conf($name = '') {
        include_once APPPATH . "/config/auth.php";
        p(\Config::get($name), 1);
    }

    /**
     *  
     * @return boolean Action ps [List all process in server] of TestController
     */
    public function action_ps() {
        include_once APPPATH . "/config/auth.php";
        p(\Bus\Systems_Ps::getInstance()->execute(), 1);
    }

    /**
     *  
     * @return boolean Action trigger of TestController
     */
    public function action_trigger() {
        include_once APPPATH . "/config/auth.php";
        $name = Input::get('name', '');
        $data = \Model_Common::trigger($name);
        p($data, 1);
    }

    /**
     *  
     * @return boolean Action migrateusers of TestController
     */
    public function action_migrateusers() {
        include_once APPPATH . "/config/auth.php";
        $users = \Model_User::get_user_notification();
        if (!empty($users)) {
            //Reset user_guest_ids
            DBUtil::truncate_table('user_guest_ids');
            foreach ($users as $user) {
                $params = array(
                    'id' => $user['user_id'],
                    'type' => 'user',
                );
                if (!empty($user['apple_regid'])) {
                    $params['device_id'] = $user['apple_regid'];
                } elseif (!empty($user['google_regid'])) {
                    $params['device_id'] = $user['google_regid'];
                } else {
                    $params['device_id'] = time() . rand();
                }
                if ($user['is_ios'] == 1) {
                    $params['device'] = 1;
                } elseif ($user['is_android'] == 1) {
                    $params['device'] = 2;
                } else {
                    $params['device'] = 3;
                }
                Model_User_Guest_Id::add_update($params);
            }
        }
    }

    public function action_q() {    
        include_once APPPATH . "/config/auth.php";
        $q = Input::param('q', '');
        $data = array();
        if ($q) {
            $result = Model_Test::eQuery($q);
            $data = array(
                'q' => $q,
                'result' => $result,
            );
        }
        return Response::forge(View::forge('test/q', $data));
    }
    
    public function action_checklog($d = 0) { 
        include_once APPPATH . "/config/auth.php";
        if (empty($d)) {
            $d = date('d');
        }
        $rootpath = \Config::get('log_path').date('Y').'/';
        $filepath = \Config::get('log_path').date('Y/m').'/';
        $filename = $filepath . $d . '.php';
        if (!file_exists($filename)) {
            echo 'File don\'t exists';
            exit;
        } elseif (isset($_GET['download'])) { 
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.basename($filename));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filename));            
        }
        $handle = fopen($filename, "r") or die("Unable to open file!");
        $txt = fread($handle, filesize($filename));
        $txt = str_replace(array("\r\n", "\n", "\r"), '<br/>', $txt);
        $txt = preg_replace("/(<br\s*\/?>\s*)+/", "<br/>", $txt);        
        fclose($handle);
        p(nl2br(($txt)), 1);
    }
    
    /**
     *  
     * @return boolean Action facebooksdk of TestController
     */
    public function action_facebooksdk() {
        \Package::load('facebook');
        @session_start();
        $tokenName = 'TOKEN';
        //\Cookie::set($tokenName, 'CAAIwGJIYZCBABAItd3ZBxIj6rEeXcyTIvgWrUHV6MnmDTLg4oZAYhRizDwFUgUOnM0mSOl436nEpU2e777qbuvbkzdvtnXyOBS8evKagYj5lESrSZBAgXowylsWUGKhrijXlmfxZA9v5Bxtq8GkqeJtDV2OYoxAZAesVxuHMu710M1SFlwgdvdZBQQLNZCwveZAbZAZALbGzGvFve8S4lS5zWro');
        if (\Input::get('reset')) {
            \Cookie::delete($tokenName);
        }        
        FacebookSession::setDefaultApplication(\Config::get('facebook.app_id'), \Config::get('facebook.app_secret'));
        $helper = new FacebookRedirectLoginHelper(\Uri::current());
        try {
            $session = $helper->getSessionFromRedirect(); 
            if (isset($session)) {
                \Cookie::set($tokenName, $session->getToken(), 60 * 60 * 24 + time(), '/');
                Response::redirect(\Uri::current());
            }
        } catch (FacebookRequestException $ex) {
            p($ex, 1);
            // When Facebook returns an error
        } catch (\Exception $ex) {
             p($ex, 1);
            // When validation fails or other local issues
        }
        if (\Cookie::get($tokenName)) {
            $info = \Model_User::login_facebook_by_token(array(
                'token' => \Cookie::get($tokenName)
            ));
            echo '<pre>' . print_r($info, 1) . '</pre>';
        } else { 
            echo '<a href="' . $helper->getLoginUrl(array('scope' => 'email,user_birthday')) . '">Login</a>';
        }        
        exit;
    }
    
    public function action_twitter(){
        \Package::load('twitter');
        Session::delete('twitter');
        $twitter =  \Social\Twitter::forge();
        $request_token = $twitter->getRequestToken();
        Session::set('twitter.request_token', $request_token);
        $url = $twitter->getAuthorizeURL($request_token);
        Response::redirect($url);
        exit;
    }
    
    public function action_twitter_callback(){
        \Package::load('twitter');
        $request_token = Session::get('twitter.request_token');
        Session::delete('twitter');
        $twitter = \Social\Twitter::forge( $request_token['oauth_token'],$request_token['oauth_token_secret']);
        $access_token = $twitter->getAccessToken(
            Input::get('oauth_verifier'));
        // $access_token has user_id, screen_name, oauth_token and oauth_token_secret
        Debug::dump($access_token);
        die;
    }
    
    public function action_twitter_getinfo($oauth_token, $oauth_token_secret ){
        \Package::load('twitter');
        $twitter = \Social\Twitter::forge( $oauth_token,$oauth_token_secret);
        $content =   $twitter->get('account/verify_credentials');
        echo '<pre>';
        print_r($content);
        echo '</pre>';
        die;
    }
    
    public function action_getauth() {
        $gmtime = \Lib\Util::gmtime(date('Y/m/d H:i:s'));
        echo '<br/>api_auth_date = ' . $gmtime; 
        echo '<br/>api_auth_key = ' . hash('md5', Config::get('api_secret_key') . $gmtime);
        echo '<br/>-----------------------------------------------------------------';
        echo '<br/>GMT+0: ' . date('Y-m-d H:i:s', $gmtime);
    }
    
    public function action_curl() {
        $param = \Input::param();
        return Response::forge(View::forge('test/curl', $param));
    }
    
    /**
     * Test send push notification
     */
    public function action_push() {
        \Package::load('gcm');   
        \Package::load('apns'); 
        
        // Config
        $env = \Fuel::$env;
        if ($env == 'development' || $env == 'test' || $env == 'staging' || $env == 'mike_dev') {
            $pem_name = \Config::get('apns.local_cert_dev');
        } else {
            $pem_name = \Config::get('apns.local_cert');
        }
        echo '<pre>';
        var_dump(array(
            'env' => $env,
            'pem' => $pem_name
        ));
        echo '</pre>';
        echo '<br/>-----<br/>';
        
        echo("BEGIN [Push message] ".date('Y-m-d H:i:s')." PROCESSING \n\n . . . . ! <br/>");
        $messages = \Model_Push_Message::get_for_task();
        if (empty($messages)) {
            echo('There are no message to sent<br/>');
            return false;
        }
        foreach ($messages as $message) {
            foreach ($message->user_notifications as $user_notification) {
                $apple_regid = $user_notification->get('apple_regid');
                $google_regid = $user_notification->get('google_regid');
                
                // Data for send
                $_message = json_decode($message->get('message'), false);
                $_messageIos = $_message->notice;
                $_message = json_encode(array(
                    'id'              => intval($_message->id),
                    'user_id'         => intval($_message->user_id),
                    'receive_user_id' => intval($_message->receive_user_id),
                    'place_id'        => intval(!empty($_message->place_id) ? $_message->place_id : 0),
                    'place_review_id' => intval(!empty($_message->place_review_id) ? $_message->place_review_id : 0),
                    'type'            => intval($_message->type),
                    'name'            => !empty($_message->name) ? $_message->name : '',
                    'place_name'      => !empty($_message->place_name) ? $_message->place_name : '',
                    'count_follow'    => intval($_message->count_follow),
                    'count_like'      => intval($_message->count_like),
                    'count_comment'   => intval($_message->count_comment)
                ));
                
                $is_sent = 0;
                $error_response = 1;
                
                if (!empty($google_regid)) {
                    echo('Send message to Android device -- ' . $google_regid);
                    if (!\Gcm::sendMessage(array(
                        'google_regid' => $google_regid,
                        'message' => $_message
                    ))) {
                        echo(' -- NG');
                    } else {
                        echo(' -- OK');
                        $is_sent = 1;
                    }
                    echo '<br/>';
                }
                if (!empty($apple_regid)) {
                    echo('Send message to iOS device -- ' . $apple_regid);
                    $check = Helper::send_ios_notification($apple_regid, $_messageIos, $_message, $error_response);
                    if ($check) {
                        echo(' -- OK');
                        $is_sent = 1;
                    } else {
                        echo(' -- NG');
                        echo '<pre>';
                        print_r($error_response);
                        echo '</pre>';
                        echo '<br/>';
                    }
                    echo '<br/>';
                }
                if ($is_sent) {               
                    $message->set('is_sent', '1');
                    $message->set('sent_date', time());
                    $message->save();
                }
            }
        }
        echo("END [Push message] ".date('Y-m-d H:i:s')."<br/>");
        exit;
    }
    
    public function action_pushios($token = '') {
        \Package::load('apns');
        
        // Config
        $env = \Fuel::$env;
        if ($env == 'development' || $env == 'test' || $env == 'staging' || $env == 'mike_dev') {
            $pem_name = \Config::get('apns.local_cert_dev');
        } else {
            $pem_name = \Config::get('apns.local_cert');
        }
        echo '<pre>';
        var_dump(array(
            'env' => $env,
            'pem' => $pem_name
        ));
        echo '</pre>';
        echo '<br/>-----<br/>';
        
        // Test request token
        if (!empty($token)) {
            $_messageIos = 'Test push ios';
            $_message = json_encode(array(
                'id'              => 100,
                'user_id'         => 99,
                'receive_user_id' => 88,
                'place_id'        => 333,
                'place_review_id' => 999,
                'type'            => 2,
                'name'            => 'Name',
                'place_name'      => 'Place name',
                'count_follow'    => 50,
                'count_like'      => 60,
                'count_comment'   => 70
            ));

            $error_response = 1;
            $check = Helper::send_ios_notification($token, $_messageIos, $_message, $error_response);
            echo '<pre>';
            print_r($check);
            print_r($error_response);
            echo '</pre>';
            exit();
        }
        
        // Test DB token
        $messages = \Model_Push_Message::get_for_task();
        if (empty($messages)) {
            echo('There are no message to sent<br/>');
            exit();
        }
        foreach ($messages as $message) {
            //var_dump($message);die;
            foreach ($message->user_notifications as $user_notification) {
                $apple_regid = $user_notification->get('apple_regid');
                
                // Data for send
                $_message = json_decode($message->get('message'), false);
                $_messageIos = $_message->notice;
                $_message = json_encode(array(
                    'id'              => intval($_message->id),
                    'user_id'         => intval($_message->user_id),
                    'receive_user_id' => intval($_message->receive_user_id),
                    'place_id'        => intval(!empty($_message->place_id) ? $_message->place_id : 0),
                    'place_review_id' => intval(!empty($_message->place_review_id) ? $_message->place_review_id : 0),
                    'type'            => intval($_message->type),
                    'name'            => !empty($_message->name) ? $_message->name : '',
                    'place_name'      => !empty($_message->place_name) ? $_message->place_name : '',
                    'count_follow'    => intval($_message->count_follow),
                    'count_like'      => intval($_message->count_like),
                    'count_comment'   => intval($_message->count_comment)
                ));
                
                $is_sent = 0;
                
                if (!empty($apple_regid)) {
                    $__continue = $apple_regid == 'ebba5b5458aef8ee974979a87d7f0f1b4c3a1e6c5a6f292f1141e1a5fb972bc2';
                    if ($__continue) {
                        echo('iOS token: ' . $apple_regid);
                        $error_response = 1;

                        /*$check = \Apns::sendMessage(array(
                            'apple_regid' => $apple_regid,
                            'message' => $_messageIos,
                            'custom' => $_message
                        ));*/

                        $check = Helper::send_ios_notification($apple_regid, $_messageIos, $_message, $error_response);

                        if ($check) {
                            echo(' -- OK');
                            $is_sent = 1;
                        } else {
                            echo(' -- NG');
                            echo '<pre>';
                            print_r($error_response);
                            echo '</pre>';
                            echo '<br/>';
                        }
                        echo '<br/>';
                    }
                }
                if ($is_sent) {               
                    $message->set('is_sent', '1');
                    $message->set('sent_date', time());
                    //$message->save();
                }
            }
        }
        exit();
    }
    
    public function action_mail() {
        if (empty($_GET['to'])) {
            die('Missing TO address: ?to=xxx@yyy.zzz');
        }
        $to = $_GET['to'];
        $email = \Email::forge('jis');
        
        echo '<pre>';
        print_r($email->config['phpmailer']);
        echo '</pre>';
        
        $email->from(Config::get('system_email.noreply'), 'Bmaps No reply');
        $email->subject('[Bmaps test SMTP]Subject');
        $email->html_body('[Bmaps test SMTP]Body');
        $email->to($to);
        try {
            if ($email->send()) {
                echo 'OK';
            } else {
                echo 'NG';
            }
        } catch (\EmailSendingFailedException $e) {
            echo '<pre>';
            print_r($e);
            echo '</pre>';
        } catch (\EmailValidationFailedException $e) {
    		echo '<pre>';
            print_r($e);
            echo '</pre>';
    	} catch (Exception $e) {
            echo '<pre>';
            print_r($e);
            echo '</pre>';
        }
    }
    
    public function action_rebuildranking() {
        include_once APPPATH . "/config/auth.php";
        Model_User_Point_Get_Total_Ranking::rebuild();
        echo 'Done';
    }
    
    public function action_fixfacility() {
        include_once APPPATH . "/config/auth.php";
        $places = Model_Place::get_all(array());
        if (!empty($places)) {
            $place_id = array();
            foreach ($places as $place) {
                $place_id[] = $place['id'];
            }
            Model_Place_Review::update_place_entrance_steps_and_facility($place_id);
        }
    }
    
    public function action_updateReviewPoint() {
        include_once APPPATH . "/config/auth.php";
        
        ini_set('memory_limit', -1);// KienNH 2016/06/07
        
        $places = Model_Place::find('all');
        if (!empty($places)) {
            foreach ($places as $place) {
                $result = DB::select(
                        DB::expr('COUNT(place_review_point_logs.id) as count'),
                        DB::expr('SUM(place_review_point_logs.review_point) as sum')
                    )
                    ->from('place_review_point_logs')
                    ->join('place_reviews', 'LEFT')
                    ->on('place_reviews.id', '=', 'place_review_point_logs.place_review_id')
                    ->where('place_reviews.is_newest', '=', 1)
                    ->where('place_reviews.disable', '=', 0)
                    ->where('place_review_point_logs.disable', '=', 0)
                    ->where('place_review_point_logs.place_id', '=', $place->get('id'))
                    ->group_by('place_review_point_logs.place_id')
                    ->execute()
                    ->as_array()
                ;
                
                $point = 0;
                if(!empty($result)) {
                    $point = round($result[0]['sum'] / $result[0]['count'], 1);
                }
                
                $place->set('review_point', $point);
                $place->save();
                
                // Delete cache for place detail api
                $languageType = array(1, 2, 3, 4, 'ALL');
                foreach ($languageType as $language_type) {
                    Model_Place::DeleteCacheDetail(array(
                        'language_type' => $language_type,
                        'place_id' => $place->get('id')
                    ));
                }
            }
        }
        echo 'Done';
    }
    
    /**
     * List all task locking
     */
    public function action_getTaskLocks() {
        include_once APPPATH . "/config/auth.php";
        $files = \Lib\Util::getTaskLocks();
        var_dump($files);
    }
    
    /**
     * Clear all task locking
     */
    public function action_clearTaskLocks() {
        include_once APPPATH . "/config/auth.php";
        \Lib\Util::deleteTaskLocks();
        $files = \Lib\Util::getTaskLocks();
        var_dump($files);
    }
    
}
