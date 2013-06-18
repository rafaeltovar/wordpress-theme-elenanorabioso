<?php
/**
 * Index
 *
 * Standard loop for the front-page
 *
 * @package WordPress
 * @subpackage Foundation, for WordPress
 * @since Foundation, for WordPress 4.0
 */

get_header(); ?>

<!-- Main Content -->
<div class="large-9 columns" role="main">
	<span class="radius label widget-title"><?php _e('Novedades', 'elenanorabioso'); ?></span>
	<?php
  	// ----> Carrousel (only if page = 1)
  	if(get_query_var('paged')==1 || !get_query_var('paged')):
  	
  			get_template_part( 'carousel' );
  			
  	endif; // end if page == 1 
  	?>

	<?php
    // ------> Blog post query
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    
    $not_category = array(
    	get_cat_ID('Breve'), 
    	get_cat_ID('Entrevistas'), 
    	get_cat_ID('New Strip on the Blog'), 
    	get_cat_ID('Discos'), 
    	get_cat_ID('El rincón')
    );
    
    $args = array(
    	'post_type' => 'post',
		'post__not_in' => get_option("sticky_posts"), 
		'caller_get_posts' => 1, 
		'posts_per_page' => 18,
		'paged' => $paged,
		'category__not_in' => $not_category
	);
	
	query_posts($args);
    
    if (have_posts()): ?>
    	<ul class="grid small-block-grid-2 large-block-grid-3">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'content'); ?>
		<?php endwhile; // end of the loop. ?>
		</ul>
	<?php else : ?>
		<h2><?php _e('No posts.', 'elenanorabioso' ); ?></h2>
		<p class="lead"><?php _e('Sorry about this, I couldn\'t seem to find what you were looking for.', 'elenanorabioso' ); ?></p>
	<?php endif; ?>

	<?php if ( dynamic_sidebar('Sidebar Bottom Content')) : endif; ?>
	
	<!-- pagination -->
	<div class="pagination-centered">
		<?php foundation_pagination(); ?>
	</div>

</div>
<!-- End Main Content -->

<?php get_sidebar('home'); ?>
<?php get_footer(); ?>