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
 * Version:     1.0.0
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
//set paths
define('MTPT_PATH',  plugin_dir_path( __FILE__ ) );
define('MTPT_URL',  plugin_dir_url( __FILE__ ) . '/vendor/calderawp/metaplate-admin-assets/src/assets/'   );
define('MTPT_VER',  '1.0.0' );

//autoload dependencies uncomment after running composer update
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



