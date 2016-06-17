<?php

/*
 * Description : Class contain methods used for Setting screen
 * User        : KienNH
 * Date created: 2015/11/03
 */

class SettingsController extends AppController {

    /**
     * Load library
     */
    function beforeFilter() {
        parent::beforeFilter();
    }

    /**
     * Top page
     */
    function index() {
        // Init
        $url = Configure::read('API.url_users_settings_all');

        // Call API
        $settings = Api::call($url);
        $this->set('settings', $settings);
    }

    function update() {
        $this->viewClass = 'Json';
        if (!$this->request->is('ajax')) {
            throw new BadRequestException();
        }

        $response = array();
        $check = $this->Setting->validate($this->request->data, $errors);

        if ($check) {
            // pass validate
            
            // Call API to update
            $url = Configure::read('API.url_users_settings_update');
            $parameters = array(
                "name" => $this->request->data['Setting']['name'],
                "value" => $this->request->data['Setting']['value']
            );
            $apiReturn = Api::call($url, $parameters);
            if ($apiReturn === TRUE) {
                $response['success'] = TRUE;
            } elseif (is_array($apiReturn) && isset($apiReturn['error']) && isset($apiReturn['error']['message'])) {
                $response['success'] = false;
                $response['message'] = $apiReturn['error']['message'];
            } else {
                $response['message'] = __("UNKNOW_ERROR");
            }
        } else {
            // validate input data fail
            $response['success'] = false;
            if (isset($errors['name']) && is_array($errors['name']) && count($errors['name']) >= 1) {
                $response['message'] = $errors['name'][0];
            } elseif (isset($errors['value']) && is_array($errors['value']) && count($errors['value']) >= 1) {
                $response['message'] = $errors['value'][0];
            } else {
                $response['message'] = __("UNKNOW_ERROR");
            }
        }
        $this->set('_serialize', 'data');
        $this->set('data', $response);
    }
}
