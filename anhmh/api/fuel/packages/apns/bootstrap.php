<?php
/**
 * Fuel
 *
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.7
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2013 Fuel Development Team
 * @link       http://fuelphp.com
 */
Autoloader::add_core_namespace('Apns');
Autoloader::add_classes(array(
	'Apns\\Apns' => __DIR__ . '/classes/apns.php',    
));
\Config::load('apns', true);