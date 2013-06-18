<?php
/**
 * Content Single
 *
 * Loop content in single post template (single.php)
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header>
		<hgroup>
			<?php if ( has_post_thumbnail() && !in_category(get_cat_ID('Discos'))) : ?>
				<?php the_post_thumbnail('elenanorabioso-header'); ?>
			<?php endif; ?>
			<h1><?php the_title(); ?></h1>
		</hgroup>
	</header>
	
	<div class="row">
		<div class="meta large-2 columns"> <!--meta -->
			<div class="row">
				<div class="large-12 columns"><span class="radius label"><?php the_category(', '); ?></span></div>
				<div class="small-6 large-12 columns"><h5><?php the_time(get_option('date_format')); ?></h5></div>
				<div class="small-6 large-12 columns author"><h6><?php _e('Por', 'elenanorabioso' );?> <?php the_author_link(); ?></h6></div>	
				<div class="large-12 columns"><?php the_tags('<span class="tag radius secondary label">','</span> <span class="tag radius secondary label">','</span>'); ?></div>
				<?php if( function_exists('do_sociable')): ?>
					<div class="social-buttons large-12 columns">
						<?php do_sociable(); ?>
					</div>
				<?php endif; ?>
			</div>
			<hr />
		</div> <!-- end meta -->
		<div class="large-10 columns"> <!-- content -->
			<?php if(in_category(get_cat_ID('Discos'))): ?>
				<div id="portada-discos" class="alignright">
					<?php the_post_thumbnail('medium', array('class'=>'img-discos th')); ?>
					<div class="text-discos">
						<h4><?php echo elenanorabioso_post_custom_value('discos_artista'); ?></h4>
						<h3><em><span><?php elenanorabioso_post_custom_value('discos_titulo'); ?></span></em></h3>
						<?php if(get_post_custom_values('discos_discografica')!=''): ?>
							<p class="metadata-discos">
								<span class="discografica">
									<em><?php elenanorabioso_post_custom_value('discos_discografica'); ?></em>
								</span>, 
								<span class="year"><?php elenanorabioso_post_custom_value('discos_year'); ?></span>
							</p>
						<?php endif; ?>  
					<hr />
					</div>
				</div>
			<?php endif; ?>
			<?php the_content(); ?>
		</div>
	</div>

	<footer>
	<?php //comments_template(); ?>

		<p><?php wp_link_pages(); ?></p>

		<?php // TODO get_template_part('author-box'); ?>
		
	</footer>
</article>
