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
define('DB_NAME', 'breezetu_nes_2');

/** MySQL database username */
define('DB_USER', 'breezetu_db');

/** MySQL database password */
define('DB_PASSWORD', 'b#;VPhBL?hO]');

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
define('AUTH_KEY',         'L-yM0J6%VdDMTXnkpu8HRdl3bGNR:1O.=]TVaVXv!3fc_ogyvJK>~{pTy:/ZAp2s');
define('SECURE_AUTH_KEY',  '-~W%39hLy`4:L!=X{ou|: EQLY>+a{1nz^[NJF]![4j!<|2M#moELiu}#mg(1Y7,');
define('LOGGED_IN_KEY',    '>N.VnHqq2*_j/V|:~h1NX(8RuiyG>H;I,dY~L~h/XW*_RkA5kI<5Pw,mL83dkP$;');
define('NONCE_KEY',        'Udas=EwV|Fb1Y gw%E-.DJIwx8g~crBIA4lZXa=,wpo d!fL-2op#mr1)HF47R8`');
define('AUTH_SALT',        'PT#;{z02nEjZt/w=~e5%d4 vyImTO=8s_Hq/qY{r 8IHBWs(x7LM4KyH[(2-`Zs;');
define('SECURE_AUTH_SALT', 'w+e?&S| U7Q`MBzz6;n{|eB1JM `$g+SZL/B;}By~&]Df3C5U>]*5z[&mXFb;s[b');
define('LOGGED_IN_SALT',   'N103}R8<A,YpX.|^D@kV<nSJl9]X@tfrzcOg=DIbJ$tWNYTp;*o`8}`L^U$7|h$;');
define('NONCE_SALT',       'N/bkfZ)jb,}e} *rC/B@[Z1p$gTxDX5CFa[` ~c#7J[e44[A~+@{,whXeyWYWq~C');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
