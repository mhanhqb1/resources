<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');
App::uses('AppHelper', 'View/Helper');
App::uses('AppModel', 'AppModel');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    
    /** @var object $AppUI Session infomation of user logged. */
    public $AppUI = null;
    
    /** @var object $controller Controller name. */
    public $controller = null;

    /** @var object $action Action name. */
    public $action = null;
    
    /** @var string $layout layout name . */
    public $layout = null;
    
    /** @var array $helpers Helpers use in project. */
    public $helpers = array('Html', 'Form', "Session",  "Common");
    
    /** @var array $components list components use in project */
    public $components = array(
        'Session',
        'Common',
        'Auth' => array(
            'loginRedirect' => false,
            'logoutRedirect' => false,
            'loginAction' => array(
                'controller' => 'login',
                'action' => 'index',
                'plugin' => null
            ),
            'sessionKey' => 'Auth.BmapsFront'
        ),
        'Cookie',
        'RequestHandler'
    );
    
    /** @var array $allowedActions list action can access not login. */
    public $allowedActions = array(
        'jsconstants.index',
        'lp.index',
        'lp.en',
        'lp.jp',
        'lp.es',
        'lp.thanks',
        'login.index',
        'login.email',
        'login.active',
        'login.facebook',
        'login.twitter',
        'login.twitterCallback',
        'login.forgetpassword',
        'login.confirmcode',
        'login.resetpassword',
        'top.index',        
        'top.near_by_search',        
        'top.autocomplete',
        'top.add_spot',
        'helps.index',        
        'users.recommend',
        'users.follow',
        'users.profile',        
        'places.ranking',        
        'places.recommend',        
        'places.detail',        
        'places.review',        
        'login.guest',
        'users.ranking',
        'places.reviewhistory',
    );
    
    public $_arrayLangType = array(
        'jpn' => 1, 'jp' => 1,
        'eng' => 2, 'en' => 2,
        'tha' => 3, 'th' => 3,
        'vie' => 4, 'vi' => 4,
        'spa' => 5, 'es' => 5,
    );
    
    /**
     * Constructor
     * 
     * @param $request
     * @param $response
     */
    public function __construct($request = null, $response = null) {
        parent::__construct($request, $response);
        
        // Set custom define
        $this->set('title_for_layout', DEFAULT_SITE_TITLE);
    }
    
    /**
     * Commont function called before the controller action.
     */
    public function beforeFilter() {
        // redirect https
        if ($this->request->params['controller'] != 'tests'
            && Configure::read('Config.HTTPS') === true ){
            if(isset($_SERVER['HTTP_X_FORWARDED_PROTO']) 
                && $_SERVER['HTTP_X_FORWARDED_PROTO'] == "http") {
                return $this->redirect('https://' . env('SERVER_NAME') . $this->here);
            }
            elseif (!isset($_SERVER['HTTP_X_FORWARDED_PROTO']) 
                && isset($_SERVER['SERVER_PORT']) 
                && $_SERVER['SERVER_PORT'] == 80) {
                return $this->redirect('https://' . env('SERVER_NAME') . $this->here);
            }
        }
        parent::beforeFilter();
        
        // Check and auto login using cookie
        $this->autoLoginCookie();
        
        // Set layout
        $this->_setLayout();
        
        // Set common param
        $this->controller = $this->request->params['controller'];
        $this->action = $this->request->params['action'];
        
        if ($this->isAuthorized()) {
            $this->AppUI = $this->Auth->user();
        }
        
        // Check redirect page
        if (!$this->isAuthorized() 
            && !in_array("{$this->controller}.{$this->action}", $this->allowedActions)            
            && !($this->controller == 'ajax')
        ) { 
            // KienNH, 2015/11/26: Catch controller not found to display 404 error page
            $_className = ucfirst($this->controller) . 'Controller';
            if(class_exists($_className)){
                return $this->redirect(BASE_URL);
            } else {
                throw new NotFoundException();
            }
        }
        
        // Set data for view
        $this->set('controller', $this->controller);
        $this->set('action', $this->action);
        $this->set('url', $this->request->url);
        $this->set('referer', Controller::referer());
        
        if ($this->isAuthorized()) {
            $this->set('AppUI', $this->Auth->user());
        }
        
        // Set language
        list($language, $languageType) = $this->getCurrentLanguage();
        $this->set('language', $language);
        Configure::write('Config.language', $language);
        Configure::write('Config.languageType', $languageType);
        $lpLang2Digit = $this->validateLang($language, 2);
        $this->set('lpLang2Digit', $lpLang2Digit);
        
    }
    
    /**
     * Get current language
     * @return array(language, language type)
     */
    protected function getCurrentLanguage() {
        // Get current language from request param or saved in cookie
        if (isset($this->request->query['lang'])) {
            $language = $this->request->query['lang'];
        } else {
            $language = $this->Cookie->read(COOKIE_KEY_LANGUAGE);
        }
        
        $language = $this->validateLang($language);
        
        // Store and return
        if ($this->controller != 'lp') {
            $this->Cookie->write(COOKIE_KEY_LANGUAGE, $language);
        }
        
        return array(
            $language,
            $this->_arrayLangType[$language]
        );
    }
    
    /**
     * Check valid language
     * @param string $language
     * @param int return 2 or 3 digit
     * @return string
     */
    protected function validateLang($language, $type = 3) {
        if (!isset($this->_arrayLangType[$language])) {
            $language = $type == 3 ? 'jpn' : 'jp';// Default language
        } else {
            switch ($language) {
                case 'jp':
                case 'jpn':
                    $language = $type == 3 ? 'jpn' : 'jp';
                    break;
                case 'en':
                case 'eng':
                    $language = $type == 3 ? 'eng' : 'en';
                    break;
                case 'th':
                case 'tha':
                    $language = $type == 3 ? 'tha' : 'th';
                    break;
                case 'vi':
                case 'vie':
                    $language = $type == 3 ? 'vie' : 'vi';
                    break;
                case 'es':
                case 'spa':
                    $language = $type == 3 ? 'spa' : 'es';
                    break;
                default:
                    $language = $type == 3 ? 'jpn' : 'jp';
                    break;
            }
        }
        
        return $language;
    }


    /**
     * Common function check user is Authorized..
     * 
     * @return boolean  If true is authorize, and false is unauthorize.
     */
    public function isAuthorized() {
        if (!isset($this->Auth) || !$this->Auth->loggedIn()) {
            return FALSE;
        }
        
        return TRUE;
    }
    
    /**
     * Commont function get all data of view.
     * 
     * @param array $modelName model name to get data.
     * @return array Data of view array($modelName => $data)
     */
    public function getData($modelName) {
        $data = array();
        foreach ($this->data[$modelName] as $field => $value) {
            $data[$field] = $value;
        }
        $data['model_name'] = $modelName;
        return array($modelName => $data);
    }
    
    /**
     * Commont function set layout for view.
     */
    private function _setLayout() {
        $this->layout = 'bmaps';        
        if ($this->name == 'CakeError') {
            $this->layout = 'error';
        }
        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
        }
    }
    
    /**
     * Check and auto login using cookie
     */
    protected function autoLoginCookie() {
        $this->Cookie->httpOnly = true;
        
        // Not logged-in and cookie stored
        if (!$this->isAuthorized() && $this->Cookie->read(COOKIE_KEY_REMEMBER)) {
            $cookie = $this->Cookie->read(COOKIE_KEY_REMEMBER);
            $this->Cookie->delete(COOKIE_KEY_REMEMBER);
            
            if (!empty($cookie['type'])) {
                if ($cookie['type'] == 'email') {
                    $this->loginByEmail($cookie);
                } else if ($cookie['type'] == 'facebook') {
                    
                } else if ($cookie['type'] == 'twitter') {
                    
                }
            }
        }
    }
    
    /**
     * Call API to login by email
     * 
     * @param array $loginData
     * @param string | array $error
     * @return boolean
     */
    protected function loginByEmail($loginData, &$error = '') {
        // Build params for call API
        $paramApi = array(
            'email' => !empty($loginData['email']) ? $loginData['email'] : '',
            'password' => !empty($loginData['password']) ? $loginData['password'] : ''
        );
        $loginUrl = Configure::read('API.url_users_login');

        // Call API
        $user = Api::call($loginUrl, $paramApi);

        // Check result
        $check = !Api::hasError();
        if ($check) {
            // Set Session
            $check = $this->setLoginSession($user, $paramApi['email']);
            if ($check) {
                return TRUE;
            } else {
                $error = __d('login', 'LANG_LOGIN_FAIL');
            }
        } else {
            $error = Api::getError();
        }
        
        return FALSE;
    }

    /**
     * 
     * @param array $loginData
     * @param string $error
     * @return boolean
     */
    protected function loginByFacebook($loginData, &$error = '') {
        // Build params for call API
        $paramApi = $loginData;
        $loginUrl = Configure::read('API.url_users_login_facebook');
        
        // Call API
        $user = Api::call($loginUrl, $paramApi);
        
        // Check result
        $check = !Api::hasError();
        if ($check) {
            // Set Session
            $check = $this->setLoginSession($user);
            if ($check) {
                return TRUE;
            } else {
                $error = __d('login', 'LANG_LOGIN_FAIL');
            }
        } else {
            // Parse error
            $arrayMessage = Api::getError();
            
            if (is_array($arrayMessage)) {
                $errors = array();
                
                foreach ($arrayMessage as $message) {
                    if (empty($message)) {
                        continue;
                    }
                    if (is_array($message)) {
                        foreach ($message as $value) {
                            $errors[] = $value;
                        }
                    } else {
                        $errors[] = $message;
                    }
                }

                $error = implode("\n", $errors);
            } else {
                $error = $arrayMessage;
            }
        }
        
        return FALSE;
    }
    
    /**
     * Call API to login by twitter
     * 
     * @param string $oauth_token
     * @param string $oauth_token_secret
     * @param string $error
     * @return boolean
     */
    protected function loginByTwitter($oauth_token, $oauth_token_secret, &$error = '') {
        // Build params for call API
        $paramApi = array(
            'oauth_token' => $oauth_token,
            'oauth_token_secret' => $oauth_token_secret
        );
        $loginUrl = Configure::read('API.url_users_login_twitter');
        
        // Call API
        $user = Api::call($loginUrl, $paramApi);
        
        // Check result
        $check = !Api::hasError();
        if ($check) {
            // Set Session
            $check = $this->setLoginSession($user);
            if ($check) {
                return TRUE;
            } else {
                $error = __d('login', 'LANG_LOGIN_FAIL');
            }
        } else {
            $error = Api::getError();
        }
        
        return FALSE;
    }

        /**
     * Set session after call API login
     * 
     * @param array $user
     * @param string $defaultDisplayName
     * @return boolean
     */
    protected function setLoginSession($user, $defaultDisplayName = '') {
        if (empty($user)) {
            return FALSE;
        }
        
        // Set Display name
        if (!empty($user['name'])) {
            $user['display_name'] = $user['name'];
        } else if (!empty($user['email'])) {
            $user['display_name'] = $user['email'];
        } else {
            $user['display_name'] = $defaultDisplayName;
        }
        
        // Clear old info
        $this->clearLoginSession();

        $user = json_decode(json_encode($user), FALSE);
        $this->AppUI = $user;

        if ($this->Auth->login($user)) {
            // Login sussess
            return TRUE;
        }
        
        return FALSE;
    }
    
    /**
     * Commont function to get params of actions in controller.
     *
     * @param array $default List parameter name. Default is array().
     *
     * @return array
     */
    public function getParams($default = array())
    {
        $params = $this->request->query;
        if (!empty($default)) {
            foreach ($default as $paramName => $paramValue) {
                if (!isset($params[$paramName])) {
                    $params[$paramName] = $paramValue;
                }
            }
        }
        return $params;
    }

    /**
     * Commont function to set params to action of controller.
     *
     * @param array $params List key-value of parameter. Default is array().
     *
     * @return void
     */
    public function setParams($params = array())
    {
        if (!empty($params)) {
            foreach ($params as $name => $value) {
                $this->request->query[$name] = $value;
            }
        }
    }

    /**
     * Commont function to get value of param by parameter name.
     *
     * @param string $name name of parameter to need get value.
     * @param string $defaultValue Value default if not has paramter with name $name.
     *
     * @return string
     */
    public function getParam($name, $defaultValue = null)
    {
        return isset($this->request->query[$name]) ? $this->request->query[$name] : $defaultValue;
    }

    /**
     * Commont function to set value of param by parameter name.
     *
     * @param string $name name of parameter to need get value.
     * @param string $value Value default if not set.
     *
     * @return string
     */
    public function setParam($name, $value = null)
    {
        $this->request->addParams(array($name => $value));
    }
    
    /**
     * Clear session of user logged-in
     */
    public function clearLoginSession() {
        // Backup language
        $language = $this->Cookie->read(COOKIE_KEY_LANGUAGE);
        
        // Clear session and cookie
        $this->Auth->logout();
        $this->Session->destroy();
        $this->Cookie->delete(COOKIE_KEY_REMEMBER);
        $this->AppUI = null;
        $this->Session->id();// Re-new session
        
        // Restore language
        $this->Cookie->write(COOKIE_KEY_LANGUAGE, $language);
        
    }
    
    public function isMobile() {
        return $this->RequestHandler->isMobile();
    }
    
    /**
     * Get language for Landing page
     * @param string $msg
     * @param string $lang
     * @param array $args
     * @return string
     */
    function getlanguageLp($msg, $lang = '', $args = null) {
        $arrLangs = array('jpn', 'eng', 'tha', 'vie', 'spa');
        if (empty($lang) || !in_array($lang, $arrLangs)) {
            $lang = 'jpn';
        }
        
        if (!$msg) {
            return null;
        }
        
        App::uses('I18n', 'I18n');
        $translated = I18n::translate($msg, null, 'landing', 6 /*LC_MESSAGES*/, null, $lang);
        $arguments = func_get_args();
        return I18n::insertArgs($translated, array_slice($arguments, 2));
    }
    
}
