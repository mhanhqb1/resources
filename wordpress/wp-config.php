<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'xRU4Pp>ioys|R3+NY/:]gz.._lx!`.XU506-5u`CO9m3IXiVxI,V^49Pn(d`p:TL');
define('SECURE_AUTH_KEY',  'b!PJU|m7Uqt_ o]!,&3s#VIr]! i:ce!gx#wHKp=`2:c&PLvQX32mPj}T_) Rt&{');
define('LOGGED_IN_KEY',    'Fv~=1U?4Ivr6=Sw&#(pQ^#<nk @]e!vOEX}7WdKcAQaQ9Ob-8EnCn PAI?UOMUxJ');
define('NONCE_KEY',        'zW&T3cWao:mXAdeLd5^@_0&z!-KVgT=gb^6yn@9rkGYj+;je=c?w+DY)R?@dTJ2[');
define('AUTH_SALT',        'M{eD1Zlux*mo[ i<F9KY~?b=$|PX^=<@Vn+E~,]C+u](Di[!:gNAMr2j!BxUn)-z');
define('SECURE_AUTH_SALT', 'MguglALrv#2o@_4,.RD#??XSk+c6J1Nb9|64Oc/xs)/TBve&<j>+Jd5^m94vPc(b');
define('LOGGED_IN_SALT',   'y&f%pvO#Gj(!l#1Hj|.e(JvJPo$kJOBQWtWHP+&B4.RTvSpi^l+NSTxo2s)V.Mio');
define('NONCE_SALT',       '}uAEUN2 gN@w|.75HY`xwpV5)6i?#uWg@+7Rc>G,~H.q38dJ8?5-n uQ nC7Qa:-');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
