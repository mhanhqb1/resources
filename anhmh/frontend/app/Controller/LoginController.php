<?php

/* 
 * Description : Class contain methods used for Login screen
 * User        : KienNH
 * Date created: 2015/11/05
 */

require APP . "Vendor/twitteroauth/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;

class LoginController extends AppController {
    
    /**
     * Load library
     */
    function beforeFilter () {
        parent::beforeFilter();
        
        $this->Auth->allow(
            'active',
            'email',
            'facebook',
            'twitter', 'twitterCallback',
            'forgetpassword', 'confirmcode', 'resetpassword',
            'guest'
        );
        
        // Set layout
        $this->layout = 'bmaps_base';
    }
    
    /**
     * Top page
     */
    function index() {
        include ('../Config/auth.php'); // Basic Auth
        $this->set('title_for_layout', __d('login', 'LANG_LOGIN_TITLE'));
    }

    /**
     * Login by email
     */
    function email() {
        // Set page title
        $this->set('title_for_layout', __d('login', 'LANG_LOGIN_TITLE'));

        // check login faile limit
        $checkLoginFailed = Api::call(Configure::read('API.url_users_checkloginfailed'));

        if ($checkLoginFailed != '1') {
            $this->Common->setFlashErrorMessage(__d('login', 'LANG_LOGIN_FAILED_LIMIT'));
            $data['Login']['blocked'] = 1;
            $this->set('loginData', $data['Login']);
        } else {
            // Login action
            if ($this->request->is('post')) {
                // Validate from Html form
                $data = $this->data;
                $error = __d('login', 'LANG_LOGIN_FAIL');
                $errorApi = '';
                $check = $this->Login->validateLogin($data, $error);
                // Set error message
                if (!$check) {
                    $this->Common->setFlashErrorMessage($error);
                } else {
                    $submit = $this->data['Submit'];
                    if (isset($submit['register'])) {
                        $user = Api::call(Configure::read('API.url_users_register'), $data['Login']);
                        if (empty(Api::getError())) {
                            if (!empty($user) && $this->setLoginSession($user)) {
                                $this->Common->setFlashSuccessMessage(__('MESSAGE_ACTIVE_EMAIL_ALREADY_REGISTERED_WAITING_ACTIVE'));
                                return $this->redirect($this->request->here(false));
                            }
                        } else {
                            $error = array(
                                'email' => array(
                                    '1005' => __('MESSAGE_EMAIL_MUST_CONTAIN_VALID_ADDRESS'),
                                    '1011' => __('MESSAGE_DUPLICATE_EMAIL'),
                                    '1021' => __('MESSAGE_ACTIVE_EMAIL_ALREADY_REGISTERED_WAITING_ACTIVE')
                                )
                            );
                            $this->Common->setFlashErrorMessage(Api::getError(), $error);
                        }
                    } else {
                        if ($this->loginByEmail($data['Login'], $errorApi)) {
                            return $this->redirect(BASE_URL . '/top');
                        }
                        if (!empty(Api::getError())) {
                            $error = array(
                                'Email/Password' => array(
                                    '403' => __('MESSAGE_INVALID_EMAIL_OR_PASSWORD_TRY_AGAIN'),
                                ),
                                'Invalid Email' => array(
                                    '1012' => __('MESSAGE_INVALID_EMAIL'),
                                ),
                                'Blocked' => array(
                                    '1021' => __('LANG_LOGIN_FAILED_LIMIT')
                                )
                            );
                            $this->Common->setFlashErrorMessage(Api::getError(), $error);
                        }
                    }
                }
                // Set previous login for View
                $this->set('loginData', $data['Login']);
            }
        }

    }
    
    /**
     * Logout
     */
    public function logout() {
        $this->clearLoginSession();
        return $this->redirect(BASE_URL . '/login');
    }
    
    /**
     * Login by Facebook
     */
    public function facebook() {
        $this->autoRender = FALSE;
        $loginData = $this->request->query;
        $errorApi = '';
        
        $check = $this->loginByFacebook($loginData, $errorApi);
        if ($check) {
            // OK
            $result = array(
                'error' => 0,
                'message' => ''
            );
        } else {
            // Error
            $result = array(
                'error' => 1010,
                'message' => $errorApi
            );
        }
        
        echo json_encode($result);
        exit;
    }
    
