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
define('DB_NAME', 'plugindata');

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
define('AUTH_KEY',         '[F}Jw>X$)M0o0:Iu )/ReJW6P(OFQ;JQD$BV]8VjD}QM*&TIJH!1x6CRCE(}i$in');
define('SECURE_AUTH_KEY',  'G3,FtB^)B>=qVx`C^@:=F1?O]aq^tugBbw|5gB{R-DQCoa.Y{Z?;pmsMHGLz%u*B');
define('LOGGED_IN_KEY',    '2GYM5K>G?dv?+N&^0I>QK%Bvj[9HjRKQ)QJ|xOmv:ID_ZDvw@>?KA|;p&#t65t8T');
define('NONCE_KEY',        'Dirc~%45C)q~P6Wm@:n_:@j8DA9~1=Sea6{ot4|d[Fuy:<t ,r-6>&r0Y7V@gyhA');
define('AUTH_SALT',        '}pY3+{p^_o`s0AkjsYymf9 U%q]4,_m)e[_&mTnf!{,<S%$~K~$qdy)T(&5qLGsr');
define('SECURE_AUTH_SALT', 'Zf=o#kr<d-`=eQBO!?wRx3-VSv20yuWW%yXtc46*;vx1lh1u5/v9ba-d/0I=?LVJ');
define('LOGGED_IN_SALT',   'uCl}mq:p,!?!^o=mF}mP&ZVQw^bC_38iOlKo,UNa|3D@zP[F@F#uK5]T@A7@[@+D');
define('NONCE_SALT',       'nkY^6i4b)i7a#>![ZXk@dxAR~uTE!v)S>>N6.HV_Wc%y~b5|387wf 2?8ry:<@Tb');

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
