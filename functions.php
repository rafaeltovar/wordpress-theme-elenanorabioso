<?php

/**
 * Functions
 *
 * Core functionality and initial theme setup
 *
 * @package WordPress
 * @subpackage Elenanorabioso
 * @since Foundation, for WordPress 4.0
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
			wp_enqueue_script( 'klass', get_template_directory_uri() . '/js/photoswipe/lib/klass.min.js', null, '1.0');
			wp_enqueue_script( 'photoswipe', get_template_directory_uri() . '/js/photoswipe/code.photoswipe-3.0.5.min.js', array('klass'), '3.0.5');
			wp_enqueue_style( 'photoswipe', get_template_directory_uri().'/js/photoswipe/photoswipe.css' );
			
		}
		
		wp_enqueue_script( 'elenanorabioso', get_template_directory_uri().'/js/main.js', null, '2.1.0', true);

		// Load Stylesheets
		wp_enqueue_style( 'elenanorabioso', get_template_directory_uri().'/css/elenanorabioso.min.css' );
		wp_enqueue_style( 'general_foundicons', get_template_directory_uri().'/css/foundation_icons_general/stylesheets/general_foundicons.css' );
		wp_enqueue_style( 'social_foundicons', get_template_directory_uri().'/css/foundation_icons_social/stylesheets/social_foundicons.css' );

		wp_enqueue_style( 'app', get_stylesheet_uri(), array('elenanorabioso') );

		// Load Google Fonts API
		// TODO quitar y meter en los estilos
		//wp_enqueue_style( 'google-fonts', 'http://fonts.googleapis.com/css?family=Open+Sans:400,300' );
	
	}
}

add_action( 'wp_enqueue_scripts', 'elenanorabioso_assets' );

endif;

/**
 * Initialise Foundation JS
 * @see: http://foundation.zurb.com/docs/javascript.html
 */

if ( ! function_exists( 'foundation_js_init' ) ) :

function foundation_js_init () {
    echo '<script>$(document).foundation();</script>';
    echo '<script>$(document).elenanorabioso();</script>';
}

add_action('wp_footer', 'foundation_js_init', 50);

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

function foundation_pagination() {

global $wp_query;

$big = 999999999;

$links = paginate_links( array(
	'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	'format' => '?paged=%#%',
	'prev_next' => true,
	'prev_text' => '&laquo;',
	'next_text' => '&raquo;',
	'current' => max( 1, get_query_var('paged') ),
	'total' => $wp_query->max_num_pages,
	'type' => 'list'
)
);

$pagination = str_replace('page-numbers','pagination',$links);

echo $pagination;

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

$foundation_shortcodes = trailingslashit( get_template_directory() ) . 'inc/shortcodes.php';

if (file_exists($foundation_shortcodes)) {
	require( $foundation_shortcodes );
}

/**
 * elenanorabioso_gallery_shortcode
 *
 * codigo para personalizar la galería de los posts
 *
 * Requiere:
 *    - includes/rafaeltovar_gallery_shortcode_template.php
 */
function elenanorabioso_gallery_shortcode($attr) {
	global $post, $wp_locale;

	static $instance = 0;
	$instance++;

	// Allow plugins/themes to override the default gallery template.
	//$output = apply_filters('post_gallery', '', $attr); // TODO no funciona o algo
	if ($output != '')
		return $output;

	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}

	extract(shortcode_atts(array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post->ID,
		'columns'    => 3,
		'size'       => 'elenanorabioso-home', // image size
		'include'    => '',
		'exclude'    => ''
	), $attr));

	$id = intval($id);
	if ( 'RAND' == $order )
		$orderby = 'none';

	if ( !empty($include) ) {
		$include = preg_replace( '/[^0-9,]+/', '', $include );
		$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( !empty($exclude) ) {
		$exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
		$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	} else {
		$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	}

	if ( empty($attachments) )
		return '';

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment )
			$output .= wp_get_attachment_image($att_id, $size, true) . "\n";
		return $output;
	}

	$itemtag = tag_escape($itemtag);
	$captiontag = tag_escape($captiontag);
	$columns = intval($columns);
	$itemwidth = $columns > 0 ? floor(100/$columns) : 100;
	$float = $wp_locale->text_direction == 'rtl' ? 'right' : 'left'; 
	
	$selector = "gallery-{$instance}";
	
	ob_start();
	include(get_template_directory().'/inc/elenanorabioso_gallery_shortcode_template.php');
	$output = ob_get_clean();

	return $output;
}

add_filter('post_gallery', 'elenanorabioso_gallery_shortcode', 10, 2);

function elenanorabioso_post_custom_value($key) {
	$val = get_post_custom_values($key);
	echo $val[0];
}

/* ---------------------------------------------------
   CUSTOM WIDGETS
--------------------------------------------------- */

/**
 * Last entry widget
 *
 * Widget to show last entry of a category
 */
 
add_action('widgets_init', 'register_latest_posts_widget');

function register_latest_posts_widget() {  
    register_widget( 'LatestPosts_Widget' );  
}  
 
class LatestPosts_Widget extends WP_Widget {

	var $Template_directory;

