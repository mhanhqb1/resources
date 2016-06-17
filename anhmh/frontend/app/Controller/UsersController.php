<?php

App::uses('AppController', 'Controller');

/* 
 * Description : Class contain methods used for User screen
 * User        : KienNH
 * Date created: 2015/11/04
 */

class UsersController extends AppController {
    
    /**
     * Load library
     */
    function beforeFilter () {
        parent::beforeFilter();
        $this->Auth->allow(array(
            'recommend',
            'profile',
            'follow',
            'ranking'
        )); 
    }
    
    /**
     * Recommend page
     */
    function recommend() {
        $param = $this->getParams(array(
                'page' => 1, 
                'limit' => Configure::read('Config.pageSize'),
                'disable' => 0,
            )
        );        
        $users = Api::call(Configure::read('API.url_users_recommend'), $param, false, array());
        $this->set(compact(
            'users'
        ));
    }
    
    /**
     * Recommend page
     */
    function profile($userId = 0) {        
        $param = $this->getParams(array(
                'get_place_pins' => 1, 
                'get_place_reviews' => 1, 
                'get_place_images' => 1, 
                //'page' => 1, 
                //'limit' => Configure::read('Config.pageSize'),              
            )
        );
        if (!empty($this->AppUI->id) && empty($userId)) {
            $param['user_id'] = $this->AppUI->id;
        } elseif (!empty($userId)) {
            $param['user_id'] = $userId;
        } else {
            return false;
        }
        $user = Api::call(Configure::read('API.url_users_profile'), $param, false, array());
        $this->set(compact(
            'user'
        ));          
    }
    
    /**
     * Edit profile page
     */
    function editProfile() {
        if ($this->request->is('post') && isset($this->data['User'])) {
            $data = $this->data['User'];
            if (!empty($_FILES['data'])) {
                foreach ($_FILES['data']['name']['User'] as $fieldName => $fieldValue) {
                    if ($_FILES['data']['error']['User'][$fieldName] === 0) {
                        $filetype = $_FILES['data']['type']['User'][$fieldName];
                        $filename = $_FILES['data']['name']['User'][$fieldName];
                        $filedata = $_FILES['data']['tmp_name']['User'][$fieldName];
                        $data[$fieldName] = new CurlFile($filedata, $filetype, $filename);
                    } 
                }
            }         
            $user = Api::call(Configure::read('API.url_users_updateprofile'), $data);
            if (!empty($user)) {
                $user['token'] = $this->AppUI->token;                
            }
            if (empty(Api::getError())) {
                if (!empty($user)) {
                    if ($this->setLoginSession($user)) {
                        $this->Common->setFlashSuccessMessage(__('MESSAGE_PROFILE_UPDATED_SUCCESS'));    
                        return $this->redirect(
                            Router::url(array(
                                'controller' => 'users', 
                                'action' => 'editProfile'),
                                true
                            )
                        );
                    }
                }                
            } else {
                $error = array(
                    'email' => array(
                        '1005' => __('MESSAGE_EMAIL_MUST_CONTAIN_VALID_ADDRESS'),
                        '1011' => __('MESSAGE_DUPLICATE_EMAIL')
                    ),
                    'image_path' => array(
                        '101' => __('MESSAGE_ERROR_UPLOAD_IMAGE_SIZE', Configure::read('Config.uploadSize'))
                    ),
                    'cover_image_path' => array(
                        '101' => __('MESSAGE_ERROR_UPLOAD_IMAGE_SIZE', Configure::read('Config.uploadSize'))
                    )
                );
                $this->Common->setFlashErrorMessage(Api::getError(), $error);               
            } 
        }
    }
    
    /**
     * Concat folowme and ifollow to 1 page
     * @param integer $userId
     * @param string $view me/i
     */
    function follow($userId = 0, $view = 'me') {
        $view = !in_array($view, array('me', 'i')) ? 'me' : $view;
        $classActiveMe = $view == 'me' ? 'active' : '';
        $classActiveI  = $view == 'i'  ? 'active' : '';
        
        $param = $this->getParams(array(
                'user_id' => !empty($userId) ? $userId : $this->AppUI->id,
                'page' => 1,
                'limit' => 10000,
                'disable' => 0,
            )
        );
        
        // me
        $result = Api::call(Configure::read('API.url_followusers_followme'), $param, false, array());
        $dataMe = !empty($result['data']) ? $result['data'] : array();
        
        // i
        $result = Api::call(Configure::read('API.url_followusers_ifollow'), $param, false, array());
        $dataI = !empty($result['data']) ? $result['data'] : array();
        
        $this->set(compact(
            'dataMe',
            'dataI',
            'classActiveMe',
            'classActiveI'
        ));
    }
    
