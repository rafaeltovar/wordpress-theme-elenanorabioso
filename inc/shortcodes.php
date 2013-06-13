<?php

/**
 * Shortcodes
 *
 * Setup theme shortcodes
 *
 * @package WordPress
 * @subpackage Foundation, for WordPress
 * @since Foundation, for WordPress 1.0
 */

/**
 * Initialise Foundation, for WordPress Shortcodes
 */

// Allow shortcodes in widgets

add_filter('widget_text', 'do_shortcode');

/**
 * Grid
 */

// Rows [row][/row]

function foundation_shortcode_row( $atts, $content = null ) {
   return '<div class="row">' . do_shortcode($content) . '</div>';
}

add_shortcode( 'row', 'foundation_shortcode_row' );

// Columns [column][/column]

function foundation_shortcode_column( $atts, $content = null ) {

	extract( shortcode_atts( array(
		'center' => '',
		'span' => '',
		), $atts ) );

	// Set the 'center' variable
	if ($center == 'true') {
	$center = 'centered';
	}

	return '<div class="' . esc_attr($span) . ' columns ' . esc_attr($center) .'">' . do_shortcode($content) . '</div>';
}

add_shortcode( 'column', 'foundation_shortcode_column' );

/**
 * UI
 */

// Buttons [button][/button]

function foundation_shortcode_button( $atts, $content = null ) {

	extract( shortcode_atts( array(
		'link' => '#',
		'size' => 'medium',
		'type' => '',
		'style' => '',
		'reveal' => ''
		), $atts ) );

		if (!$reveal == null) {
			$reveal_data = 'data-reveal-id=' . $reveal . ' ';
		}

	return '<a ' . $reveal_data . ' href="' . esc_attr($link) . '" class="' . esc_attr($size) . ' ' . esc_attr($style) . ' ' . esc_attr($type) . ' button">' . $content . '</a>';
}

add_shortcode( 'button', 'foundation_shortcode_button' );

// Alerts [alert][/alert]

function foundation_shortcode_alert( $atts, $content = null ) {

	extract( shortcode_atts( array(
		'type' => ''
		), $atts ) );

	return '<div data-alert class="alert-box ' . esc_attr($type) . '">' . do_shortcode($content) . ' <a href="" class="close">&times;</a> </div>';
}

add_shortcode( 'alert', 'foundation_shortcode_alert' );

// Panels [panel][/panel]

function foundation_shortcode_panel( $atts, $content = null ) {

	extract( shortcode_atts( array(
		'type' => '',
		'style' => ''
		), $atts ) );

	return '<div class="panel ' . esc_attr($type) . ' ' . esc_attr($style) . '">' . do_shortcode($content) . '</div>';
}

add_shortcode( 'panel', 'foundation_shortcode_panel' );

/**
 * Elements
 */

// Detection (Show) [show][/show]

function foundation_shortcode_show( $atts, $content = null ) {

	extract( shortcode_atts( array(
		'for' => ''
		), $atts ) );

	return '<div class="show-for-' . esc_attr($for) . '">' . do_shortcode($content) . '</div>';
}

add_shortcode( 'show', 'foundation_shortcode_show' );

// Detection (Hide) [hide][/hide]

function foundation_shortcode_hide( $atts, $content = null ) {

	extract( shortcode_atts( array(
		'for' => ''
		), $atts ) );

	return '<div class="hide-for-' . esc_attr($for) . '">' . do_shortcode($content) . '</div>';
}

add_shortcode( 'hide', 'foundation_shortcode_hide' );

/**
 * Extras
 */

// Reveal [reveal][/reveal]

function foundation_shortcode_reveal( $atts, $content = null ) {

	extract( shortcode_atts( array(
		'name' => '',
		'style' => ''
		), $atts ) );

	return '<div id="' . esc_attr($name) . '" class="reveal-modal ' . esc_attr($style) . '">' . do_shortcode($content) . '</div>';

}

add_shortcode( 'reveal', 'foundation_shortcode_reveal' );

// Sections [sections type="tabs"] [section title="Section Title"]Content[/section] [/sections]

function foundation_shortcode_sections( $atts, $content = null ) {

	extract( shortcode_atts( array(
		'type' => ''
		), $atts ) );

	return '<div class="section-container '. esc_attr($type) . '" data-section="'. esc_attr($type) . '">' . do_shortcode($content) . '</div>';

}

add_shortcode( 'sections', 'foundation_shortcode_sections' );

// Section [section title="Section Title"]Content[/section]

