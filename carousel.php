<?php
// get entries
$sticky = get_option('sticky_posts');

$args = array(
  	'post__in' => $sticky, 
  	'caller_get_posts' => 1 
);
  		
query_posts($args);
  		
if (have_posts()): ?>
<div id="carousel" class="row">
	<div class="large-12 column">
		<!-- Carousel items -->
		<ul data-orbit data-options="timer_speed:3000; bullets:false; stack_on_small: false">
		<?php $i=0; while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'content', 'carousel' ); ?>
	    <?php $i++; endwhile; ?>
	    </ul>
	</div>
</div> <!-- end of carousel -->
<?php endif; ?>