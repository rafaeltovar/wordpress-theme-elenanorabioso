<?php
// variables
$thum_size = "elenanorabioso-home";
$thum_attr = array(); ?>

<ul class="grid small-block-grid-3 large-block-grid-4">
<?php while ( have_posts() ) : the_post(); ?>
	<li>
		<div class="single-featured-image">
			<h3><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
					<span><?php elenanorabioso_post_custom_value('discos_titulo'); ?></span>
				</a></h3>
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
				<?php the_post_thumbnail($thum_size);?>
			</a>
		</div>
		<h6><?php elenanorabioso_post_custom_value('discos_artista'); ?></h6>
		<!--<div class="row">
	    	<div class="small-12 large-12s columns">
		    	<p class="meta right">buttons</p>
		    </div>
		</div> -->
	</li>
<?php endwhile; // end of the loop. ?>
</ul>