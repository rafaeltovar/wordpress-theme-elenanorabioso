<?php echo $before_widget; ?>

<ul>
<?php if($title): ?>
 	<li class="title"><?php _e($title); ?></li>
<?php endif; // end if title ?>
<?php foreach ((array) $tags as $tag ): ?>
	<li>
		<a href="<?php echo get_tag_link($tag->term_id); ?>" rel="tag" class="<?php echo $tag->slug; ?>">
			<?php echo $tag->name; ?>
		</a>
	</li>		
<?php endforeach; ?>
</ul>
<?php echo $after_widget; ?>