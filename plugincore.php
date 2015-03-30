<?php
/**
 * @package   Metaplate
 * @author    David <david@digilab.co.za>
 * @license   GPL-2.0+
 * @link
 * @copyright 2014 David
 *
 * @wordpress-plugin
 * Plugin Name: Metaplate
 * Plugin URI:
 * Description: Create Meta Templates to display Custom Fields and Post Meta
 * Version: 0.3.1
 * Author:      David
 * Author URI:
 * Text Domain: metaplate
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Plugin Version
 *
 * @since 1.0.0
 * @param string
 */
define( 'MTPT_VER', '0.3.1' );
/**
 * Set paths
 *
 * @since 1.0.0
 * @param string
 */

/**
 * Plugin URL
 *
 * @since 1.0.0
 * @param string
 */
define( 'MTPT_URL',  plugin_dir_url( __FILE__ ) );

/**
 * Root Plugin dir path
 *
 * @since 1.0.0
 * @param string
 */
define( 'MTPT_PATH',  plugin_dir_path( __FILE__ ) );

/**
 * Root path to vendor dir
 *
 * @since 1.0.0
 * @param string
 */
define( 'MTPT_VENDOR_PATH', MTPT_PATH .'vendor/' );

/**
 * Root path to calderawp packages in vendor dir
 *
 * @since 1.0.0
 * @param string
 */
define( 'MTPT_CALDERAWP_PATH', MTPT_VENDOR_PATH . 'calderawp/' );

/**
 * If autoloader exists, autoload dependencies uncomment after running composer update and run plugin.
 *
 * Else return WP_ERROR
 */
$vendor_dir = MTPT_PATH . 'vendor/autoload.php';
if ( file_exists( $vendor_dir ) ) {
	require_once( $vendor_dir );



	// Load instance
	add_action( 'plugins_loaded', function() {
		require_once( MTPT_PATH . 'core-class.php' );
		new Metaplate();

	}, 13 );
}
else {
	new WP_Error( __FILE__.'no-vendor-dir', __( 'No composer vendor directory found for Caldera Metaplate.', 'metaplate' ) );
}
