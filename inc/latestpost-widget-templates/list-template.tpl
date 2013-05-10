<?php /* List template with thumbnail */ ?>

<ul class="lastposts-list small-block-grid-2 large-block-grid-1">
<?php while ( have_posts() ) : the_post(); ?>
<li>
	<div class="row">
		<div class="image small-3 large-4 columns">
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
				<?php the_post_thumbnail($image_size);?>
			</a>
		</div>
		<div class="title small-9 large-8 columns">
			<h7><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" ><span><?php the_title();?></span></a></h7>
		</div>
	</div>
	<hr />
</li>
<?php endwhile; ?>
</ul>