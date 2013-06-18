<li>
	<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
		<?php the_post_thumbnail('elenanorabioso-header');?>
	</a>
	<div class="orbit-caption">
		<h6><?php the_category(', '); ?></h6>
		<h4><?php the_title();?></h4>
	</div>
</li>