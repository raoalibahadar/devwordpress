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
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'dev_wordpress' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
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
define( 'AUTH_KEY',         '$%#Jh@U,!5+(g{Sg7-4}H,TG@9_[:EGMB33C;=)9{<)1##Uf&5,F%9{+&Nx+U;>)' );
define( 'SECURE_AUTH_KEY',  '6*v`WFbH?|}@ytLK/Abv?#+6E* Q=E^gybH=Ud-E%UFm&Di8z(d/34ESx]k9oxhI' );
define( 'LOGGED_IN_KEY',    '<-;YldG]r8ryd;AfGIqrr/keijf36B:V#fx D9O@]6x96_*zJVv2Gs3-^s&8:pQG' );
define( 'NONCE_KEY',        'BXLH]B}ZX*nerqJ-zNuER$a`ZPnG]jPXOP dXbREJV,6|RM@s|8-[+5Zs4,j/wt!' );
define( 'AUTH_SALT',        '!$$npLt+%i#!oqE&G*5V}5Sh~%}pzGYLJA.yLG7-[d2go/MwB(=c&/PqJ7Z5?)0-' );
define( 'SECURE_AUTH_SALT', '7[,[F5p:7u`U:2V$OiFAG_PXPqpDp R-!t%p|kDfufFbJzV}zZg%oa&k^X.zs7Vh' );
define( 'LOGGED_IN_SALT',   'I^/^arLjx)vt%v>HBn]._,Ys;OodDAGi9`.;Wc*jKZIo}XR2|&Kw}=x_[^G2o^rV' );
define( 'NONCE_SALT',       'W{5 mS`8|322)umnS;8dj1=|A>n7}4IJkZs<+K[4?mLOyLk=YL~~(`t8K^KCVGY^' );

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
