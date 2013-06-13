<?php

/**
 * Functions
 *
 * Core functionality and initial theme setup
 */

/**
 * Initiate Elenenanorabioso
 */

if ( ! function_exists( 'elenanorabioso_setup' ) ) :

function elenanorabioso_setup() {

	// Content Width
	if ( ! isset( $content_width ) ) $content_width = 900;

	// Custom Editor Style Support
	add_editor_style();

	// Support for Featured Images
	add_theme_support( 'post-thumbnails' );
	
	if (function_exists( 'add_image_size' ) ) {
		add_image_size('elenanorabioso-header', 725, 350, true);
		add_image_size('elenanorabioso-home', 384, 384, true);
	}
	
	// Automatic Feed Links & Post Formats
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-formats', array('video', 'audio', 'image') );

}

add_action( 'after_setup_theme', 'elenanorabioso_setup' );

endif;

/**
 * Enqueue Scripts and Styles for Front-End
 */

if ( ! function_exists( 'elenanorabioso_assets' ) ) :

function elenanorabioso_assets() {

	if (!is_admin()) {

		/** 
		 * Deregister jQuery in favour of ZeptoJS
		 * jQuery will be used as a fallback if ZeptoJS is not compatible
		 * @see foundation_compatibility & http://foundation.zurb.com/docs/javascript.html
		 */
		wp_deregister_script('jquery');

		// Load JavaScripts
		wp_enqueue_script( 'foundation', get_template_directory_uri() . '/js/foundation.min.js', null, '4.0', true );
		wp_enqueue_script( 'modernizr', get_template_directory_uri().'/js/vendor/custom.modernizr.js', null, '2.1.0');

		if ( is_singular() ) {
			//wp_enqueue_script( "comment-reply" );			
		}
		
		wp_enqueue_script( 'elenanorabioso', get_template_directory_uri().'/js/main.js', null, '2.1.0', true);

		// Load Stylesheets
		wp_enqueue_style( 'elenanorabioso', get_template_directory_uri().'/css/elenanorabioso.min.css' );
		wp_enqueue_style( 'general_foundicons', get_template_directory_uri().'/css/foundation_icons_general/stylesheets/general_foundicons.css' );
		wp_enqueue_style( 'social_foundicons', get_template_directory_uri().'/css/foundation_icons_social/stylesheets/social_foundicons.css' );

		wp_enqueue_style( 'app', get_stylesheet_uri(), array('elenanorabioso') );
	}
}

add_action( 'wp_enqueue_scripts', 'elenanorabioso_assets' );

endif;

/**
 * Initialise Foundation JS
 * @see: http://foundation.zurb.com/docs/javascript.html
 */

if ( ! function_exists( 'elenanorabioso_js_init' ) ) :

function elenanorabioso_js_init () {
    echo '<script>$(function(){';
    echo '$(document).foundation();';
    echo '$(document).elenanorabioso();';
    echo '})</script>';
}

add_action('wp_footer', 'elenanorabioso_js_init', 50);

endif;

/**
 * ZeptoJS and jQuery Fallback
 * @see: http://foundation.zurb.com/docs/javascript.html
 */

if ( ! function_exists( 'foundation_comptability' ) ) :

function foundation_comptability () {

echo "<script>";
echo "document.write('<script src=' +";
echo "('__proto__' in {} ? '" . get_template_directory_uri() . "/js/vendor/zepto" . "' : '" . get_template_directory_uri() . "/js/vendor/jquery" . "') +";
echo "'.js><\/script>')";
echo "</script>";

}

add_action('wp_footer', 'foundation_comptability', 10);

endif;

/**
 * Register Navigation Menus
 */

if ( ! function_exists( 'elenanorabioso_menus' ) ) :

// Register wp_nav_menus
function elenanorabioso_menus() {

	register_nav_menus(
		array(
			'header-menu' => __( 'Header Menu', 'elenanorabioso' ),
			'topic-menu' => __( 'Trending Topic Menu', 'elenanorabioso' ),
			'footer-menu' => __( 'Footer Menu', 'elenanorabioso' )
			
		)
	);	
}

add_action( 'init', 'elenanorabioso_menus' );

endif;

/**
 * Featured image on feed
 */
if ( ! function_exists( 'elenanorabioso_thumbnailfeed' ) ) :

function elenanorabioso_thumbnailfeed($content) {
	global $post;
	if ( has_post_thumbnail( $post->ID ) ){
		$content = get_the_post_thumbnail( $post->ID, 'full', array('style'=>"width: 500px;") ) . ' ' . $content;
	}
	return $content;
}

