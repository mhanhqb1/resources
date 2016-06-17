<?php

/* 
 * Description : Class contain methods used for Notice screen
 * User        : KienNH
 * Date created: 2015/11/03
 */

class NoticesController extends AppController {
    
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
                'limit' => Configure::read('Config.pageSize'),
                'disable' => 0,
            )
        );    
        if (!$this->request->is('ajax') && $page > 1) {
            $param['page'] = 1;
            $param['limit'] = $param['limit'] * $page;
        }
        // Call API
        $result = Api::call(Configure::read('API.url_notices_list'), $param);
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
            if (empty($data)) {
                exit;
            }
        }
    }
}