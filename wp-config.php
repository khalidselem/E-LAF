<?php
define( 'WP_CACHE', true );


//Begin Really Simple SSL session cookie settings
@ini_set('session.cookie_httponly', true);
@ini_set('session.cookie_secure', true);
@ini_set('session.use_only_cookies', true);
//END Really Simple SSL
 // By SiteGround Optimizer
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
define( 'DB_NAME', 'ainalh5_elaf' );

/** MySQL database username */
define( 'DB_USER', 'ainalh5_elaf' );

/** MySQL database password */
define( 'DB_PASSWORD', 'Yahoo@2019' );

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
define( 'AUTH_KEY',         '0cW 1kWWe`.3G*rjhhhI87sh py3e]i/>nB!jEGgDFX=D7 B$]>!dI.S07?(pfhx' );
define( 'SECURE_AUTH_KEY',  '..c_hE(rv2^->gW5krAsQtT.mclh#vT%}59n#I+kNNdg3-Z,c--Hf;^]?JhgiE/O' );
define( 'LOGGED_IN_KEY',    'ia[W>Q3Nj7LZEz>GnQ(_cRlXDfIw`%1Rc W_;5{(Lc7j%NaqsOK~XtJnx;KX|vTk' );
define( 'NONCE_KEY',        ':fMb#Ka@~%:^lC=;5Qr.9sCK+iav&]UL|#bAq?@6(CL^|.Q;l?(^@=h.-RbK>qyy' );
define( 'AUTH_SALT',        'C0x+ z1}|H}P5U GJIx2r;fz+LdJ *<ZoK|[2<e[wUmd~|}>Qx[K.r?Lir=eein_' );
define( 'SECURE_AUTH_SALT', '!xxwkC!(lz)HXD7W4 6*Rw%pzA+zqER%R{.ix0l{(F 8N,w`eKO[s<sc6ohTJmsL' );
define( 'LOGGED_IN_SALT',   '$oxZ9f9[e/zdkYB.-|<da1L1z|WkhyW0mnalW3Jf,y?a;{.Rr*K~o^BZVj^Kw/=0' );
define( 'NONCE_SALT',       '(K2$3@[;mi#}+G-Xc:j/a~Fk)@Es)Xc&eoFF,;QS<}gH..@S| q5o( -uNh,Iir?' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_elaf';

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
define( 'WP_DEBUG', false  );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
