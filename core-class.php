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
	 * @var      string
	 */
	protected $plugin_slug = 'metaplate';
	/**
	 * @var      object
	 */
	protected static $instance = null;
	/**
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;
	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 */
	private function __construct() {

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Activate plugin when new blog is added
		add_action( 'wpmu_new_blog', array( $this, 'activate_new_site' ) );

		// Load admin style sheet and JavaScript.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_stylescripts' ) );

		// add filter.
		add_filter( 'the_content', array( $this, 'render_metaplate' ), 11 );
	}

	/**
	 * get the metaplates for the post
	 *
	 *
	 * @return    array    active metaplates for this post type
	 */
	private static function get_active_metaplates( ) {
		
		global $post;

		// GET METAPLATEs
		$metaplates = get_option( '_metaplates_registry' );
		$meta_stack = array();
		foreach( $metaplates as $metaplate_try ){
			$is_plate = get_option( $metaplate_try['id'] );
			if( !empty( $is_plate['post_type'][$post->post_type] ) ){
				switch ($is_plate['page_type']) {
					case 'single':
						if( is_single() ){
							$meta_stack[] = $is_plate;
						}
						break;
					case 'archive':
						if( !is_single() ){
							$meta_stack[] = $is_plate;
						}
						break;
					default:
						$meta_stack[] = $is_plate;
						break;
				}					
			}
		}

		return $meta_stack;

	}
	/**
	 * Return the content with metaplate applied.
	 *
	 *
	 * @return    string    rendered HTML with templates applied
	 */
	public static function render_metaplate( $content ) {

			global $post;
				
			$meta_stack = $this->get_active_metaplates();
			if( empty( $meta_stack ) ){
				return $content;
			}

			$style_data = null;
			$script_data = null;
			
			$raw_template_data = get_post_meta( $post->ID  );

			// break to standard arrays
			$template_data = array();
			foreach( $raw_template_data as $meta_key=>$meta_data ){
				if( count( $meta_data ) === 1 ){
					if( strlen( trim( $meta_data[0] ) ) > 0 ){ // check value is something else leave it out.
						$template_data[$meta_key] = trim( $meta_data[0] );
					}
				}else{
					$template_data[$meta_key] = $meta_data;
				}
			}
			// ACF support
			if( class_exists( 'acf' ) ){
				$template_data = array_merge( $template_data, get_fields( $post->ID ) );
			}
			// CFS support
			if( class_exists( 'Custom_Field_Suite' ) ){
				$template_data = array_merge( $template_data, CFS()->get() );
			}

			// include post values
			foreach( $post as $post_key=>$post_value ){
				$template_data[$post_key] = $post_value;
			}

			$engine = new Handlebars;

			foreach( $meta_stack as $metaplate ){
				// check CSS
				$style_data .= $engine->render( $metaplate['css']['code'], $template_data );
				// check JS
				$script_data .= $engine->render( $metaplate['js']['code'], $template_data );

				switch ( $metaplate['placement'] ){
					case 'prepend':
						$content = $engine->render( $metaplate['html']['code'], $template_data ) . $content;
						break;
					case 'append':
						$content .= $engine->render( $metaplate['html']['code'], $template_data );
						break;
					case 'replace':
						$content = $engine->render( str_replace( '{{content}}', $content, $metaplate['html']['code']), $template_data );
						break;
				}
			}
			
			// insert CSS
			if( !empty( $style_data ) ){
				$content = '<style>' . $style_data . '</style>' . $content;
			}
			// insert JS
			if( !empty( $script_data ) ){
				$content .= '<script type="text/javascript">' . $script_data . '</script>';
			}

			return do_shortcode( $content );
		}

	/**
	 * Return an instance of this class.
	 *
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog.
	 */
	public static function activate( $network_wide ) {
		if ( function_exists( 'is_multisite' ) && is_multisite() ) {
			if ( $network_wide  ) {
				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {
					switch_to_blog( $blog_id );
					self::single_activate();
				}
				restore_current_blog();
			} else {
				self::single_activate();
			}
		} else {
			self::single_activate();
		}
	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses "Network Deactivate" action, false if WPMU is disabled or plugin is deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {
		if ( function_exists( 'is_multisite' ) && is_multisite() ) {
			if ( $network_wide ) {
				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {
					switch_to_blog( $blog_id );
					self::single_deactivate();
				}
				restore_current_blog();
			} else {
				self::single_deactivate();
			}
		} else {
			self::single_deactivate();
		}
	}

	/**
	 * Fired when a new site is activated with a WPMU environment.
	 *
	 *
	 * @param	int	$blog_id ID of the new blog.
	 */
	public function activate_new_site( $blog_id ) {
		if ( 1 !== did_action( 'wpmu_new_blog' ) )
			return;

		switch_to_blog( $blog_id );
		self::single_activate();
		restore_current_blog();
	}

	/**
	 * Get all blog ids of blogs in the current network that are:
	 * - not archived
	 * - not spam
	 * - not deleted
	 *
	 *
	 * @return	array|false	The blog ids, false if no matches.
	 */
	private static function get_blog_ids() {
		global $wpdb;

		// get an array of blog ids
		$sql = "SELECT blog_id FROM $wpdb->blogs
			WHERE archived = '0' AND spam = '0'
			AND deleted = '0'";
		return $wpdb->get_col( $sql );
	}

	/**
	 * Fired for each blog when the plugin is activated.
	 *
	 */
	private static function single_activate() {
		// TODO: Define activation functionality here if needed
	}

	/**
	 * Fired for each blog when the plugin is deactivated.
	 *
	 */
	private static function single_deactivate() {
		// TODO: Define deactivation functionality here needed
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain( $this->plugin_slug, FALSE, basename( MTPT_PATH ) . '/languages');

	}
	
	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 *
	 * @return    null
	 */
	public function enqueue_admin_stylescripts() {

		$screen = get_current_screen();

		
		if( false !== strpos( $screen->base, 'metaplate' ) ){

			wp_enqueue_style( 'metaplate-core-style', MTPT_URL . '/assets/css/styles.css' );
			wp_enqueue_style( 'metaplate-baldrick-modals', MTPT_URL . '/assets/css/modals.css' );
			wp_enqueue_script( 'metaplate-wp-baldrick', MTPT_URL . '/assets/js/wp-baldrick-full.js', array( 'jquery' ) , false, true );
			wp_enqueue_script( 'jquery-ui-autocomplete' );
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );
						
			if( !empty( $_GET['edit'] ) ){
				wp_enqueue_style( 'metaplate-codemirror-style', MTPT_URL . '/assets/css/codemirror.css' );
				wp_enqueue_script( 'metaplate-codemirror-script', MTPT_URL . '/assets/js/codemirror.js', array( 'jquery' ) , false );
			}

			wp_enqueue_script( 'metaplate-core-script', MTPT_URL . '/assets/js/scripts.js', array( 'metaplate-wp-baldrick' ) , false );

		
		}


	}


}















