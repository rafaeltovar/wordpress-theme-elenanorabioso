<?php echo $before_widget; ?>

<?php if($title) echo $before_title . $title . $after_title; ?>

<?php if (have_posts()): ?>
		<?php include($template); ?>		
<?php endif; ?>

<?php echo $after_widget; ?>