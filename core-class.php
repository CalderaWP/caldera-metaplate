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

		//set MTPT_ADMIN_TEMPLATE_PATH if not already set
		add_action( 'plugins_loaded', array(
				calderawp\metaplate\core\init::get_instance(),
				'define_admin_template_path'
			),  1
		);

		//render output
		$render = new calderawp\metaplate\core\render();
		// add filter.
		add_filter( 'the_content', array( $render, 'render_metaplate' ), 9 );

		if ( is_admin() ) {
			new calderawp\metaplate\admin\settings();
			new calderawp\metaplate\admin\page();
		}


	}

}
