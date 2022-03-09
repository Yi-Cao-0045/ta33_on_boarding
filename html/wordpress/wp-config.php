<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wp_db' );

/** Database username */
define( 'DB_USER', 'root_sql' );

/** Database password */
define( 'DB_PASSWORD', 'yourpasswd' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'd!/!8rPl*K-^<K@km]$i# ge3$a9Df3>B+TFc}ums.N8f>Dc?@P=4hGm?mPmuapU' );
define( 'SECURE_AUTH_KEY',  '</8u,M$M[NhEhXL+.-+XzdIr=_Y$V|836B9xh2bYRWzC?_W5D`04Q< M2T:g_z(K' );
define( 'LOGGED_IN_KEY',    'lGV8JISy)>9So?%9aO?0-|/V[@0[G_9P1{I3At[8W[)r~:#zZz}R+=|_~RMCmExu' );
define( 'NONCE_KEY',        'J:y{AdjksoKaw(Ur8~h/Vb|oA>$jV~;&`p_mR6*{fAc-1Cnp[cx+dX+-O,%Ys^-@' );
define( 'AUTH_SALT',        '#2UtdpSAUP:^Rx/F9m1O?epu]F,dolR`U=9a6iREGlg^nhFfpaPlSk Q2IzM{vZ*' );
define( 'SECURE_AUTH_SALT', '.~fF|6X1PK!?IETE|dKx(1 V6Mbs((J~sMj=<Yf1Z}@V7BAXWY:@M6W?5[l5j(~^' );
define( 'LOGGED_IN_SALT',   '4Q|Z?jVaK3LPjR%LvSl[:9n[j~-tuLn(aqppR^DEB(dQwN;y6l`hxh<WJhxSz,a,' );
define( 'NONCE_SALT',       'E@v/Ad @>)L(|HOXDvV8Om0{Ba}E%t.oAFr^&?-2gc?V OdO0Wrq<_~A%0Vqu(7;' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
