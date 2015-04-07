<?php

/**
 * Metaplate.
 *
 * @package   Metaplate
 * @author    David <david@digilab.co.za>
 * @license   GPL-2.0+
 * @link
 * @copyright 2014 David
 */

use Handlebars\Handlebars;

/**
 * Plugin class.
 * @package Metaplate
 * @author  David <david@digilab.co.za>
 */
class Metaplate {

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 */
	function __construct() {

		// Load plugin text domain
		add_action( 'init', array(
				calderawp\metaplate\core\init::get_instance(),
				'load_plugin_textdomain'
			)
		);

		// detect metaplates then bind meta content
		add_action( 'wp', array( $this, 'detect_content' ) );

		// shortcode
		add_shortcode( 'caldera_metaplate', 'caldera_metaplate_shortcode' );

		if ( is_admin() ) {
			new calderawp\metaplate\admin\settings();
			new calderawp\metaplate\admin\page();
		}


	}

	/**
	 * Check posts content from wp_query and place a metaplate tag when theres no content.
	 *
	 */
	public function detect_content(){
		global $wp_query;
		
		$meta_stack = calderawp\metaplate\core\data::get_active_metaplates();

		if( empty( $meta_stack ) ){ return; }

		// add filter.
		//render output
		$render = new calderawp\metaplate\core\render();
		add_filter( 'the_content', array( $render, 'render_metaplate' ), 10.5 );

		foreach( $wp_query->posts as &$post ){
			if( empty( $post->post_content ) ){
				$post->post_content = '<!--metaplate-->';
			}
		}

	}


}