    /**
     * Update user's profile
     */
    public function register($update = '') {
        if ($this->request->is('post')) {
            $error = '';
            $data = $this->data['Register'];
            $ok = $this->User->validateProfile($this->data, $error);
            if ((!empty($data['zipcode1']) && empty($data['zipcode2'])) ||
                (empty($data['zipcode1']) && !empty($data['zipcode2']))) {
                $ok = FALSE;
                $this->Common->setFlashErrorMessage(__('PRF_ERROR_MESSAGE_FORMAT_ZIPCODE'));
            }
            if ($ok) {
                if (!empty($data['zipcode1']) && !empty($data['zipcode2'])) {
                    $data['zipcode'] = $data['zipcode1'] . '-' . $data['zipcode2'];
                } else {
                    $data['zipcode'] = '';
                }
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
            } else {
                // Show first error
                foreach ($error as $value) {
                    $this->Common->setFlashErrorMessage($value);
                    break;
                }
            }
        } else {
            $zipcode1 = $zipcode2 = '';
            if (!empty($this->AppUI->zipcode)) {
                list($zipcode1, $zipcode2) = explode('-', $this->AppUI->zipcode);
            }
            
            $data = array(
                'name' => $this->AppUI->name,
                'sex_id' => $this->AppUI->sex_id,
                'birthday' => !empty($this->AppUI->birthday) ? date('Y-m-d', $this->AppUI->birthday) : '',
                'zipcode1' => $zipcode1,
                'zipcode2' => $zipcode2,
                'user_physical_type_id' => $this->AppUI->user_physical_type_id,
                'is_smoker' => $this->AppUI->is_smoker
            );
        }
        
        // Set previous data for View
        $this->set('registerData', $data);
        if (!empty($update)) {
            $this->set('label_title_page', __('LABEL_CHANGE_REGISTER_PROFILE_INFO'));
            $this->set('label_button_save', __('LABEL_DO_UPDATE'));
        } else {
            $this->layout = 'bmaps_base';
            $this->set('label_title_page', __('LABEL_REGISTER_PROFILE_INFO'));
            $this->set('label_button_save', __('LABEL_NEXT'));
        }
        
        $physicals = Api::call(Configure::read('API.url_userphysicals_all'), array());
        $this->set(compact(
            'physicals'
        ));
        $this->view = 'register';
    }
    
    public function updateinfo() {
        $this->register(1);
    }
    
    /**
     * Change password
     */
    public function changepassword() {
        if ($this->request->is('post')) {
            $error = '';
            $data = $this->data['ChangePassword'];
            $ok = $this->User->validateChangePassword($this->data, $error);
            if ($ok) {
                $data['id'] = $this->AppUI->id;
                $data['regist_type'] = 'user';
                $data['email'] = $this->AppUI->email;
                $check = Api::call(Configure::read('API.url_users_changepassword'), $data);
                if ($check && empty(Api::getError())) {
                    return $this->redirect(
                        Router::url(array(
                            'controller' => 'top',
                            'action' => 'index'), true
                        )
                    );
                } else {
                    $this->Common->setFlashErrorMessage(__('MESSAGE_INVALID_PASSWORD_TRY_AGAIN'));
                }
            } else {
                // Show first error
                foreach ($error as $value) {
                    $this->Common->setFlashErrorMessage($value);
                    break;
                }
            }
            $this->set('params', $data);
        }
    }
    
    /**
     * Get coin history of user
     * @param integer $userId
     */
    public function coin($userId = 0, $type = '') {
        // Valid User Id
        $validUser = true;
        if (empty($userId)) {
            if (empty($this->AppUI->id)) {
                $validUser = false;
            }
        } else if (!is_numeric($userId)) {
            $validUser = false;
        }
        if (!$validUser) {
            return $this->redirect(BASE_URL . '/top');
        }
        
        // Valid Type
        $coinType = array('get', 'used');
        if (empty($type)) {
            $type = $coinType[0]; // Default "get"
        } else if (!in_array($type, $coinType)) {
            return $this->redirect(BASE_URL . '/users/coin/' . $userId);
        }
        
        // Check page
        $page = 1;
        $param = $this->getParams();
        if (!empty($param['page'])) {
            if (!is_numeric($param['page'])) {
                return $this->redirect(BASE_URL . '/users/coin/' . $userId);
            }
            $page = $param['page'];
        }
        
        // Get data from API
        $coinHistory = Api::call(Configure::read('API.url_coins_history'), array(
            'user_id' => $userId,
            'type' => $type,
            'page' => $page
        ));
        
        $coinUser = $coinHistory['user'];
        if ($type == 'get') {
            $total = !empty($coinHistory['get_coin']['total']) ? $coinHistory['get_coin']['total'] : 0;
            $data = !empty($coinHistory['get_coin']['data']) ? $coinHistory['get_coin']['data'] : array();
        } else {
            $total = !empty($coinHistory['used_coin']['total']) ? $coinHistory['used_coin']['total'] : 0;
            $data = !empty($coinHistory['used_coin']['data']) ? $coinHistory['used_coin']['data'] : array();
        }
        
        // Stop loading
        if ($this->request->is('ajax') && empty($data)) {
            exit;
        }
        
        $pointType = array(
            1 => __('LABEL_REVIEW'),
            2 => __('LABEL_ADD_SPOT')
        );
        
        $this->set(compact(
            'type',
            'total',
            'data',
            'coinUser',
            'pointType'
        ));
    }
    
    /**
     * Get user coin ranking
     */
    public function ranking() {
        if (!$this->request->is('ajax')) {
            exit;
        }
        $this->layout = "ajax";
        
        // Get data from API
        $coinRankings = Api::call(Configure::read('API.url_coins_ranking'), array());
        $coinUser = !empty($coinRankings['user']) ? $coinRankings['user'] : array();
        $rankings = !empty($coinRankings['ranking']) ? $coinRankings['ranking'] : array();
        $this->set(compact(
            'coinUser',
            'rankings'
        ));
    }
    
}
