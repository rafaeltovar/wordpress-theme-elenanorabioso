<?php
/**
 *
 * Search Template
 *
 *
 * @package WP-Bootstrap
 * @subpackage Default_Theme
 * @since WP-Bootstrap 0.7
 *
 * Last Revised: January 22, 2012
 */
get_header(); ?>
<div class="large-9 columns" role="main">
	<h6 class="radius label">B&uacute;squeda</h6>
	
	<?php if ( have_posts() ) : // resultados ?>
    <header>
    	<h3><?php printf( __( 'Resultados para: %s', 'elenanorabioso' ), '<em>' . get_search_query() . '</em>' ); ?></h3>
    	<hr/>
    </header>
	<div class="row">
		<div class="large-12 columns">
		<?php while ( have_posts() ) : the_post(); ?>
			<div class="row"> <!-- item -->
				<div class="small-3 large-3 columns">
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
						<?php the_post_thumbnail("elenanorabioso-home");?>
					</a>
				</div>
				<div class="small-9 large-9 columns">
					<a href="<?php the_permalink(); ?>" title="<?php the_title();?>"><h2> <?php the_title();?></h2></a>
				</div>
				<hr/>
			</div> <!-- end item -->

		<?php endwhile; ?>
				
			<!-- pagination -->
			<div class="pagination-centered">
				<?php foundation_pagination(); ?>
			</div>
		</div>
	</div>
	<?php else : // NO se ha encontrado nada?>
	<header>
        <h1><?php _e( 'No se han encontrado resultados', 'elenanorabioso' ); ?></h1>
        <p><?php _e( 'No se han encontrado resultados con su b&uacute;squeda, pruebe con otro t&eacute;rmino.', 'elenanorabioso' ); ?></p>
     </header>
     <?php endif ;?>

			

</div><!--/.large-9 -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>