<?php

/* 
 * Description : Class contain methods used for Top screen
 * User        : KienNH
 * Date created: 2015/10/28
 */

class TopController extends AppController {
    
    /**
     * Load library
     */
    function beforeFilter () {
        parent::beforeFilter();
        $this->Auth->allow();
    }
    
    /**
     * Top page
     */
    function index() {
        $this->set('query', $this->request->query);
    }

    /**
     * Search spot
     */
    function near_by_search() {
        $this->viewClass = 'Json';
        if (!$this->request->is('ajax')) {
            throw new BadRequestException();
        }

        $url = Configure::read('API.url_places_search');
        $response = Api::call($url, $this->request->data);
        
        if (!empty($response)) {
            foreach ($response as $key => $value) {
                // Copy from View/Elements/left_spot_item.ctp
                //$value['review_point'] = floor($value['review_point']);
                $value['count_follow'] = !empty($value['count_follow']) ? $value['count_follow'] : '0';
                $value['place_category_type_id'] = !empty($value['place_category_type_id']) ? $value['place_category_type_id'] : '0';
                $value['id'] = !empty($value['id']) ? $value['id'] : '0';
                $value['google_place_id'] = !empty($value['google_place_id']) ? $value['google_place_id'] : '0';
                
                $response[$key] = $value;
            }
        }

        $this->set('_serialize', 'data');
        $this->set('data', $response);
    }

    function autocomplete() {
        $this->viewClass = 'Json';
        
        if (!isset($this->request->query['location'])) {
            // set default as tokyo
            $this->request->query['location'] = '35.681391,139.766122';
        }
        if (!isset($this->request->query['radius'])) {
            // set default as tokyo
            $this->request->query['radius'] = '10000';
        }

        $url = Configure::read('API.url_places_autocomplete');
        $response = Api::call($url, $this->request->query);

        $this->set('_serialize', 'data');
        $this->set('data', isset($response['predictions']) ? $response['predictions'] : array());
    }

    function add_spot() {
        $this->viewClass = 'Json';
        if (!$this->request->is('ajax')) {
            throw new BadRequestException();
        }

        $url = Configure::read('API.url_placepins_add');
        $response = Api::call($url, $this->request->data);

        $this->set('_serialize', 'data');
        $this->set('data', $response);
    }
}
