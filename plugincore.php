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
define('MTPT_URL',  plugin_dir_url( __FILE__ ) );
define('MTPT_VER',  '1.0.0' );

//autoload dependencies uncomment after running composer update
require_once( MTPT_PATH . 'vendor/autoload.php' );

// load internals
require_once( MTPT_PATH . 'core-class.php' );
require_once( MTPT_PATH . 'includes/helpers.php' );
require_once( MTPT_PATH . 'includes/settings.php' );

// Load instance
add_action( 'plugins_loaded', array( 'Metaplate', 'get_instance' ) );
//Metaplate::get_instance();