    function LatestPosts_Widget() {  
        $widget_ops = array( 
        	'classname' => 'latestposts', 
        	'description' => __('Widget to show latest posts of a category ', 'elenanorabioso') 
        );  
        
        $control_ops = array('id_base' => 'latestposts-widget' );
        
        $this->Template_directory = get_template_directory().'/inc/latestpost-widget-templates';
        
        $this->WP_Widget( 'latestposts-widget', __('Elenanorabioso Latest Posts', 'elenanorabioso'), $widget_ops, $control_ops );  
    }
    
    // display
    function widget( $args, $instance ) {
	    extract($args); 
	    
	    $title = apply_filters('widget_title', $instance['title'] );  
		$image_size = $instance['image-size']; 
		$category = array($instance['category']);
		$num_posts = $instance['num-posts'];
		$template = $this->Template_directory."/".$instance['template-file'];
    
		$qargs = array(
    		'post_type' => 'post',
    		'caller_get_posts' => 0, 
    		'posts_per_page' => $num_posts
    	);
    	
    	if($category[0]>0) $qargs['category__in'] = $category;
	
    	query_posts($qargs);
		  
		include(get_template_directory().'/inc/elenanorabioso_latestposts_widget_display_template.php');
    }
    
    function update( $new_instance, $old_instance ) {  
    	$instance = $old_instance;  
  
    	//Strip tags from title and name to remove HTML  
    	$instance['title'] = strip_tags( $new_instance['title'] );  
    	$instance['category'] = $new_instance['category']; 
    	$instance['image-size'] = $new_instance['image-size']; 
    	$instance['num-posts'] = $new_instance['num-posts'];
    	$instance['template-file'] = strip_tags($new_instance['template-file']);
    
    	return $instance;  
    }
    
    // Control widget
    function form($instance) {
    
    	$defaults = array( 
    		'title' => '', 
    		'category' => 0,
    		'image-size' => 'elenanorabioso-header',
    		'num-posts' => 1,
    		'template-file' => 'home-template.tpl'
    	);  

    	$instance = wp_parse_args((array) $instance, $defaults);
    	
    	// get templates files
    	$templates = array();
    	
    	//get all templates files
    	$files = scandir($this->Template_directory);
    	unset($files[0], $files[1]); // delete '.' and '..' directory
 
    	foreach($files as $file) {
    		$text = file($this->Template_directory."/".$file);
    		$text = trim(str_replace('<?php /*', '', str_replace('*/ ?>', '', $text[0])));
    		$templates[] = array('file' => $file, 'name' => $text);
	    }
	    
	    // get categories
	    $categories = get_categories();
    	
	    include(get_template_directory().'/inc/elenanorabioso_latestposts_widget_control_template.php');
    }
	
}

/**
 * Last famous tags widget
 *
 * Widget to show last tags with more posts
 */
 
add_action('widgets_init', 'register_latest_tags_widget');

function register_latest_tags_widget() {  
    register_widget( 'LatestTags_Widget' );  
}  
 
class LatestTags_Widget extends WP_Widget {

	var $Template_directory;

    function LatestTags_Widget() {  
        $widget_ops = array( 
        	'classname' => 'latesttags', 
        	'description' => __('Widget to show latest famous tags ', 'elenanorabioso') 
        );  
        
        $control_ops = array('id_base' => 'latesttags-widget' );
        
        $this->Template_directory = get_template_directory().'/inc/latesttags-widget-templates';
        
        $this->WP_Widget( 'latesttags-widget', __('Elenanorabioso Latest Tags', 'elenanorabioso'), $widget_ops, $control_ops );  
    }
    
    // display
    function widget( $args, $instance ) {
    	global $wpdb;
	    extract($args); 
	    
	    $title = apply_filters('widget_title', $instance['title'] );
	    $days_interval = $instance['days-interval'];  
		$num_tags = $instance['num-tags']; 
		
		$sql = $wpdb->prepare("SELECT DISTINCT term_id FROM $wpdb->term_taxonomy
			INNER JOIN $wpdb->term_relationships ON $wpdb->term_taxonomy.term_taxonomy_id=$wpdb->term_relationships.term_taxonomy_id
			INNER JOIN $wpdb->posts ON $wpdb->posts.ID = $wpdb->term_relationships.object_id
			WHERE DATE_SUB(CURDATE(), INTERVAL %d DAY) <= $wpdb->posts.post_date AND $wpdb->term_taxonomy.taxonomy=%s", $days_interval, "post_tag");

		$term_ids = $wpdb->get_col($sql);

		if(count($term_ids) > 0){
			$tags = get_tags(array(
				'orderby' => 'count',
				'order'   => 'DESC',
				'number'  => $num_tags,
				'include' => $term_ids));
			
				include(get_template_directory().'/inc/elenanorabioso_latesttags_widget_display_template.php');
			
		} //end if		     
	}
    
    function update( $new_instance, $old_instance ) {  
    	$instance = $old_instance;  
  
    	//Strip tags from title and name to remove HTML  
    	$instance['title'] = strip_tags( $new_instance['title'] );
    	$instance['days-interval'] = $new_instance['days-interval'];
    	$instance['num-tags'] = $new_instance['num-tags'];
    
    	return $instance;  
    }
    
    // Control widget
    function form($instance) {
    
    	$defaults = array( 
    		'title' => '',
    		'days-interval' => 7, // one week 
    		'num-tags' => 5
    	);  

    	$instance = wp_parse_args((array) $instance, $defaults);
    	
	    include(get_template_directory().'/inc/elenanorabioso_latesttags_widget_control_template.php');
    }
	
}  

?>