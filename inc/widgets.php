<?php
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