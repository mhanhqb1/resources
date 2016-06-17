<?php

/**
 * Application level View Helper
 *
 * This file is application-wide helper file. You can put all
 * application-wide helper-related methods here.
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
 * @package       app.View.Helper
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Helper', 'View');
App::import('Component', 'Common');

/**
 * Application helper
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package View.Helper
 */
class AppHelper extends Helper {

    /** @var string $controller Controller name */
    public $controller;

    /**
     * Construct
     *     
     * @author thailvn   
     * @param object $view View class     
     * @return void 
     */
    public function __construct(View $view, $settings = array()) {
        parent::__construct($view, $settings);
        $this->controller = $this->loadController();
    }

    /**
     * Load a controller
     *     
     * @author thailvn   
     * @param string $name Controller name    
     * @return Object Controller 
     */
    protected function loadController($name = null) {
        if (is_null($name))
            $name = $this->params['controller'];
        $className = ucfirst($name) . 'Controller';
        list($plugin, $className) = pluginSplit($className, true);
        App::import('Controller', $name);
        if(class_exists($className)){
            $cont = new $className;
            $cont->constructClasses();
            $cont->request = $this->request;
            return $cont;
        }
        return null;
    }
    
    /**
     * Create Common component for helper
     *     
     * @author thailvn        
     * @return Object Common component 
     */
    public static function getCommonComponent() {
        return new CommonComponent(new ComponentCollection());
    }    
}
