<ul class="gallery large-block-grid-1 <?php echo $selector; ?>">
<?php foreach ( $images as $image ): ?>
	<li>
		<div class="gallery-content <?php ($image[2]>$image[1]? ' vertical-photo': ''); ?>">
			<?php echo wp_get_attachment_image($image['id'], 'large'); ?><br/>
			<p><?php echo $image['alt']; ?></p>
		</div>
    </li>
<?php endforeach; ?>
</ul>