//add_filter('the_excerpt_rss', 'elenanorabioso_thumbnailfeed');
//add_filter('the_content_feed', 'elenanorabioso_thumbnailfeed');

endif;

if ( ! function_exists( 'foundation_page_menu' ) ) :

function foundation_page_menu() {

	$args = array(
	'sort_column' => 'menu_order, post_title',
	'menu_class'  => 'large-12 columns',
	'include'     => '',
	'exclude'     => '',
	'echo'        => true,
	'show_home'   => false,
	'link_before' => '',
	'link_after'  => ''
	);

	wp_page_menu($args);

}

endif;

if ( ! function_exists( 'elenanorabioso_topic_menu' ) ) :

function elenanorabioso_topic_menu() {

	$args = array(
	'sort_column' => 'menu_order, post_title',
	'menu_class'  => 'list-inline',
	'include'     => '',
	'exclude'     => '',
	'echo'        => true,
	'show_home'   => false,
	'link_before' => '<h2>',
	'link_after'  => '</h2>'
	);

	wp_page_menu($args);

}

endif;

/**
 * Navigation Menu Adjustments
 */

// Add class to navigation sub-menu
class foundation_navigation extends Walker_Nav_Menu {

function start_lvl(&$output, $depth) {
	$indent = str_repeat("\t", $depth);
	$output .= "\n$indent<ul class=\"dropdown\">\n";
}

function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
	$id_field = $this->db_fields['id'];
	if ( !empty( $children_elements[ $element->$id_field ] ) ) {
		$element->classes[] = 'has-dropdown';
	}
		Walker_Nav_Menu::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}
}

/**
 * Create pagination
 */

if ( ! function_exists( 'foundation_pagination' ) ) :

function foundation_pagination( $p = 2 ) {
	if ( is_singular() ) return;
	
	global $wp_query, $paged;
	$pagination = '';
	
	$max_page = $wp_query->max_num_pages;
	if ( $max_page == 1 ) return;
	if ( empty( $paged ) ) $paged = 1;
	if ( $paged > $p + 1 ) $pagination.= p_link( 1, 'First' );
	if ( $paged > $p + 2 ) $pagination .= '<li class="unavailable"><a href="#">&hellip;</a></li>';
	for( $i = $paged - $p; $i <= $paged + $p; $i++ ) { // Middle pages
		if ( $i > 0 && $i <= $max_page ) 
			$pagination .= ($i == $paged ? "<li class='current'><a href='#'>{$i}</a></li> " : p_link( $i ));
	}
	if ( $paged < $max_page - $p - 1 ) $pagination.= '<li class="unavailable"><a href="#">&hellip;</a></li>';
	if ( $paged < $max_page - $p ) $pagination.= p_link( $max_page, 'Last' );
	
	$pagination = '<ul class="pagination">'. $pagination .'</ul>';
	echo $pagination; 
}

function p_link( $i, $title = '' ) {
	if ( $title == '' ) $title = "Page {$i}";
	return "<li><a href='". esc_html( get_pagenum_link( $i ) ) ."' title='{$title}'>{$i}</a></li> ";
}

endif;

/**
 * Register Sidebars
 */

if ( ! function_exists( 'elenanorabioso_widgets' ) ) :

