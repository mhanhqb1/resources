<?php

/* 
 * Description : Class contain methods used for Help screen
 * User        : KienNH
 * Date created: 2015/11/02
 */

class HelpsController extends AppController {
    
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
        $url = Configure::read('API.url_helps_all');

        // Call API
        $response = Api::call($url);
        $this->set('helps', $response);
    }
}
