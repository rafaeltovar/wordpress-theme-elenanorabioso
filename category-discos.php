<?php
/**
 * The template for displaying Archive pages.
 *
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
	<h6 class="radius label">
		<?php printf( __( '%s', 'bootstrapwp' ), '<span>' . single_cat_title( '', false ) . '</span>' ); ?>
	</h6>
		
	<!-- elemento destacado -->
	<?php the_post(); ?>
	<div id="destacado" class="row">
		<div class="small-3 large-4 columns">
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
				<?php the_post_thumbnail("elenanorabioso-home");?>
			</a>
			<h4><?php elenanorabioso_post_custom_value('discos_artista'); ?></h4>
			<h5><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" ><span><?php echo elenanorabioso_post_custom_value('discos_titulo'); ?></span></a></h5>
	
		</div>
		<div class="small-9 large-8 columns">
			<h3><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" ><span><?php the_title();?></span></a></h3>
			<?php the_excerpt(); ?>
		</div>
		<hr />
	</div> <!-- end destacado -->
	
	<ul class="grid small-block-grid-3 large-block-grid-4">
	<?php while ( have_posts() ) : the_post(); ?>
		<?php get_template_part( 'content', 'discos' ); ?>
	<?php endwhile; // end of the loop. ?>
	</ul>
	
	<?php if ( dynamic_sidebar('Sidebar Bottom Content')) : endif; ?>
	
	<!-- pagination -->
	<div class="pagination-centered">
		<?php foundation_pagination(); ?>
	</div>
<?php endif; ?>	
</div>		
<?php get_sidebar('blog'); ?>

<?php get_footer(); ?>