function elenanorabioso_widgets() {

	// Sidebar Top Header
	register_sidebar( array(
			'id' => 'elenanorabioso_sidebar_top_header',
			'name' => __( 'Sidebar Top Header', 'elenanorabioso' ),
			'description' => __( 'This sidebar is located in the top of the navigation.', 'elenanorabioso' ),
			'before_widget' => '<div class="hide-for-small  top-sidebar">',
			'after_widget' => '</div>',
			'before_title' => '<h5>',
			'after_title' => '</h5>',
		) );
	
	// Sidebar Bottom Header One
	register_sidebar( array(
			'id' => 'elenanorabioso_sidebar_bottom_header_one',
			'name' => __( 'Sidebar Bottom Header One', 'elenanorabioso' ),
			'description' => __( 'This sidebar is located in the bottom of the navigation.', 'elenanorabioso' ),
			'class' => 'sidebar-bottom-header-one',
			'before_widget' => '<div id="%1$s" class="widget %2$s large-9 columns">',
			'after_widget' => '</div>',
			'before_title' => '<ul><li class="widget-title">',
			'after_title' => '</li></ul>',
		) );

	// Sidebar Bottom Header Two
	register_sidebar( array(
			'id' => 'elenanorabioso_sidebar_bottom_header_two',
			'name' => __( 'Sidebar Bottom Header Two', 'elenanorabioso' ),
			'description' => __( 'This sidebar is located in the bottom of the navigation.', 'elenanorabioso' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s large-3 columns">',
			'after_widget' => '</div>',
			'before_title' => '<h5>',
			'after_title' => '</h5>',
		) );
	
	// Sidebar Bottom Header Three
	register_sidebar( array(
			'id' => 'elenanorabioso_sidebar_bottom_header_three',
			'name' => __( 'Sidebar Bottom Header Three', 'elenanorabioso' ),
			'description' => __( 'This sidebar is located in the bottom of sidebar one and two.', 'elenanorabioso' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s large-12 columns">',
			'after_widget' => '</div>',
			'before_title' => '<h5>',
			'after_title' => '</h5>',
		) );
		
	// Sidebar Right Home
	register_sidebar( array(
			'id' => 'elenanorabioso_sidebar_right_home',
			'name' => __( 'Home Sidebar Right', 'elenanorabioso' ),
			'description' => __( 'This sidebar is located on the right-hand side of home page.', 'elenanorabioso' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h6 class="radius label widget-title">',
			'after_title' => '</h6>',
		) );

	// Sidebar Right
	register_sidebar( array(
			'id' => 'elenanorabioso_sidebar_right',
			'name' => __( 'Sidebar Right', 'elenanorabioso' ),
			'description' => __( 'This sidebar is located on the right-hand side of each page.', 'elenanorabioso' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h6 class="radius label widget-title">',
			'after_title' => '</h6>',
		) );
	
	// Sidebar Bottom Content
	register_sidebar( array(
			'id' => 'elenanorabioso_sidebar_bottom_content',
			'name' => __( 'Sidebar Bottom Content', 'elenanorabioso' ),
			'description' => __( 'This sidebar is located on the bottom of content of each page.', 'elenanorabioso' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h6 class="radius label widget-title">',
			'after_title' => '</h6>',
		) );
		
	// Sidebar Footer Column
	register_sidebar( array(
			'id' => 'elenanorabioso_sidebar_footer',
			'name' => __( 'Sidebar Footer', 'elenanorabioso' ),
			'description' => __( 'This sidebar is located in column one of your theme footer.', 'elenanorabioso' ),
			'before_widget' => '<div class="large-3 columns">',
			'after_widget' => '</div>',
			'before_title' => '<h5>',
			'after_title' => '</h5>',
		) );

	}

add_action( 'widgets_init', 'elenanorabioso_widgets' );

endif;

/**
 * Custom Avatar Classes
 */
if ( ! function_exists( 'foundation_avatar_css' ) ) :

function foundation_avatar_css($class) {
	$class = str_replace("class='avatar", "class='author_gravatar left ", $class) ;
	return $class;
}

add_filter('get_avatar','foundation_avatar_css');

endif;

/**
 * Custom Post Excerpt
 */

if ( ! function_exists( 'elenanorabioso_excerpt' ) ) :

function elenanorabioso_excerpt($text) {
        global $post;
        if ( '' == $text ) {
                $text = get_the_content('');
                $text = apply_filters('the_content', $text);
                $text = str_replace('\]\]\>', ']]&gt;', $text);
                $text = preg_replace('@<script[^>]*?>.*?</script>@si', '', $text);
                $text = strip_tags($text, '<p>');
                $excerpt_length = 60;
                $words = explode(' ', $text, $excerpt_length + 1);
                if (count($words)> $excerpt_length) {
                        array_pop($words);
                        array_push($words, '<br><br><a href="'.get_permalink($post->ID) .'" class="right radius button small">' . __('Continuar leyendo...', 'elenanorabioso') . '</a>');
                        $text = implode(' ', $words);
                }
        }
        return $text;
}

remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'elenanorabioso_excerpt');

endif;

/** 
 * Comments Template
 */

if ( ! function_exists( 'foundation_comment' ) ) :

function foundation_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'foundation' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'foundation' ), '<span>', '</span>' ); ?></p>
	<?php
		break;
		default :
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<header>
				<?php
					echo "<span class='th alignleft' style='margin-right:1rem;'>";
					echo get_avatar( $comment, 44 );
					echo "</span>";
					printf( '%2$s %1$s',
						get_comment_author_link(),
						( $comment->user_id === $post->post_author ) ? '<span class="label">' . __( 'Post Author', 'foundation' ) . '</span>' : ''
					);
					printf( '<br><a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						sprintf( __( '%1$s at %2$s', 'foundation' ), get_comment_date(), get_comment_time() )
					);
				?>
			</header>

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p><?php _e( 'Your comment is awaiting moderation.', 'foundation' ); ?></p>
			<?php endif; ?>

			<section>
				<?php comment_text(); ?>
			</section><!-- .comment-content -->

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'foundation' ), 'after' => ' &darr; <br><br>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>

			</div>
		</article>
	<?php
		break;
	endswitch;
}
endif;

