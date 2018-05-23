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
define('DB_NAME', 'lose5db');

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

/* * #@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', '=V!pdU>zA[$tnDPiL=f;vYwwPm*MQZND[nNbUdprHMBP)eW%B>kuQ/_$K[{ARHnwVINoT}+q}zz<O_T%xf!NBAp(agC-C/])Apt+?r]xFTfv)LDSDQG^LLxkKQWXe$+d');
define('SECURE_AUTH_KEY', 've?b+HZb&ac)lOmaBnc!{OGEXipKyMZz=;<=jyHAgPx=>z*>y?VwYBwoHUMICf+q%%Xlan{bel+^-!{OtmdQD/R]kPJHh]hvoi&ZcdQpVzni+!^Q_E-XTIjmhuMCrFxg');
define('LOGGED_IN_KEY', 'MoBiitHmp)[DJ-F&W(GC*bS^LD|&NE^(KinosCsSjES%vFj(AdNrjjFsgLaO?<}d+}BavD$h+|JtpXimz>FyJrUd%@X<W|]P*xQeuol)T-De(G{/otv[xPGlfNW&QqMz');
define('NONCE_KEY', 'U-SLDos_XWM-b*hfk+GN/fnq}V?=FlW>ZH%-rl!>)b[zimdD?{_Tcp[?Rnh]B}cx=^+UsTmwG?JXu^vcw|$mlzb^OIZUy;ck(kkci/qzKt-YFkgy}cJ@>O[c(WOs%kZr');
define('AUTH_SALT', 'P<f+R?fyMmdGwo{mziJ|WrQ^lm]=*GnWtlVm_ujRHfh+hZf_M^qvy{GnfZ&t&Tq^;/pb/CBpm!q+{q+D=x>a&^NIvipd+PGbOk|Owm{pohrmvGF(k*cg/dSWm!RNisnW');
define('SECURE_AUTH_SALT', '$tw;fwbaE[z^BmB+mgHSoWUYTZd*%xEq?-E)<FG_W*jUj/Wsc>>-OOA+u&g/dHTk]YTcWIedplXSy;y-iIAES=R}E>c*UubMTfkpDIuEy{>^AD]o(OSC?EQ(}Q}je-s^');
define('LOGGED_IN_SALT', 'Id=lU/)N@NxJMrhDk-%R$Ky;pf&iD)X>=_xN_tRp*{=y-how&zw=hsg;iWWEEJDeILc|ExNL)A_HS/_Vr<eHQ)(Vz<sIzscjg-unwgeSEfY_*<]Lksz;iWNqAoh@a)!b');
define('NONCE_SALT', '*?E?@b!h?kAbY[+u//W>*sa;er@J[%e@X+T-AK|L)O?}_WUpD&LGffi{Z)DlzXFN-<iu]]a<i%GUKJ?q?S;*C|ueE_L]A(mQLu)@{E^hgaoRF?%uUSZDlQ);qBga>?Sj');

/* * #@- */

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_xoea_';

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
if (!defined('ABSPATH'))
    define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
