<?php
/**
 * Template Name: Full-width Page
 * Description: A full-width template with no sidebar
 *
 * @package WordPress
 * @subpackage WP-Bootstrap
 * @since WP-Bootstrap 0.1
 */

get_header(); ?>

    <!-- Main Content -->
    <div class="large-12 columns" role="main">

		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
			<?php endwhile; ?>
			
		<?php endif; ?>

    </div>
    <!-- End Main Content -->

<?php get_footer(); ?>