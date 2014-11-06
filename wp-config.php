<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'habsprospect');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'x|nl|%{:|,/_u10K8.]O|NJM;qc@0OuzdJVfnX$H9X._%kj=]J8^T|+m&FKhdV7x');
define('SECURE_AUTH_KEY',  '^,GY,FYz|z_-Bw(tN{HM9WQb&(wd[(v{f%Kw]X-,Jo<VFSiAE)tqJe5wBL]-:3:G');
define('LOGGED_IN_KEY',    'g[$:A_J1=cmGKB<eC87)J]dnA|1}m&r;*#2fbeMq!$eO|,m+d&c+:IGgp8t51VFJ');
define('NONCE_KEY',        'sIs];q@?*cFY5rby>sKY=t|?G4pTHv-lrn;B(FOP$NX+Mh+C;~#I:<Dh~p?clj?T');
define('AUTH_SALT',        '2qCgUewf=hp]=R[Wu3],[cQ{~#0|SZ*Gi`0LlD7e3qaw+5A|=&ojH~9;I}NjvG/ ');
define('SECURE_AUTH_SALT', '[T/eQ,rRbh.=5Sv|&kh5|j_!io$:ea9l,`C(p-<2r7#q!+(u_RWCdN*4aZGh)=E%');
define('LOGGED_IN_SALT',   'DPnGMcUD;kG8{dgZ`(jG2yo.XC~c;!dVlKqN*J$MMPEi$IL%gmve3-|n* v8AI2!');
define('NONCE_SALT',       ', DloAy;slagln;NJ!9;/8459IMrV.Pa5CchrO8-j<E!5;2+?:5ibX&1%>-TU PO');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'hp_';


/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */

define('WPLANG', 'fr_FR');
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
