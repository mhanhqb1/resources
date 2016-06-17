<?php

/**
 * Load config for production environment
 */

define('BMAPS_SUB_DIRECTORY', '');
Configure::write('API.Host', 'https://api.bmaps.world/');
Configure::write('Config.HTTPS', true);

//define('FACEBOOK_APP_ID', '1680872712150146');
//define('FACEBOOK_APP_SECRET', 'e6eb2c0e879243194d7d684f14d90b8d');

define('FACEBOOK_APP_ID', '1774325229462079');
define('FACEBOOK_APP_SECRET', 'b13eccce50779dbb877600eb5cfcb7f1');

define('TWITTER_CONSUMER_KEY'   , 'QEo3QaWc4TLCyxkO4KqdBR29u');
define('TWITTER_CONSUMER_SECRET', '3oIUTkiFL7WkesWyd7iw22luK0YEv2eNxPnjbvaFklh4vqGpJT');


Configure::write('Google.Analyticstracking',array(
	'lp'=>'<script>  (function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)  })(window,document,\'script\',\'//www.google-analytics.com/analytics.js\',\'ga\');ga(\'create\', \'UA-71562631-1\', \'auto\');ga(\'send\', \'pageview\');</script>',
	'admin'=>'')
);

Configure::write('Session', array(
    'defaults' => 'php',
    'ini' => array(
        'session.cookie_secure' => true
    )
));
if ( isset($_SERVER['HTTP_X_FORWARDED_PORT']) && 443 == $_SERVER['HTTP_X_FORWARDED_PORT'] ) {
    Router::fullbaseUrl( 'https://'.$_SERVER['HTTP_HOST'] );
}