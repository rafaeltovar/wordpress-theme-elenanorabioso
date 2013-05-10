<?php
/**
 * Author Box
 *
 * Displays author box with author description and thumbnail on single posts
 *
 * @package WordPress
 * @subpackage Foundation, for WordPress
 * @since Foundation, for WordPress 4.0
 */
?>

<?php if ( get_the_author_meta('description') ) : ?>

<section class="row panel radius author-box">
	<div class="small-2 large-2 columns">			
		<a href="<?php get_the_author_meta('url'); ?>"><?php echo get_avatar( get_the_author_meta('user_email'),'200' ); ?></a>
	</div>
	<div class="small-10 large-10 columns">
			<h5><?php _e('About', 'foundation' ); ?> <?php the_author_link(); ?></h5>
			<p>
				<?php echo get_the_author_meta('description'); ?>
			</p>
	</div>
		
</section>

<?php endif; ?>