<?php 
$thum_size = 'elenanorabioso-header';
$articles = array();
?>
<div id="carousel" class="row">
	<div class="large-12 column">
		<!-- Carousel items -->
		<ul data-orbit data-options="timer_speed:3000; bullets:false; stack_on_small: false">
		<?php $i=0; while ( have_posts() ) : the_post(); ?>
			<!-- <div class="item <?php echo ($i==0? "active": ''); ?>"> -->
			<li>
	    		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
					<?php the_post_thumbnail($thum_size);?>
				</a>
	    		<div class="orbit-caption">
	    			<h6><?php the_category(', '); ?></h6>
	        		<h4><?php the_title();?></h4>
	        	</div>
	        </li>
	    <?php $i++; endwhile; ?>
	    </ul>
	</div>
</div> <!-- end of carousel -->