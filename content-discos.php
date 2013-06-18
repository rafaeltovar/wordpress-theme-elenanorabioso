<li>
	<div class="single-featured-image">
		<h3><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
				<span><?php elenanorabioso_post_custom_value('discos_titulo'); ?></span>
			</a></h3>
		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
			<?php the_post_thumbnail('elenanorabioso-home');?>
		</a>
	</div>
	<h6><?php elenanorabioso_post_custom_value('discos_artista'); ?></h6>
</li>