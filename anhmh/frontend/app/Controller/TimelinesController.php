<?php

/* 
 * Description : Class contain methods used for Timeline screen
 * User        : KienNH
 * Date created: 2015/11/04
 */

class TimelinesController extends AppController {
    
    /**
     * Load library
     */
    function beforeFilter () {
        parent::beforeFilter();
    }
    
    /**
     * Top page
     */
    function index($page = 1) {
        $param = $this->getParams(array(
                'page' => $page, 
                'limit' => 3,
                'disable' => 0,
            )
        );
        
        $isEmptyZipcode = 0;
        $limit = !empty($param['limit']) ? $param['limit'] : 10;
        
        $type = !empty($param['t']) ? $param['t'] : '';
        if ($type == 'follow') {
            $param['get_follow'] = 1;
        } else if ($type == 'near') {
            $param['get_near_place'] = 1;
            if (empty($this->AppUI->zipcode)) {
                $isEmptyZipcode = 1;
            }
        } else {
            // All
        }
        
        if (!$this->request->is('ajax') && $page > 1) {
            $param['page'] = 1;
            $param['limit'] = $param['limit'] * $page;
        }
        
        if (!$isEmptyZipcode) {
            $result = Api::call(Configure::read('API.url_users_timeline'), $param, false, array(0, array()));
            $total = !empty($result['total']) ? $result['total'] : 0;
            $data = !empty($result['data']) ? $result['data'] : array();
        } else {
            $total = 0;
            $data = array();
        }
        
        $this->set(compact(
            'limit',
            'total',
            'data',
            'type',
            'isEmptyZipcode'
        ));
        
        if ($this->request->is('ajax')) {
            $this->layout = "ajax";
            if (empty($data)) {
                exit;
            }
        }
    }
    
}
