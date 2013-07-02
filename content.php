<li class="<?php post_class(); ?>">
	<div class="ths single-featured-image">
		<div class="categories">
	   		<span class="label"><?php the_category(' & '); ?></span>
	    </div>
		<?php if (get_post_format()=="video"): ?>
		<div class="video">
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
				<i class="general icon-play-circle"></i>
			</a>
		</div>
		<?php endif; ?>
		<div class="title">
			<h3>
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
					<span><?php the_title();?></span>
				</a>
			</h3>
			<h6><?php _e('Por', 'elenanorabioso' );?> <strong><?php the_author_link(); ?></strong></h6> 
		</div>
		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
			<?php the_post_thumbnail('elenanorabioso-home');?>
		</a>
	</div>
</li>