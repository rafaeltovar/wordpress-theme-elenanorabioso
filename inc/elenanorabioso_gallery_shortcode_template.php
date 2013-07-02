<!-- <hr /> -->
<ul class="gallery small-block-grid-<?php echo $columns-1; ?> large-block-grid-<?php echo $columns; ?> <?php echo $selector; ?>">
<?php foreach ( $images as $image ): ?>
	<li>
		<a href="<?php echo $image['src_full'][0]; ?>" alt="<?php echo $image['alt']; ?>" title="<?php echo $image['alt']; ?>" class="ths"> 
			<?php echo wp_get_attachment_image($image['id'], $size); ?>
		</a>
	</li>
<?php endforeach; ?>
</ul>