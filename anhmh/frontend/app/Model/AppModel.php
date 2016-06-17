<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
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
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {
    
    /**
     * Get all categories.
     *
     * @author ThaiLH
     * @return array Returns the array.
     */
    public static function categories_all() {
        /*$languageType = Configure::read('Config.languageType', 1);
        $key = 'categories_all_' . $languageType;
        $seconds = 60*60;
        $result = AppCache::read($key);
        if ($result === false) {
            $result = Api::call(Configure::read('API.url_placecategories_all'));
            AppCache::write($key, $result, $seconds);
        }        
        return $result;*/
        return Api::call(Configure::read('API.url_placecategories_all'));
    }
    
    /**
     * Get all physical type.
     *
     * @author ThaiLH
     * @return array Returns the array.
     */
    public static function physical_type_all() {
        /*$languageType = Configure::read('Config.languageType', 1);
        $key = 'userphysicals_all_' . $languageType;
        $seconds = 60*60;
        $result = AppCache::read($key);
        if ($result === false) {
            $result = Api::call(Configure::read('API.url_userphysicals_all'));
            AppCache::write($key, $result, $seconds);
        }        
        return $result;*/
        return Api::call(Configure::read('API.url_userphysicals_all'));
    }
    
}
