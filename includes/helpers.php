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
class Metaplate_helpers extends Metaplate {

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
	public static function is_helper( $template, $context, $args, $source ){
	    
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
     * Execute the is Helper for Handlebars.php {{_image image_id size}}
     * based off the IfHelper
     *
     * @param \Handlebars\Template $template The template instance
     * @param \Handlebars\Context  $context  The current context
     * @param array                $args     The arguments passed the the helper
     * @param string               $source   The source
     *
     * @return mixed
     */
	public static function image_helper( $template, $context, $args, $source ){

		if( strlen( $args ) <= 0 ){
			return $context->get( 'image' );
		}
		$parts = explode(" ", $args);
		$tmp = $context->get( trim( $parts[0] ) );
		$url = wp_get_attachment_image_src( $tmp, ( !empty( $parts[1] ) ? trim( $parts[1] ) : 'thumbnail' ) );
		if( is_array( $url ) ){
			return $url[0];
		}
		
		return null;
	}


}