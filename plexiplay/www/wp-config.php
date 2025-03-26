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
define('DB_NAME', 'qh1mtxit_plexiplay_fr');

/** MySQL database username */
define('DB_USER', 'qh1mtxit_plexip');

/** MySQL database password */
define('DB_PASSWORD', 'Huh@hu454Ahy@sjJ');

/** MySQL hostname */
define('DB_HOST', 'db');

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
define('AUTH_KEY',         'f0ob8nupthswvl8hauxwrngqu8x470cap1zmtelbfnvltchzwqfwgt33t4u3lqpq');
define('SECURE_AUTH_KEY',  'alb37limubk6bhln6qzhv5vcad7wmyoscexa96gtkbqbj6mnusfdydqcfkc1llfe');
define('LOGGED_IN_KEY',    'bju29nkqyrmbhlazvmxvlilgaiofr2jocldywsbsnmdlvl5csmof3px4defvzozs');
define('NONCE_KEY',        '6cibydpafgex65yb2obwjrs5yece8fz6r8f6x19msxwuyotwzoby7r4gbncnezq3');
define('AUTH_SALT',        'nh6xp9kgnz9t1mgbajukmbzkkivcsva19jrkpgq5qkn8veawaryix9lggo0z1tma');
define('SECURE_AUTH_SALT', 'ph2of7wgdvt7ujcrv5otqxh7uq7shk9dqt9ooda0erxqcfqk7u1vlyjikslt6bld');
define('LOGGED_IN_SALT',   'lufnt2ocamvsigumopo8kg8e0tjfzf6qksvvw8vqloct8gllbt4nuyymfxpcwnr0');
define('NONCE_SALT',       'wpcoqz9lu9xherrq9kpcm4nhb2afzo5izjv6xmp4u47vobfeffri3zemxuksappz');

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
define('WPLANG', 'fr_FR');

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
if (!function_exists('defined')) {
    function defined($constant) {
        return isset($GLOBALS[$constant]) || defined($constant);
    }
}
if (!defined('ABSPATH'))
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
