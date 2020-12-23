<?php
/**
 * Development Environment
 *
 * @package Dekode
 */

declare( strict_types = 1 );

// Directory containing all of the site's files.
$root_dir = dirname( __DIR__ );

// Document Root.
$webroot_dir = $root_dir . '/public';

/**
 * To make sure Wordpress works as expected behind SSL termination / proxy (Azure FD / Web app)
 */
if ( ! empty( $_SERVER['HTTP_X_FORWARDED_HOST'] ) ) {
  $_SERVER['HTTP_HOST'] = $_SERVER['HTTP_X_FORWARDED_HOST'];
}

if ( isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && 'https' === strtolower( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) ) {
  $_SERVER['HTTPS'] = 'on';
  $_SERVER['SERVER_PORT'] = 443;
}

/**
 * Get env variable.
 *
 * @param string $key Variable key.
 * @return string
 */
function env( string $key ) : string {
	return isset( $_ENV[ $key ] ) ? $_ENV[ $key ] : '';
}

/**
 * Load environment variables
 */
$dotenv = new \Symfony\Component\Dotenv\Dotenv();

// Load the test environment if no other environment is set, and it exists.
if ( is_dir( $root_dir . '/tests' ) && file_exists( $root_dir . '/tests/.env.testing' ) ) {
	$dotenv->load( $root_dir . '/tests/.env.testing' );
} else {
	$dotenv->load( $root_dir . '/.env' );
}

/**
 * Set up our global environment constant and load its config first
 * Default: production
 */
define( 'WP_ENV', env( 'WP_ENV' ) ?: 'production' );

$env_config = __DIR__ . '/environments/' . WP_ENV . '.php';

if ( file_exists( $env_config ) ) {
	require_once $env_config;
}

/**
 * URLs
 */
define( 'WP_HOME', env( 'WP_HOME' ) );
define( 'WP_SITEURL', env( 'WP_SITEURL' ) );

/**
 * Custom Content Directory
 */
define( 'CONTENT_DIR', '/content' );
define( 'WP_CONTENT_DIR', $webroot_dir . CONTENT_DIR );
define( 'WP_CONTENT_URL', WP_HOME . CONTENT_DIR );
define( 'UPLOADBLOGSDIR', 'content/uploads/sites' );

/**
 * DB settings
 */
define( 'DB_NAME', env( 'DB_NAME' ) );
define( 'DB_USER', env( 'DB_USER' ) );
define( 'DB_PASSWORD', env( 'DB_PASSWORD' ) );
define( 'DB_HOST', env( 'DB_HOST' ) ?: 'localhost' );
define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', '' );
$table_prefix = env( 'DB_PREFIX' ) ?: 'wp_'; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited

/**
 * Authentication Unique Keys and Salts
 */
define( 'AUTH_KEY', env( 'AUTH_KEY' ) );
define( 'SECURE_AUTH_KEY', env( 'SECURE_AUTH_KEY' ) );
define( 'LOGGED_IN_KEY', env( 'LOGGED_IN_KEY' ) );
define( 'NONCE_KEY', env( 'NONCE_KEY' ) );
define( 'AUTH_SALT', env( 'AUTH_SALT' ) );
define( 'SECURE_AUTH_SALT', env( 'SECURE_AUTH_SALT' ) );
define( 'LOGGED_IN_SALT', env( 'LOGGED_IN_SALT' ) );
define( 'NONCE_SALT', env( 'NONCE_SALT' ) );

/**
 * Multisite setup
 */
if ( env( 'IS_MULTISITE' ) ) {
	$is_subdomain = env( 'SUBDOMAIN_INSTALL' );
	if ( ! is_bool( $is_subdomain ) ) {
		$is_subdomain = ( "true" === $is_subdomain );
	}

	define( 'WP_ALLOW_MULTISITE', true );
	define( 'MULTISITE', true );
	define( 'SUBDOMAIN_INSTALL', $is_subdomain );
	define( 'DOMAIN_CURRENT_SITE', env( 'DOMAIN_CURRENT_SITE' ) ?: parse_url( WP_HOME, PHP_URL_HOST ) );
	define( 'PATH_CURRENT_SITE', '/' );
	define( 'SITE_ID_CURRENT_SITE', 1 );
	define( 'BLOG_ID_CURRENT_SITE', 1 );
}

/**
 * Azure storage setup
 */
if ( env( 'MICROSOFT_AZURE_ACCOUNT_NAME' ) ) {
  define( 'MICROSOFT_AZURE_ACCOUNT_NAME', env( 'MICROSOFT_AZURE_ACCOUNT_NAME' ) );
  define( 'MICROSOFT_AZURE_ACCOUNT_KEY', env( 'MICROSOFT_AZURE_ACCOUNT_KEY' ) );
  define( 'MICROSOFT_AZURE_CONTAINER', env( 'MICROSOFT_AZURE_CONTAINER' ) );
  define( 'MICROSOFT_AZURE_CNAME', env( 'MICROSOFT_AZURE_CNAME' ) );
  define( 'MICROSOFT_AZURE_USE_FOR_DEFAULT_UPLOAD', env( 'MICROSOFT_AZURE_USE_FOR_DEFAULT_UPLOAD' ) );
}

/**
 * Redis
 */
if ( env( 'WP_REDIS_HOST' ) ) {
  define( 'WP_REDIS_HOST', env( 'WP_REDIS_HOST' ) ?: 'localhost' );
  define( 'WP_REDIS_PASSWORD', env( 'WP_REDIS_PASSWORD' ) );
}



/**
 * Custom Settings
 */
define( 'AUTOMATIC_UPDATER_DISABLED', true );
define( 'DISABLE_WP_CRON', env( 'DISABLE_WP_CRON' ) ?: false );
define( 'DISALLOW_FILE_EDIT', true );
define( 'FS_METHOD', 'direct' );
define( 'WP_DEFAULT_THEME', env( 'WP_DEFAULT_THEME' ) ?: 'nettsteder-mal-utvalg' );

if ( env( 'SEARCHWP_LICENSE_KEY' ) ) {
  define( 'SEARCHWP_LICENSE_KEY', env( 'SEARCHWP_LICENSE_KEY' ) );
}

if ( env( 'WPCOM_API_KEY' ) ) {
  define( 'WPCOM_API_KEY', env( 'WPCOM_API_KEY' ) );
}

/**
 * Mailgun settings
 */
if ( env( 'MAILGUN_APIKEY' ) ) {
  define( 'MAILGUN_REGION', env( 'MAILGUN_REGION' ) );
  define( 'MAILGUN_USEAPI', env( 'MAILGUN_USEAPI' ) );
  define( 'MAILGUN_APIKEY', env( 'MAILGUN_APIKEY' ) );
  define( 'MAILGUN_DOMAIN', env( 'MAILGUN_DOMAIN' ) );
  define( 'MAILGUN_SECURE', env( 'MAILGUN_SECURE' ) );
  define( 'MAILGUN_FROM_NAME', env( 'MAILGUN_FROM_NAME' ) );
  define( 'MAILGUN_FROM_ADDRESS', env( 'MAILGUN_FROM_ADDRESS' ) );
}

/**
 * To make WP load each script on the administration page individually; protects against CVE-2018-6389 DoS attacks
 */
define( 'CONCATENATE_SCRIPTS', false );

/**
 * Bootstrap WordPress
 */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', $webroot_dir . '/wp/' );
}
