<?php

/* 
 * Description : Class contain methods used for Ajax request
 * User        : KienNH
 * Date created: 2015/10/29
 */

App::uses('CakeEmail', 'Network/Email');

class AjaxController extends AppController {
    
    /**
     * Load library
     */
    function beforeFilter () {
        parent::beforeFilter();
        $this->Auth->allow();
        $this->layout = 'ajax';
    }
    
    /**
     * Load sub categories
     */
    function subcategories() {
        $param = $this->getParams();
        if (!empty($param['category_id'])) {           
            $param['category_type_id'] = $param['category_id'];
            $subcategories = Api::call(Configure::read('API.url_placesubcategories_all'), $param, false, array());
            $this->set(compact(         
                'subcategories'
            ));
        }
    }
    
     /**
     * Want to visit spot
     */
    function wanttovisit() {
        $id = $this->getParam('id', 0);
        $google_place_id = $this->getParam('google_place_id', '');
        $disable = $this->getParam('disable', 0);
        if ($this->request->is('ajax') && (!empty($id) || !empty($google_place_id))) {
            $param['place_id'] = $id;
            $param['google_place_id'] = $google_place_id;
            if ($disable == 1) {
                $param['remove'] = 1;
            }
            $ok = Api::call(Configure::read('API.url_places_wanttovisit'), $param);
            if ($ok) {
                // KienNH 2016/02/26 begin
                $place_detail = null;
                $param = $this->getParams(array(
                    'id' => $id,
                ));
                $place = Api::call(Configure::read('API.url_places_detail'), $param, false, array());
                if ((empty($place['id']) && empty($place['google_place_id'])) || !empty(Api::getError())) {
                    // Error
                } else {
                    $view = new View($this, false);
                    $place_detail = array(
                        'id' => !empty($place['id']) ? $place['id'] : '0',
                        'google_place_id' => !empty($place['google_place_id']) ? $place['google_place_id'] : '0',
                        'html' => $view->element('left_spot_item', array(
                            'i' => 0,
                            'place' => $place
                        ))
                    );
                }
                // KienNH end
                
                $result = array(
                    'status' => 'ok',
                    'update_place_detail' => $place_detail
                );                
            }            
        } else {
            $result = array(
                'status' => 'fail'
            );
        }
        echo json_encode($result);
        exit;
    }
    
     /**
     * Like/Unlike review
     */
    function likereview() {
        $id = $this->getParam('id', 0);
        $disable = $this->getParam('disable', 0);
        if ($this->request->is('ajax') && !empty($id)) {
            if ($disable == 0) {
                $ok = Api::call(Configure::read('API.url_placereviewlikes_add'), array(
                    'place_review_id' => $id
                ));
            } else {
                $ok = Api::call(Configure::read('API.url_placereviewlikes_disable'), array(
                    'place_review_id' => $id,
                    'disable' => 1,
                ));
            }
            if ($ok) {
                $result = array(
                    'status' => 'ok'
                );
                echo json_encode($result);
            }
            exit;
        }
    }
    
    /**
     * Follow/Unfollow user
     */
    function followuser() {
        $id = $this->getParam('id', 0);
        $disable = $this->getParam('disable', 0);
        if ($this->request->is('ajax') && !empty($id)) {
            if ($disable == 0) {
                $ok = Api::call(Configure::read('API.url_followusers_add'), array(
                    'follow_user_id' => $id
                ));
            } else {
                $ok = Api::call(Configure::read('API.url_followusers_disable'), array(
                    'follow_user_id' => $id,
                    'disable' => 1,
                ));
            }
            if ($ok) {
                $result = array(
                    'status' => 'ok'
                );
                echo json_encode($result);
            }
            exit;
        }
    }
    
    /**
     * Temporary function for saving Team for current user
     */
    function tmpUpdateTeam() {
        header('Content-Type: application/json');
        $url = Configure::read('API.url_users_updateteam');
        $param = array(
            'team_id' => $this->data['team_id']
        );
        $id = Api::call($url, $param);  
        if (empty(Api::getError())) {
            $result = array(
                'status' => 200,
                'team_id' => $id,
                'team_name' => !empty($this->data['name']) ? $this->data['name'] : ''
            );
            $this->AppUI->team_id = $id;
            $this->AppUI->team_name = !empty($this->data['name']) ? $this->data['name'] : '';
            $this->Auth->login($this->AppUI); 
        } else {
            $error = array( 
                'name' => array(
                    '1010' => __('MESSAGE_NOT_EXIST_NAME'),
                    '1011' => __('MESSAGE_DUPLICATE_NAME'),
                ),
                'team_id' => array(
                    '1011' => __('MESSAGE_NOT_CHANGE_TEAM'),
                )
            );
            $errorMsg = $this->Common->mapError(Api::getError(), $error, '\n');   
            $result = array(
                'status' => 400,
                'message' => $errorMsg
            );
        }        
        echo json_encode($result);
        exit;
    }
    
    /**
     * Temporary function for creating new Team for current user
     */
    function tmpCreateTeam() {
        header('Content-Type: application/json');
        $url = Configure::read('API.url_users_updateteam');
        $param = array(
            'name' => $this->data['name'],
            'section_id' => $this->data['section']
        );
        $id = Api::call($url, $param);  
        if (empty(Api::getError())) {
            $result = array(
                'status' => 200,
                'team_id' => $id,
                'team_name' => $param['name']
            );
            $this->AppUI->team_id = $id;
            $this->AppUI->team_name = $param['name'];
            $this->Auth->login($this->AppUI);   
        } else {
            $errorMsg = '';
            $errors = Api::getError();
            $error = array(                
                'name' => array(
                    '1011' => __('MESSAGE_DUPLICATE_NAME'),
                ),                
            );
            $errorMsg = $this->Common->mapError(Api::getError(), $error, '\n');   
            $result = array(
                'status' => 400,
                'message' => $errorMsg,
            );
        }        
        echo json_encode($result);
        exit;
    }
    
