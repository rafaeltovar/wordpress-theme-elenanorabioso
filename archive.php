<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 */

get_header();
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
	<!-- elemento destacado -->
	<?php the_post(); ?>
	<div id="destacado" class="row">
		<div class="large-12 columns">
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
				<?php the_post_thumbnail("elenanorabioso-header");?>
			</a>
			<h3><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" ><span><?php the_title();?></span></a></h3>
			<?php the_excerpt(); ?>
			<hr />
		</div>
	</div>
	
	<ul class="grid small-block-grid-2 large-block-grid-3">
	<?php while ( have_posts() ) : the_post(); ?>
		<?php get_template_part( 'content'); ?>
	<?php endwhile; // end of the loop. ?>
	</ul>
	
	<?php if ( dynamic_sidebar('Sidebar Bottom Content')) : endif; ?>
	
	<!-- pagination -->
	<div class="pagination-centered">
		<?php foundation_pagination(); ?>
	</div>
<?php endif; ?>	
</div>		
<?php get_sidebar(); ?>

<?php get_footer(); ?>