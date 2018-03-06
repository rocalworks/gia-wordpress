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
define('AUTH_KEY',         'Z;]^P|ok7;<<s+nDO>I}IhOlb.Y*+R-c7c:!]h!VR!9B(DgsR7k6m,!iwt%UYZ~/');
define('SECURE_AUTH_KEY',  '(;t>lS>QO^.8>_.-Ivq]bUn{Y17T!wb2SJ4&SEUkIpi)d>CSZ=Vw%^bj.*+noHqt');
define('LOGGED_IN_KEY',    '3y%$(R_={l3o2eX&Qpz41G]LV+Uz<I84x;dWCo1Fhv6!(NWEVVVQYaXY43.UB[[@');
define('NONCE_KEY',        'E#Bky)x/&AXoCz_RvY[~#LZ+qmGC5XM09$[O-k_f81sni.-kEFS;G6V]8Giqt@&1');
define('AUTH_SALT',        '7paD6-$CN56yFEafRWBVdAIRfjOb=~lFo/`/ma]6]EIKCym+B5`GNjgGBdsvlodD');
define('SECURE_AUTH_SALT', 'iTc32qN}R,=@|!+]}y;</SIZ.l[C_9RKGK/]~_Om[vRT{Z@/8@H#b|CL,bwAq^(<');
define('LOGGED_IN_SALT',   'nKPJCeHZC]>eq>TJS[}p /y#(aNV;1Y=<H2+)ZKT2$,y*UnI@@+A Dav+qeKNYp:');
define('NONCE_SALT',       'mi7)(jCkTjW]Vh{!$S]UW rv4V6E:cR1hdfHD^IeWDARO)i#(yKQh#3=SejyYYUO');

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
