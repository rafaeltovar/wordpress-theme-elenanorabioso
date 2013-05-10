<?php
// variables
$thum_size = "elenanorabioso-home";
$thum_attr = array(); ?>

<ul class="grid small-block-grid-2 large-block-grid-3">
<?php while ( have_posts() ) : the_post(); ?>
	<li>
		<div class="wrap">
		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
			<?php the_post_thumbnail($thum_size);?>
		</a>
		<div class="description">
	   	<h3><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" ><span><?php the_title();?></span></a></h3>
		</div>
		</div>
	   	<div class="row">
	    	<div class="small-6 large-6 columns">
	    		<span class="label radius"><?php the_category(', '); ?></span>
	    	</div>
	    	<div class="small-6 large-6 columns">
		    	<p class="meta right"><?php //if( function_exists(do_sociable())) do_sociable(); ?></p>
		    </div>
		 </div>
	</li>
<?php endwhile; // end of the loop. ?>
</ul>