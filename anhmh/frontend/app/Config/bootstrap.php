<?php
/**
 * This file is loaded automatically by the app/webroot/index.php file after core.php
 *
 * This file should load/create any application wide configuration settings, such as
 * Caching, Logging, loading additional configuration files.
 *
 * You should also use this file to include any files that provide global functions/constants
 * that your application uses.
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
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

// Setup a 'default' cache configuration for use in the application.
Cache::config('default', array('engine' => 'File'));

/**
 * The settings below can be used to set additional paths to models, views and controllers.
 *
 * App::build(array(
 *     'Model'                     => array('/path/to/models/', '/next/path/to/models/'),
 *     'Model/Behavior'            => array('/path/to/behaviors/', '/next/path/to/behaviors/'),
 *     'Model/Datasource'          => array('/path/to/datasources/', '/next/path/to/datasources/'),
 *     'Model/Datasource/Database' => array('/path/to/databases/', '/next/path/to/database/'),
 *     'Model/Datasource/Session'  => array('/path/to/sessions/', '/next/path/to/sessions/'),
 *     'Controller'                => array('/path/to/controllers/', '/next/path/to/controllers/'),
 *     'Controller/Component'      => array('/path/to/components/', '/next/path/to/components/'),
 *     'Controller/Component/Auth' => array('/path/to/auths/', '/next/path/to/auths/'),
 *     'Controller/Component/Acl'  => array('/path/to/acls/', '/next/path/to/acls/'),
 *     'View'                      => array('/path/to/views/', '/next/path/to/views/'),
 *     'View/Helper'               => array('/path/to/helpers/', '/next/path/to/helpers/'),
 *     'Console'                   => array('/path/to/consoles/', '/next/path/to/consoles/'),
 *     'Console/Command'           => array('/path/to/commands/', '/next/path/to/commands/'),
 *     'Console/Command/Task'      => array('/path/to/tasks/', '/next/path/to/tasks/'),
 *     'Lib'                       => array('/path/to/libs/', '/next/path/to/libs/'),
 *     'Locale'                    => array('/path/to/locales/', '/next/path/to/locales/'),
 *     'Vendor'                    => array('/path/to/vendors/', '/next/path/to/vendors/'),
 *     'Plugin'                    => array('/path/to/plugins/', '/next/path/to/plugins/'),
 * ));
 */

/**
 * Custom Inflector rules can be set to correctly pluralize or singularize table, model, controller names or whatever other
 * string is passed to the inflection functions
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 */

/**
 * Plugins need to be loaded manually, you can either load them one by one or all of them in a single call
 * Uncomment one of the lines below, as you need. Make sure you read the documentation on CakePlugin to use more
 * advanced ways of loading plugins
 *
 * CakePlugin::loadAll(); // Loads all plugins at once
 * CakePlugin::load('DebugKit'); // Loads a single plugin named DebugKit
 */

/**
 * To prefer app translation over plugin translation, you can set
 *
 * Configure::write('I18n.preferApp', true);
 */

/**
 * You can attach event listeners to the request lifecycle as Dispatcher Filter. By default CakePHP bundles two filters:
 *
 * - AssetDispatcher filter will serve your asset files (css, images, js, etc) from your themes and plugins
 * - CacheDispatcher filter will read the Cache.check configure variable and try to serve cached content generated from controllers
 *
 * Feel free to remove or add filters as you see fit for your application. A few examples:
 *
 * Configure::write('Dispatcher.filters', array(
 *		'MyCacheFilter', //  will use MyCacheFilter class from the Routing/Filter package in your app.
 *		'MyCacheFilter' => array('prefix' => 'my_cache_'), //  will use MyCacheFilter class from the Routing/Filter package in your app with settings array.
 *		'MyPlugin.MyFilter', // will use MyFilter class from the Routing/Filter package in MyPlugin plugin.
 *		array('callable' => $aFunction, 'on' => 'before', 'priority' => 9), // A valid PHP callback type to be called on beforeDispatch
 *		array('callable' => $anotherMethod, 'on' => 'after'), // A valid PHP callback type to be called on afterDispatch
 *
 * ));
 */
Configure::write('Dispatcher.filters', array(
	'AssetDispatcher',
	'CacheDispatcher'
));

/**
 * Configures default file logging options
 */
App::uses('CakeLog', 'Log');
CakeLog::config('debug', array(
	'engine' => 'File',
	'types' => array('notice', 'info', 'debug'),
	'file' => 'debug',
));
CakeLog::config('error', array(
	'engine' => 'File',
	'types' => array('warning', 'error', 'critical', 'alert', 'emergency'),
	'file' => 'error',
));