function foundation_shortcode_section( $atts, $content = null ) {

	extract( shortcode_atts( array(
		'title' => ''
		), $atts ) );

	return '<section><p class="title" data-section-title><a href="#">Section 1</a></p><div class="content" data-section-content>' . do_shortcode($content) . '</div></section>';

}

add_shortcode( 'section', 'foundation_shortcode_section' );


/**
 * Gallery shortcode [gallery ...]
 *
 * Codigo para personalizar la galería de los posts
 * 
 * TODO
 * [] - Add when 'link' => 'post' (and not javasript)
 * [] - Add when 'orderby' => 'rand'
 * 
 *
 * Require:
 *    - elenanorabioso_gallery_shortcode_template.php
 *    - elenanorabioso_gallery_shortcode_onecolumn_template.php
 *    - Magnific popup javascript (http://dimsemenov.com/plugins/magnific-popup/)
 */
function elenanorabioso_gallery_shortcode($attr) {
	//global $post, $wp_locale;
	static $instance = 0;
	static $js = 0;
	
	$instance++;
		
	$defaults = array(
    	'columns' => 4,
        'size' => 'elenanorabioso-home',
        'link' => 'file',
        'ids' => '',
        'orderby' => ''
    );
        
	$attr = shortcode_atts($defaults, $attr);
    extract($attr); // extraigo las variables del array
    
    // Comprobamos que el shortcode tiene las ids ed las imagenes,
    // si no la tuviera habría que coger todas las imagens adjuntas al artículo
    if(!empty($ids)) { 
    	$ids = explode(',', $ids); // extraigo los ids de las imagenes
    }
    
    $images = _elenanorabioso_gallery_shortcode_get_images($ids);

	$selector = "gallery-{$instance}";
		
	ob_start();
	if($columns>1) {
		// Javascript
		if(!$js) {
			wp_enqueue_style( 'magnific-popup', get_template_directory_uri().'/js/magnific-popup/magnific-popup.css' );
			wp_enqueue_script( 'magnific-popup', get_template_directory_uri() . '/js/magnific-popup/jquery.magnific-popup.min.js', null, '0.8.8', true);
			add_action('wp_footer', '_elenanorabioso_gallery_shortcode_js', 55);
			$js++;
		}
		
		include(get_template_directory().'/inc/elenanorabioso_gallery_shortcode_template.php');
	} else
		include(get_template_directory().'/inc/elenanorabioso_gallery_shortcode_onecolumn_template.php');
	
	$output = ob_get_clean();
	
	return $output;
}

function _elenanorabioso_gallery_shortcode_get_images($ids = '') {
	global $post;
	
	// Comprobamos que el shortcode tiene las ids ed las imagenes,
    // si no la tuviera habría que coger todas las imagens adjuntas al artículo
	if(empty($ids)) {
		// Busco todas las imagenes adjuntas al post
		$attachments = get_children(array(
							'post_parent' => $post->ID, 
							'post_status' => 'inherit', 
							'post_type' => 'attachment', 
							'post_mime_type' => 'image') 
					);
	
		if (!empty($attachments)) {
			$ids = array();
			foreach ( $attachments as $id => $attachment ) {
				$ids[] = $id;
			}
		}
	} // end if empty $ids
	
	$image_sizes = get_intermediate_image_sizes(); // Obtengo todos los tamanyos disponibles de imagenes
	
	$images = array();
    foreach($ids as $id) {
    	$image = array (
    		'id' => $id,
    		'alt' => get_post_meta($id,'_wp_attachment_image_alt', true),
    		'src_full' => wp_get_attachment_image_src($id, 'full')
    	);
    	
    	foreach($image_sizes as $sizes)
    		$image['src_'.$sizes] = wp_get_attachment_image_src($id, $sizes);
    	
    	$images[] = $image;
    }
    
    return $images;
}

function _elenanorabioso_gallery_shortcode_js() {
	global $instance;
	echo "<script type=\"text/javascript\">$('.gallery').magnificPopup({
		  delegate: 'a', // child items selector, by clicking on it popup will open
		  type: 'image',
		  fixedContentPos: true, // fix problem of gallery with android
		  gallery: {
			enabled: true, // set to true to enable gallery
			preload: [0,2], // read about this option in next Lazy-loading section
			navigateByImgClick: true,
			arrowMarkup: '<button title=\"%title%\" type=\"button\" class=\"mfp-arrow mfp-arrow-%dir%\"></button>', // markup of an arrow button
			tCounter: '' // markup of counter
		},
		image: {
			titleSrc: 'title' // options for image content type
		}
	});</script>";
}


remove_shortcode('gallery');
add_shortcode('gallery', 'elenanorabioso_gallery_shortcode');

/** END GALLERY SHORTCODE **/

?>