/**
 * Custom function for print custom value
 */
if ( ! function_exists( 'elenanorabioso_post_custom_value' ) ) :
function elenanorabioso_post_custom_value($key) {
	$val = get_post_custom_values($key);
	echo $val[0];
}
endif;

/**
 * Remove Class from Sticky Post
 */

if ( ! function_exists( 'foundation_remove_sticky' ) ) :

function foundation_remove_sticky($classes) {
  $classes = array_diff($classes, array("sticky"));
  return $classes;
}

add_filter('post_class','foundation_remove_sticky');

endif;

/**
 * Retrieve Shortcodes
 * @see: http://fwp.drewsymo.com/shortcodes/
 */
$elenanorabioso_shortcodes = trailingslashit( get_template_directory() ) . 'inc/shortcodes.php';

if (file_exists($elenanorabioso_shortcodes)) {
	require( $elenanorabioso_shortcodes );
}

/**
 * Retrieve Widgets
 */
$elenanorabioso_widgets = trailingslashit( get_template_directory() ) . 'inc/widgets.php';

if (file_exists($elenanorabioso_widgets)) {
	require($elenanorabioso_widgets);
}

/**
 * Add Metabox for Conciertos and Discos
 */
 
 /**
 * Calls the class on the post edit screen
 */
function elenanorabioso_add_discos_metabox() { return new ElenanorabiosoDiscosMetaBox(); }
//function elenanorabioso_add_conciertos_metabox() { return new ElenanorabiosoConciertosMetaBox(); }

// Quitar campos en la edición que no es necesario
function elenanorabioso_remove_metaboxes() {
 remove_meta_box( 'postcustom' , 'post' , 'normal' ); //removes custom fields for page
 remove_meta_box( 'commentstatusdiv' , 'post' , 'normal' ); //removes comments status for page
 remove_meta_box( 'commentsdiv' , 'post' , 'normal' ); //removes comments for page
 remove_meta_box( 'trackbacksdiv' , 'post' , 'normal' );
 //remove_meta_box( 'authordiv' , 'post' , 'normal' ); //removes author for page
}

if (is_admin()) { 
	add_action( 'admin_init', 'elenanorabioso_add_discos_metabox' );
	
	// Quitar campos en la edición que no es necesario
	add_action( 'admin_menu' , 'elenanorabioso_remove_metaboxes' );
}

/** 
 * ElenanorabiosoDiscosMetaBox
 */
class ElenanorabiosoDiscosMetaBox {

    var $fields;
    var $fields_key;
    
    public function __construct() {
        //add_action( 'add_meta_boxes', array( &$this, 'add_meta_box' ) );
        //registering this metabox
		add_action( 'add_meta_boxes', array(&$this, '_register') );
		
		add_action( 'save_post', array(&$this, '_save') );
		
		// TODO fields
		$this->fields_key = "discos";
		$this->fields = array("_artista", "_titulo", "_discografica", "_year");
    }

    /**
     * Adds the meta box container
     */
    public function _register() {
        add_meta_box( 
             'some_meta_box_name',
             __('Informaci&oacute;n de discos (opcional)', 'elenanorabioso'),
            array( &$this, '_render' ),
            'post',
            'normal',
            'high'
        );
    }

    /**
     * Render Meta Box content
     */
    public function _render($post) {
    	$values = get_post_meta($post->ID);
    	include(get_template_directory().'/inc/elenanorabioso_discos_metabox_template.php'); 
    }
    
    /**
     * Save Meta Box content
     */
    public function _save($post_id) {	
    	// First we need to check if the current user is authorised to do this action. 
    	if ( 'page' == $_POST['post_type'] ) {
	    	if ( ! current_user_can( 'edit_page', $post_id ) ) return;
	    } else {
		    if ( ! current_user_can( 'edit_post', $post_id ) ) return;
		}

  		$post_ID = $_POST['post_ID'];
  		
  		// save data if have content
  		foreach($this->fields as $field) {
	  		$f = $this->fields_key.$field;
	  		if(isset($_POST[$f]) && $_POST[$f]!='') {
	  			$mydata = sanitize_text_field($_POST[$f]);
		  		add_post_meta($post_ID, $f, $mydata, true) or
		  			update_post_meta($post_ID, $f, $mydata);
	  		} // end if
  		}
    }
} 

?>