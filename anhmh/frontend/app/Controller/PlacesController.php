<?php

/* 
 * Description : Class contain methods used for Place screen
 * User        : KienNH
 * Date created: 2015/11/05
 */

class PlacesController extends AppController {
    
    /**
     * Load library
     */
    function beforeFilter () {
        parent::beforeFilter();
        $this->Auth->allow(array(
            'ranking',
            'recommend',
            'detail',
            'review',
            'reviewhistory'
        ));
    }
    
    /**
     * Top page
     */
    function index() {        
        $placefavorites = Api::call(
            Configure::read('API.url_placefavorites_top'), 
            array(
                'limit' => 15,
            )
        );  
        $this->set(compact(
            'placefavorites'
        ));
    }
    
    /**
     * Recommend page
     */
    function recommend() {
        if (!$this->request->is('ajax')) {
            exit;
        } 
        $param = $this->getParams(array(
            'page' => 1, 
            'limit' => Configure::read('Config.pageSize'),
            'disable' => 0,
        ));   
        $result = Api::call(Configure::read('API.url_places_recommend'), $param, false, array());
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
     * Recommend page
     */
    function ranking() {
        if (!$this->request->is('ajax')) {
            exit;
        } 
        $param = $this->getParams(array(           
            'page' => 1, 
            'limit' => 10,
            'disable' => 0,
        )); 
        if ($param['tab'] == 1) {
            $param['ranking_by_point'] = 1;
        }
        $result = Api::call(Configure::read('API.url_places_ranking'), $param, false, array());
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
     * Detail page
     */
    function detail($id) {
        if (!$this->request->is('ajax')) {
            exit;
        }         
        $param = $this->getParams(array(
            'id' => $id,
            'get_place_categories' => 1,
            'get_place_images' => 1,
            'get_place_reviews' => 1,
            'get_share_url' => 0,
            'get_my_review' => !empty($this->AppUI->id) ? 1 : 0
        ));
        $place = Api::call(Configure::read('API.url_places_detail'), $param, false, array());
        if ((empty($place['id']) && empty($place['google_place_id'])) || !empty(Api::getError())) {
            AppLog::warning("Error:", __METHOD__, Api::getError());
            exit;
        }
        $this->set(compact(         
            'categories',
            'place',
            'param'
        ));        
    }
        
    /**
     * Save page
     */
    function save() {
        if (!$this->request->is('ajax')) {
            exit;
        }
        $param = $this->getParams();
        $data = $this->data['Spot'];
        $data['id'] = $param['id'];
        $data['google_place_id'] = !empty($param['google_place_id']) ? $param['google_place_id'] : 0;
        foreach(Configure::read('Config.placeFacilityIcon') as $key => $icon) {
            if (isset($data['facility']) && in_array($key, $data['facility'])) {
                $data[$key] = 1;
            } else {
                $data[$key] = 0;
            }
        }
        unset($data['facility']);
        $data['return_place_detail'] = 1;// KienNH, 2016/02/26
        $place = Api::call(Configure::read('API.url_places_addupdate'), $data, false, array());
        if (empty(Api::getError())) {
            // KienNH, 2016/02/26 begin
            $place_detail = '';
            if (!empty($place)) {
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
                'update_place_detail' => $place_detail,// KienNH, 2016/02/26
            );            
        } else {
            $result = array(
                'status' => 'fail'                
            );
        }
        echo json_encode($result);
        exit;        
    }    
       
    function postreview() {        
        $data = $this->data; 
        if (!empty($_FILES['data'])) {
            foreach ($_FILES['data']['name'] as $fieldName => $fieldValue) {
                if ($_FILES['data']['error'][$fieldName] === 0) {
                    $filetype = $_FILES['data']['type'][$fieldName];
                    $filename = $_FILES['data']['name'][$fieldName];
                    $filedata = $_FILES['data']['tmp_name'][$fieldName];
                    $data[$fieldName] = new CurlFile($filedata, $filetype, $filename);
                }
            }
        }
        $data['get_place_detail'] = 1;
        foreach(Configure::read('Config.placeFacilityIcon') as $key => $icon) {
            if (isset($data['facility']) && in_array($key, $data['facility'])) {
                $data[$key] = 1;
            } else {
                $data[$key] = 0;
            }
        }
        unset($data['facility']);
        $place = Api::call(Configure::read('API.url_placereviews_addupdate'), $data, false, array());
        //AppLog::info('TEST', __METHOD__, $place);
        if (!empty($place) && empty(Api::getError())) {
            $view = new View($this, false);
            $place_detail = array(
                'id' => !empty($place['id']) ? $place['id'] : '0',
                'google_place_id' => !empty($place['google_place_id']) ? $place['google_place_id'] : '0',
                'html' => $view->element('left_spot_item', array(
                    'i' => 0,
                    'place' => $place
                ))
            );
            echo "<script>
                window.parent.callbackReviewSubmit('{$place['place_id']}','{$place['google_place_id']}'," . json_encode($place_detail) . ");                
            </script>";             
        } else {
            $error = Api::getError();
            if (isset($error['image_path1']) || isset($error['image_path2'])) {
                $errorMsg = __('MESSAGE_ERROR_UPLOAD_IMAGE_SIZE', Configure::read('Config.uploadSize'));
            } else if (isset ($error['duplicate_review'])) {
                $errorMsg = __('MESSAGE_1USER_1REVIEW');
            } else if (isset ($error['review_point_and_comment_and_images_and_entrance_steps_and_facilities'])) {
                $errorMsg = __('MESSAGE_EMPTY_SPOT_REVIEW');
            }
            if (isset($errorMsg)) {
                echo "<script>
                    window.parent.alert('{$errorMsg}');
                </script>"; 
            }
        }
        exit;
    }
    
    function review($reviewId = 0) {        
        if (!$this->request->is('ajax')) {            
            exit;
        }
        // submit comment
        if ($this->request->is('post') 
            && !empty($this->data['place_review_id'])
            && !empty($this->data['comment'])) {
            $data = $this->data;
            Api::call(Configure::read('API.url_placereviewcomments_addupdate'), $data, false);
            if (empty(Api::getError())) {
                $result = array(
                    'status' => 'ok',                    
                    'review_id' => $this->data['place_review_id'],
                    'date' => date('Y-m-d'),
                    'comment' => $this->data['comment'],                    
                );      
                echo json_encode($result);
            }            
            exit;
        }
        $param = $this->getParams(array(           
            'get_comment' => 1,
            'id' => $reviewId
        ));
        $review = Api::call(Configure::read('API.url_placereviews_detail'), $param, false, array());
        $this->set(compact(          
            'review'
        ));
        if ($this->request->is('ajax')) {
            $this->layout = "ajax";
        }
    }
    
    /**
     * Get place review history
     * @param int $place_id
     * @param int $user_id
     */
    function reviewhistory($place_id = '', $user_id = '') {
        if (!$this->request->is('ajax')) {            
            exit;
        }
        
        $history = Api::call(Configure::read('API.url_placereviews_history'), array(
            'place_id' => $place_id,
            'user_id' => $user_id
        ));
        
        $this->layout = "ajax";
        $this->set('history', $history);
    }
    
}
