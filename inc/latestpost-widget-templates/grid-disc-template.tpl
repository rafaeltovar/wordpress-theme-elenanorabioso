<?php /* Grid template 4x4 (discs) */ ?>

<ul class="lastposts-grid-discs small-block-grid-2 large-block-grid-2">
<?php while ( have_posts() ) : the_post(); ?>
	<li>
		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
			<?php the_post_thumbnail($image_size);?>
		</a>
		<div class="discos-artista"><span><?php elenanorabioso_post_custom_value('discos_artista'); ?></span></div>
		<h6 class="discos-titulo">
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
				<span><?php elenanorabioso_post_custom_value('discos_titulo'); ?></span>
			</a>
		</h6>
	</li>
<?php endwhile; ?>
</ul>