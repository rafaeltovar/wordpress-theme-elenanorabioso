<hr />
<div class="row">
	<ul class="gallery small-block-grid-3 large-block-grid-4 <?php echo $selector; ?>">
	<?php foreach ( $attachments as $id => $attachment ):
		$image = wp_get_attachment_image_src( $id, 'full'); ?>
		<li>
			<a href="<?php echo $image[0]; ?>" alt="<?php echo $attachment->post_excerpt; ?>" title="<?php echo $attachment->post_title; ?>" class="th"> 
				<?php echo wp_get_attachment_image($id, 'elenanorabioso-home'); ?>
			</a>
		</li>
	<?php endforeach; ?>
	</ul>
</div>