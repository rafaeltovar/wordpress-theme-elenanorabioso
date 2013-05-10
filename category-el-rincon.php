<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage WP-Bootstrap
 * @since WP-Bootstrap 0.6
 */

get_header();

$args = array(
   	'caller_get_posts' => 1, 
	'posts_per_page' => 13,
	'paged' => $paged,
	'category__in' => array(get_cat_ID(single_cat_title( '', false )))
);

query_posts($args);

if (have_posts() ): ?>
<div class="large-9 columns" role="main">	
		<h6 class="radius label"><?php
		if ( is_day() ) {
			printf( __( 'Daily Archives: %s', 'elenanorabioso' ), '<span>' . get_the_date() . '</span>' );
		} elseif ( is_month() ) {
			printf( __( 'Monthly Archives: %s', 'elenanorabioso' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'bootstrapwp' ) ) . '</span>' );
		} elseif ( is_year() ) {
			printf( __( 'Yearly Archives: %s', 'elenanorabioso' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'bootstrapwp' ) ) . '</span>' );
		} elseif ( is_tag() ) {
			printf( __( '%s', 'bootstrapwp' ), '<span>' . single_tag_title( '', false ) . '</span>' );
					// Show an optional tag description
			$tag_description = tag_description();
			if ( $tag_description )
				echo apply_filters( 'tag_archive_meta', '<div class="tag-archive-meta">' . $tag_description . '</div>' );
		} elseif ( is_category() ) {
			printf( __( '%s', 'bootstrapwp' ), '<span>' . single_cat_title( '', false ) . '</span>' );
					// Show an optional category description
			$category_description = category_description();
			if ( $category_description )
				echo apply_filters( 'category_archive_meta', '<div class="category-archive-meta">' . $category_description . '</div>' );
		} else {
			_e( 'Hemeroteca', 'elenanorabioso' );
		}
		?></h6>
		
	<?php get_template_part( 'loop', 'blog' ); ?>
	
	<?php if ( dynamic_sidebar('Sidebar Bottom Content')) : endif; ?>
	
	<!-- pagination -->
	<div class="pagination-centered">
		<?php foundation_pagination(); ?>
	</div>
<?php endif; ?>	
</div>		
<?php get_sidebar('blog'); ?>

<?php get_footer(); ?>