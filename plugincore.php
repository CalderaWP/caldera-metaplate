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

define('MTPT_PATH',  plugin_dir_path( __FILE__ ) );
define('MTPT_URL',  plugin_dir_url( __FILE__ ) .'includes/caldera/metaplate' );
define('MTPT_VER',  '1.0.0' );

//autoload dependencies uncomment after running composer update
require_once( MTPT_PATH . 'vendor/autoload.php' );



// Load instance
add_action( 'plugins_loaded', function() {
	require_once( MTPT_PATH . 'core-class.php' );
	new Metaplate();

}, 13 );


//Temporary psr-4 autoloader for now
//@todo rm
add_action( 'plugins_loaded', function(){
	include_once( MTPT_PATH .'includes/classloader.php' );
	$class_loader = new Caldera_MetaPlate_Autoloader();
	$class_loader->addNamespace( 'caldera', MTPT_PATH . 'includes/caldera' );

	$class_loader->register();
	// load internals

}, 11 );