// load for each environment.
$env = getenv('FUEL_ENV');
if (!$env) {
    $env = 'development';
}

if ($env == 'production') {
    include_once ('production/bootstrap.php');
} else {
    include_once ('development/bootstrap.php');
}

// Load common
App::uses('Api', '');
App::uses('AppLog', 'Log');
App::uses('AppCache', 'Cache');
AppLog::config('info', array(
	'engine' => 'File',
	'types' => array('info'),
	'file' => 'info',
));

Configure::write('Config.language', 'jpn');
Configure::write('Config.pageSize', 10);
Configure::write('Config.uploadSize', 1); // 1M
        
// Define
define('DEFAULT_SITE_TITLE', 'Bmaps');
define('BASE_URL', Router::fullBaseUrl() . BMAPS_SUB_DIRECTORY);
define('COOKIE_KEY_REMEMBER', 'Bmap.Front.Cookie.Remember');
define('COOKIE_KEY_LANGUAGE', 'Bmap.Front.Cookie.Language');
define('NOTIFICATION_DATETIME_FORMAT', 'Y/m/d');
define('VERSION_DATE', "20151218");
define('SCHEMES_APP', 'bmapsapp://bmaps.world?');

Configure::write('Config.categoryImagePath', array(
    '0' => 'img/empty.png',   
    '1' => 'img/icon_mobility@3x.png',
    '2' => 'img/icon_car@3x.png',
    '3' => 'img/icon_leisure@3x.png',
    '4' => 'img/icon_food@3x.png',
    '5' => 'img/icon_life@3x.png',
    '6' => 'img/icon_public@3x.png',
    '7' => 'img/icon_wellness@3x.png',
    '8' => 'img/icon_shop@3x.png',
));
/*
Configure::write('Config.categoryImagePath', array(
    '0' => 'img/carousel.png',   
    '1' => 'img/categoryMobility.png',
    '2' => 'img/categoryCar.png',
    '3' => 'img/categoryLeisure.png',
    '4' => 'img/categoryFood.png',
    '5' => 'img/categoryLife.png',
    '6' => 'img/categoryPublic.png',
    '7' => 'img/categoryWellness.png',
    '8' => 'img/categoryShop.png',
));
*/
Configure::write('Config.physicalTypeIcon', array(
    '1' => 'img/physicalType1.png',
    '2' => 'img/physicalType5.png',
    '3' => 'img/physicalType6.png',
    '4' => 'img/physicalType2.png',
    '5' => 'img/physicalType7.png',
    '6' => 'img/physicalType8.png',
    '7' => 'img/physicalType3.png',
    '8' => 'img/physicalType4.png',
    '99' => 'img/physicalType9.png',
));
Configure::write('Config.physicalTypeIconWhite', array(
    '1' => 'img/physicalType1w.png',
    '2' => 'img/physicalType5w.png',
    '3' => 'img/physicalType6w.png',
    '4' => 'img/physicalType2w.png',
    '5' => 'img/physicalType7w.png',
    '6' => 'img/physicalType8w.png',
    '7' => 'img/physicalType3w.png',
    '8' => 'img/physicalType4w.png',
    '99' => 'img/physicalType9w.png',
));

Configure::write('Config.placeFacilityIcon', array(
    'is_flat' => 'img/equipment1.png',
    'is_spacious' => 'img/equipment2.png',
    'is_silent' => 'img/equipment3.png',
    'is_bright' => 'img/equipment4.png',
    
    'count_parking' => 'img/equipment9.png',
    'count_wheelchair_parking' => 'img/equipment7.png',
    'count_elevator' => 'img/equipment6.png',
    'count_wheelchair_rent' => 'img/equipment10.png',
    
    'count_wheelchair_wc' => 'img/equipment5.png',
    'count_ostomate_wc' => 'img/equipment8.png',
    'count_nursing_room' => 'img/equipment11.png',
    'count_babycar_rent' => 'img/equipment12.png',
    
    'with_assistance_dog' => 'img/equipment13.png',    
    'is_universal_manner' => 'img/equipment14.png',
    'with_credit_card' => 'img/equipment15.png',
    'with_emoney' => 'img/equipment16.png',
    
    'count_plug' => 'img/equipment17.png',
    'count_wifi' => 'img/equipment18.png',
    'count_smoking_room' => 'img/equipment19.png',
));
