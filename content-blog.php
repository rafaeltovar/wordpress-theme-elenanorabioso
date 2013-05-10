<?php
/**
 * Content Single
 *
 * Loop content in single post template (single.php)
 *
 * @package WordPress
 * @subpackage Foundation, for WordPress
 * @since Foundation, for WordPress 4.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header>
		<hgroup>
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
				<h2><?php the_title(); ?></h2>
			</a>
		</hgroup>
	</header>
	
	<div class="row meta"> <!-- meta -->
		<div class="small-6 large-6 columns"><h7><?php the_author_link(); ?></h7></div>
		<div class="small-6 large-6 columns right"><h7 class="right"><i class="general foundicon-calendar"></i> <?php the_time('j/n/Y'); ?></h7></div>
	</div> <!-- end meta -->
	<div class="row">
		<div class="large-12 columns"> <!-- content -->
			<?php the_content(); ?>
			<hr />
		</div>
		<?php if( function_exists('do_sociable')): ?>
			<div class="social-buttons large-12 columns">
				<?php do_sociable(); ?>
			</div>
		<?php endif; ?>
		<div class="large-12 columns"><?php the_tags('<span class="tag radius secondary label">','</span> <span class="tag radius secondary label">','</span>'); ?></div>
	</div>

	<footer>
	<?php //comments_template(); ?>

		<p><?php wp_link_pages(); ?></p>

		<?php // TODO get_template_part('author-box'); ?>
		
	</footer>
</article>