    /**
     * Seach team by name
     */
    function searchTeam() {
        $q = !empty($this->request->query['input']) ? $this->request->query['input'] : '';
        $url = Configure::read('API.url_teams_all');
        $params = array(
            'name' => $q,
            'limit' => 5
        );
        $result = Api::call($url, $params);        
        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    }
    
    /**
     * Team list
     */
    function team() {
        if (!$this->request->is('ajax')) {
            exit;
        }
        $param = $this->getParams(array(
            'page' => 1, 
            'limit' => Configure::read('Config.pageSize'),
            'disable' => 0,
        ));   
        $result = Api::call(Configure::read('API.url_teams_list'), $param, false, array());
        $limit = !empty($param['limit']) ? $param['limit'] : 10;
        $total = !empty($result['total']) ? $result['total'] : 0;
        $data = !empty($result['data']) ? $result['data'] : array();
        $this->set(compact(
            'limit',
            'total',
            'data'
        ));
        if ($this->request->is('ajax')) {
            $this->layout = "ajax";           
        }
    }
    
    /**
     * Send contact mail from landing page
     * @param string $lang : jp, en
     */
    function sendLdContactMail() {
        if (!$this->request->is('ajax')) {
            exit;
        }
        
        header('Content-Type: application/json');
        $result = array(
            'success' => 1,
            'message' => ''
        );
        $param = $this->data['LP'];
        $lang = $this->validateLang($param['lang']);
        
        $check = Api::call(Configure::read('API.url_emails_contact'), array(
            'name'          => !empty($param['name'])       ? $param['name']       : '',
            'name_kana'     => !empty($param['name_kana'])  ? $param['name_kana']  : '',
            'group_name'    => !empty($param['group_name']) ? $param['group_name'] : '',
            'email'         => !empty($param['email'])      ? $param['email']      : '',
            'tel'           => !empty($param['tel'])        ? $param['tel']        : '',
            'comments'      => !empty($param['comments'])   ? $param['comments']   : '',
            'language_type' => $this->_arrayLangType[$lang]
        ));
        
        if ($check && empty(Api::getError())) {
            $this->Session->write('landing.language.submit', $lang);
        } else {
            $result['success'] = 0;
            $result['message'] = $this->getlanguageLp('LANDING_MAIL_FAILED', $lang);
            $result['debug'] = Api::getError();
        }
        
        echo json_encode($result);
        exit;
    }
    
    /**
     * Show spot report
     * @param integer $placeId
     */
    function spot_report($placeId = '') {
        if (!$this->request->is('ajax') || empty($placeId)) {
            exit;
        }
        
        $this->layout = "ajax";
        $lang = Configure::read('Config.language');
        $violation_reports = array();
        
        // Load config
        $data = Api::call(Configure::read('API.url_mobile_config'), array());
        if (!empty($data['violation_reports'])) {
            foreach ($data['violation_reports'] as $key => $value) {
                if (($lang == 'jpn' && $key == 'jp') ||
                    ($lang == 'eng' && $key == 'en') ||
                    ($lang == 'tha' && $key == 'th') ||
                    ($lang == 'vie' && $key == 'vi') ||
                    ($lang == 'spa' && $key == 'es')) {
                    $violation_reports = $value;
                    break;
                }
            }
        }
        
        $this->set(compact(
            'violation_reports',
            'placeId'
        ));
    }
    
    /**
     * Send report
     */
    function send_spot_report() {
        // Init
        header('Content-Type: application/json');
        $result = array(
            'status' => 200,
            'message' => ''
        );
        
        // Check params
        if (!isset($this->data['place_id']) || !isset($this->data['report_id'])) {
            $result['status'] = 400;
            $result['message'] = 'Missing place_id or report_id';
        } else {
            // Send
            $url = Configure::read('API.url_violationreports_add');
            $param = array(
                'place_id' => $this->data['place_id'],
                'report_id' => $this->data['report_id'],
                'report_comment' => !empty($this->data['report_comment']) ? $this->data['report_comment'] : ''
            );
            $check = Api::call($url, $param);
            if (!empty(Api::getError())) {
                $result['status'] = 400;
                $result['message'] = Api::getError();
            }
        }
        
        // Response
        echo json_encode($result);
        exit;
    }
    
    /**
     * Delete Spot
     */
    function delete_spot() {
        // Init
        header('Content-Type: application/json');
        $result = array(
            'status' => 200,
            'message' => ''
        );
        
        // Check params
        if (!isset($this->data['place_id'])) {
            $result['status'] = 400;
            $result['message'] = 'Missing place_id';
        } else {
            // Send
            $url = Configure::read('API.url_places_disable');
            $param = array(
                'id' => $this->data['place_id'],
                'disable' => 1
            );
            $check = Api::call($url, $param);
            if (!empty(Api::getError())) {
                $result['status'] = 400;
                $result['message'] = Api::getError();
            }
        }
        
        // Response
        echo json_encode($result);
        exit;
    }
    
}
