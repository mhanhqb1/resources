<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
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
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
 
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
    Router::connect('/', array('controller' => 'lp', 'action' => 'index'));
    Router::connect('/en', array('controller' => 'lp', 'action' => 'en'));
    Router::connect('/jp', array('controller' => 'lp', 'action' => 'jp'));
    Router::connect('/es', array('controller' => 'lp', 'action' => 'es'));
    Router::connect('/thanks', array('controller' => 'lp', 'action' => 'thanks'));
    Router::connect('/logout', array('controller' => 'login', 'action' => 'logout'));
    Router::connect('/register', array('controller' => 'users', 'action' => 'register'));
    Router::connect('/forgetpassword', array('controller' => 'login', 'action' => 'forgetpassword'));
    Router::connect('/active/*', array('controller' => 'login', 'action' => 'active'));
    Router::connect('/timelines/likereview', array('controller' => 'timelines', 'action' => 'likereview'));
    Router::connect('/timelines/*', array('controller' => 'timelines', 'action' => 'index'));
    Router::connect('/notices/*', array('controller' => 'notices', 'action' => 'index'));
    Router::connect('/places/detail/*', array('controller' => 'places', 'action' => 'detail'));
    Router::connect('/places/review/*', array('controller' => 'places', 'action' => 'review'));
    Router::connect('/places/ranking', array('controller' => 'places', 'action' => 'ranking'));
    Router::connect('/users/profile/*', array('controller' => 'users', 'action' => 'profile'));
    Router::connect('/editProfile', array('controller' => 'users', 'action' => 'editProfile'));
    Router::connect('/confirmcode', array('controller' => 'login', 'action' => 'confirmcode'));
    Router::connect('/resetpassword/*', array('controller' => 'login', 'action' => 'resetpassword'));
    Router::connect('/top', array('controller' => 'top', 'action' => 'index'));
    Router::connect('/users/ifollow/*', array('controller' => 'users', 'action' => 'ifollow'));
    Router::connect('/users/ifollow', array('controller' => 'users', 'action' => 'ifollow'));
    Router::connect('/users/followme/*', array('controller' => 'users', 'action' => 'followme'));
    Router::connect('/users/followme', array('controller' => 'users', 'action' => 'followme'));
    
/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
        Router::parseExtensions('json');