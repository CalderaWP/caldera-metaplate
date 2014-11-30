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
	 * @var      array
	 */
	protected $plugin_screen_hook_suffix = array();
	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 */
	private function __construct() {

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

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
	 * merge in ACF, CFS fields, meta and post data
	 *
	 *
	 * @return    array    array with merged data
	 */
	private static function get_custom_field_data( $raw_data ) {

		global $post;

		// break to standard arrays
		$template_data = array();
		foreach( $raw_data as $meta_key=>$meta_data ){
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

		return $template_data;
	}

    /**
     * Execute the is Helper for Handlebars.php {{#is variable value}} code {{else}} alt code {{/is}}
     * based off the IfHelper
     *
     * @param \Handlebars\Template $template The template instance
     * @param \Handlebars\Context  $context  The current context
     * @param array                $args     The arguments passed the the helper
     * @param string               $source   The source
     *
     * @return mixed
     */
	public function is_helper( $template, $context, $args, $source ){
	    
	    $parts = explode(' ', $args);
	    $args = $parts[0];
	    $value = $parts[1];

	    if (is_numeric($args)) {
	        $tmp = $args;
	    } else {
	        $tmp = $context->get($args);
	    }

	    $context->push($context->last());
	    if ($tmp === $value) {
	        $template->setStopToken('else');
	        $buffer = $template->render($context);
	        $template->setStopToken(false);
	        $template->discard($context);
	    } else {
	        $template->setStopToken('else');
	        $template->discard($context);
	        $template->setStopToken(false);
	        $buffer = $template->render($context);
	    }
	    $context->pop();

	    return $buffer;
	}

	/**
	 * Return the content with metaplate applied.
	 *
	 *
	 * @return    string    rendered HTML with templates applied
	 */
	public function render_metaplate( $content ) {

			global $post;
				
			$meta_stack = self::get_active_metaplates();
			if( empty( $meta_stack ) ){
				return $content;
			}

			$style_data = null;
			$script_data = null;
			
			$raw_template_data = get_post_meta( $post->ID  );
			$template_data = self::get_custom_field_data( $raw_template_data );
			

			$engine = new Handlebars;
			
			$engine->addHelper( 'is', array( $this, 'is_helper' ) );

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