    /**
     * Login by Twitter
     */
    public function twitter() {
        // Init
        $this->autoRender = FALSE;
        
        // Get request token
        $connection  = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET);
        $request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => BASE_URL . '/login/twitterCallback'));
        
        // Verify
        $this->Session->write('twitter_request_token', $request_token);
        $url = $connection->url("oauth/authorize", array("oauth_token" => $request_token['oauth_token']));
        $this->redirect($url);
    }
    
    /**
     * Twitter callback
     */
    public function twitterCallback() {
        // Init
        $this->autoRender = FALSE;
        $params = $this->request->query;
        $request_token = $this->Session->read('twitter_request_token');
        $errorApi = '';
        
        // Check error
        if (!empty($params['denied']) || empty($request_token['oauth_token']) || empty($request_token['oauth_token_secret'])) {
            $this->Common->setFlashErrorMessage(__d('login', 'LANG_LOGIN_TWITTER_INVALID'));
            return $this->redirect(BASE_URL . '/login');
        }
        
        // Get access token
        $connection  = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET, $request_token['oauth_token'], $request_token['oauth_token_secret']);
        $access_token = $connection->oauth('oauth/access_token', array('oauth_verifier' => $params['oauth_verifier']));
        
        // Check result
        if (empty($access_token) || empty($access_token['oauth_token']) || empty($access_token['oauth_token_secret'])) {
            $this->Common->setFlashErrorMessage(__d('login', 'LANG_LOGIN_TWITTER_INVALID'));
            return $this->redirect(BASE_URL . '/login');
        }
        
        // Call API login
        $oauth_token = $access_token['oauth_token'];
        $oauth_token_secret = $access_token['oauth_token_secret'];
        
        $check = $this->loginByTwitter($oauth_token, $oauth_token_secret, $errorApi);
        if ($check) {
            return $this->redirect(BASE_URL . '/top');
        } else {
            $this->Common->setFlashErrorMessage($errorApi);
            return $this->redirect(BASE_URL . '/login');
        }
    }
    
    /**
     * Register new user
     */
    public function register() {
        if ($this->request->is('post')) {
            $data = $this->data['Register'];  
            if (!empty($data['zipcode1']) && !empty($data['zipcode2'])) {
                $data['zipcode'] = $data['zipcode1'] . '-' . $data['zipcode2'];
            }
            $ok = true;
            if (!empty($data['zipcode']) && strlen($data['zipcode']) != 8) {
                //$this->Common->setFlashErrorMessage(__('Zipcode is invalid'));  
                //$ok = false;
            }
            if ($ok) {
                $user = Api::call(Configure::read('API.url_users_updateprofile'), $data);
                if (!empty($user)) {
                    $user['token'] = $this->AppUI->token;
                    foreach ($data as $field => $value) {
                        if (isset($this->AppUI->{$field})) {
                            if ($field == 'birthday' && !empty($value) && !is_numeric($value)) {
                                $value = strtotime($value);
                            }
                            $user[$field] = $value;
                        }
                    }
                }            
                if (empty(Api::getError())) {
                    if (!empty($user)) {
                        if ($this->setLoginSession($user)) {
                            //$this->Common->setFlashSuccessMessage(__('Account updated successfully'));    
                            return $this->redirect(BASE_URL . '/top');
                        }
                    }                
                } else {
                    $error = array(
                        'email' => array(
                            '1005' => __('MESSAGE_EMAIL_MUST_CONTAIN_VALID_ADDRESS'),
                            '1011' => __('MESSAGE_DUPLICATE_EMAIL')
                        )
                    );
                    $this->Common->setFlashErrorMessage(Api::getError(), $error);               
                }            
            }            
        }
        $physicals = Api::call(Configure::read('API.url_userphysicals_all'), array());
        $this->set(compact(
            'physicals'
        ));
    }
    
    function forgetpassword() {
        $this->set('title_for_layout', __d('login', 'LANG_LOGIN_FORGET_PASSWORD_TITLE'));
        $modelName = $this->Login->name;
        $model = $this->{$modelName};
        if ($this->request->is('post')) {
            $error = array(
                'is_email' => array(1011 => __('MESSAGE_EMAIL_HAS_BEEN_SENT')),
                'email' => array(1010 => __('MESSAGE_EMAIL_ALREADY_REGISTERED')),
            );
            $data = $this->getData($modelName);
            if ($model->validateForgetPassword($data)) {
                $param['email'] = $data[$modelName]['email'];
                $result = Api::call(Configure::read('API.url_users_forgetpassword'), $param);
                if (!empty($result) && !Api::getError()) {
                    $this->Common->setFlashSuccessMessage(
                        __('MESSAGE_INFO_SENT_TO_EMAIL_PLEASE_CHECK')
                    );
                    return $this->redirect(BASE_URL . '/forgetpassword');
                } else {
                    $this->Common->setFlashErrorMessage(Api::getError(), $error);
                }
            } else {
                AppLog::info("Can not update", __METHOD__, $this->data);
                $this->Common->setFlashErrorMessage($model->validationErrors);
            }
            $this->set('loginData', $data[$modelName]);
        }        
    }
    
    /**
     * Confirm code page
     */
    function confirmcode() {
        $this->set('title_for_layout', __d('login', 'LANG_LOGIN_CONFIRM_CODE_TITLE'));
        
        if ($this->request->is('post')) {
            return $this->redirect(BASE_URL . '/resetpassword');
        }
    }
    
    /**
     * Reset password page
     */
    function resetpassword($token = '') {
        $this->set('title_for_layout', __d('login', 'LANG_LOGIN_NEW_PASSWORD_TITLE'));
        if (empty($token)) {
            return $this->redirect(BASE_URL . '/forgetpassword');
        }
        $modelName = $this->Login->name;
        $model = $this->{$modelName};
        if ($this->request->is('post')) {
            $data = $this->getData($modelName);
            if ($model->validateResetPassword($data)) {
                $param['token'] = $token;
                $param['password'] = $data[$modelName]['password'];
                $result = Api::call(Configure::read('API.url_users_updatepassword'), $param);
                if (empty(Api::getError())) {
                    $this->Common->setFlashSuccessMessage(__('MESSAGE_CREATE_PASSWORD_SUCCESS'));
                    return $this->redirect(BASE_URL . '/login/email');
                } else {
                    AppLog::info("Can not update password", __METHOD__, $this->data);
                    $this->Common->setFlashErrorMessage(__('MESSAGE_CREATE_PASSWORD_NOT_SUCCESS'));
                }
            } else {
                AppLog::info("Update password fail", __METHOD__, $data);
                $this->Common->setFlashErrorMessage($model->validationErrors);
            }
            $this->set('dataPass', $data);
        } else {
            // Check valid token
            $check = Api::call(Configure::read('API.url_useractivations_check'), array(
                'token' => $token,
                'regist_type' => 'forget_password'
            ));
            if (!empty(Api::getError())) {
                $error = array(
                    'token' => array(
                        '1010' => __('Token not exist'),
                        '1021' => __('Token has already been used'),
                        '1022' => __('MESSAGE_PASSRESET_TOKEN_EXPIRED'),
                    ),
                );
                $errorMsg = $this->Common->mapError(Api::getError(), $error, '<br/>');
                if (!empty($errorMsg)) {
                    $this->Common->setFlashErrorMessage($errorMsg);
                    return $this->redirect(BASE_URL . '/forgetpassword');
                }
            }
        }
    }
    
    function active($token) {
        $error = array(
            'token' => array(1010 => __('MESSAGE_REQUEST_ALREADY_PROCESSED_BY_ANOTHER_USER')),
            'email' => array(1011 => __('MESSAGE_ACTIVE_EMAIL_ALREADY_REGISTERED'))
        );
        if (!empty($token)) {
            $param['token'] = $token;
        } else {
            $param['token'] = $this->getParam('token');
        }
        $param['unauthorize'] = true;
        $user = Api::call(Configure::read('API.url_users_registeractive'), $param);       
        if (Api::getError()) {  
            $this->Common->setFlashErrorMessage(Api::getError(), $error);
            return $this->redirect(BASE_URL . '/login/email');
        }
        if (empty($user)) {
            AppLog::warning('Active email error', __METHOD__, $param);
            $this->Common->setFlashErrorMessage(__('MESSAGE_SYSTEM_ERROR_TRY_AGAIN'));
            return $this->redirect(BASE_URL . '/login/email');
        } else {
            $this->Common->setFlashSuccessMessage(__('MESSAGE_REGISTRATION_ACTIVED'));
            if ($this->setLoginSession($user)) {
                // KienNH, 2016/02/16: Open url schema for mobile
                if ($this->isMobile()) {
                    $scheme = SCHEMES_APP . "action=regis_profile&user_id={$user['id']}&app_id={$user['app_id']}&email={$user['email']}&token={$user['token']}";
                    $this->set('scheme', $scheme);
                } else {
                    return $this->redirect(BASE_URL . '/register');
                }
            } else {
                AppLog::warning('Active email error', __METHOD__, $param);
                $this->Common->setFlashErrorMessage(__('MESSAGE_SYSTEM_ERROR_TRY_AGAIN'));
                return $this->redirect(BASE_URL . '/login/email');
            }
        }
    }
    
    /**
     * Process when user login as Guest
     */
    function guest() {
        $this->clearLoginSession();
        return $this->redirect(BASE_URL . '/top');
    }
}
