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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'yourmodelrealestate.com' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '^gloCve( vx;p@NQl)yp_EiQP#EZjdhtBlkEw0uyK98e!&4[Vdr3UxWl}^6!..a4' );
define( 'SECURE_AUTH_KEY',  '_WTiO=`N2&FL#fgG-K^{SVs{gZWF!I;Qo15|x1Ro15B!19 Ugu&HNzK=kb=|=f>_' );
define( 'LOGGED_IN_KEY',    '&-J~/W[u5OFgGt.-f^$hVjaq1MHnE.bn`P4NTdEIQ1O:Y5}N:e3t4>ye#lmh.Pto' );
define( 'NONCE_KEY',        'KS&Dr^0@-P1=,XlktY#7GfHD<[SlV!X>peLMG|Tx/kL~{HpdHQ06Y={gH9(4FJuL' );
define( 'AUTH_SALT',        '_i;Q$8tS:w7&.3bM|SB3jErubM7}sI1{5yF(08OQ^#f=jc-5 3R4=gJej?Y;}F(s' );
define( 'SECURE_AUTH_SALT', 'l#h#RYKBuQ;6YYZ6uMGo` =kRSYl]odys;wk7^:0-UGj6n+-u~GQ`$(Ka#Ae!DAx' );
define( 'LOGGED_IN_SALT',   '00R2VjF6)_:mLm~~Y%P)>E(v#:do6h<S(Fy[1!1_W:#-J8u|tg{qs8jd~40cL9*R' );
define( 'NONCE_SALT',       'NQ1q(5Gry~OEYAuyhUb6aBc7v5]deC(B2*,~CZKH+y,xx:q3>]5s5I(-m65*fVPz' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
