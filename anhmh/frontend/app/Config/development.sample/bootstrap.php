<?php

/**
 * Load config for development environment
 */

define('BMAPS_SUB_DIRECTORY', '/oceanize/bremen/frontend');
Configure::write('API.Host', 'http://devapi.bmaps.world/');
Configure::write('Config.HTTPS', true);

define('FACEBOOK_APP_ID', '485631328262139');
define('FACEBOOK_APP_SECRET', 'd1216f4abf31b6c75082d646bdaeceda');

define('TWITTER_CONSUMER_KEY'   , 'wQzOqPn5WpXEjY5dkNxThQrkj');
define('TWITTER_CONSUMER_SECRET', 'DyOygkVYA2QIEBiVB9GRe1FNje2zThW8A6gijQHAOxtjCoYkUZ');

Configure::write('Google.Analyticstracking',array(
	'lp'=>'<!-- Insert google analytics scripts When production -->',
	'admin'=>'<!-- Insert google analytics scripts When production -->')
);