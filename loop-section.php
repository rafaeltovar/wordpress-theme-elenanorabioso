<?php
// variables
$thum_size = "elenanorabioso-home";
$thum_attr = array(); ?>

<ul class="grid small-block-grid-2 large-block-grid-3">
<?php while ( have_posts() ) : the_post(); ?>
	<li class="<?php post_class(); ?>">
		<div class="single-featured-image">
			<?php if (get_post_format()=="video"): ?>
				<div class="video">
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
						<i class="general foundicon-video"></i>
					</a>
				</div>
			<?php endif; ?>
			<h3>
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
					<span><?php the_title();?></span>
				</a>
			</h3>
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
				<?php the_post_thumbnail($thum_size);?>
			</a>
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