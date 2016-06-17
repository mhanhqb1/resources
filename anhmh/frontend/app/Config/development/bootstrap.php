<?php

/**
 * Load config for production environment
 */

define('BMAPS_SUB_DIRECTORY', '');
Configure::write('API.Host', 'http://api.anhmh.localhost/');
Configure::write('Config.HTTPS', false);
Configure::write('debug', 0);

define('FACEBOOK_APP_ID', '100274197065981');
define('FACEBOOK_APP_SECRET', 'ceb5eaddbebb4590a991cf32a956f2f6');

define('TWITTER_CONSUMER_KEY'   , 'diXip9KkGrJ0QGhRaxXMNtPve');
define('TWITTER_CONSUMER_SECRET', 'ugZG8bPb2oiDZMPU6XbdvLozCy5Di4ZYZCaKEsxHJWzyhroljk');


Configure::write('Google.Analyticstracking',array(
	'lp'=>'<script>  (function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)  })(window,document,\'script\',\'//www.google-analytics.com/analytics.js\',\'ga\');ga(\'create\', \'UA-71562631-1\', \'auto\');ga(\'send\', \'pageview\');</script>',
	'admin'=>'')
);

Configure::write('Session', array(
    'defaults' => 'php',
    'ini' => array(
        'session.cookie_secure' => false
    )
));
if ( isset($_SERVER['HTTP_X_FORWARDED_PORT']) && 443 == $_SERVER['HTTP_X_FORWARDED_PORT'] ) {
    Router::fullbaseUrl( 'http://'.$_SERVER['HTTP_HOST'] );
}