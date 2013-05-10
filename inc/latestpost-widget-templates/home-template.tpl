<?php /* Simple template (default) */ ?>

<?php while ( have_posts() ) : the_post(); ?>
	<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
		<?php the_post_thumbnail($image_size);?>
		</a>
		<h5><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" ><span><?php the_title();?></span></a></h5>
<?php endwhile; ?>