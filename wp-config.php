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
define('DB_NAME', 'beaumont');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         '*xqp*_Q/#jEg;o?/h[/GBMKZ3sr/H/(R7va=n6/g8gld]8#Pky1$&JY1SBFYMY&G');
define('SECURE_AUTH_KEY',  'U>D07kRLTM,:3u`hcT/[(B^%Bi5GS.OQqABNB.@a>sXd*+V @6xY7R)E4YRa:q%+');
define('LOGGED_IN_KEY',    'muFK#7+/^}!g~~}Fu-vV8#=.5a:Idjw6s6_5 iOaw]Gmr|-uGRraLC1lKX4|pw9~');
define('NONCE_KEY',        'gyyl4{NO(BTxYAMklW!R=v.0jUkG*%b>O4/F8DOMw^CseCw9_p8Y@,*+-QL.*}pi');
define('AUTH_SALT',        ')3hk+-iY6zFa{%>qeYQjqLS9t)_jj- ]yNLEA(^a].%xbn%+D(E}pOP2E7(6a kn');
define('SECURE_AUTH_SALT', 'oZ{_RjT%gsVsvGSu5O9R(J_[!Fji k_!/Oy{xbjXwscRU?}I1+))NO[;kldf[)b}');
define('LOGGED_IN_SALT',   '{-: &[ $:zxF4^H@k#>i{og#*&i=d/TA~+ `DET_.O}q|&Ao^{zr-]0@pb-{6wTX');
define('NONCE_SALT',       'U4H=n0p^BwjYHq9t<T/CQ0-yH-SL,r8ahu),-8J8d~3eR&WtU68 4Lp<PBljn6I#');

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
