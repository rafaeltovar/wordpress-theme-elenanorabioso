<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  <?php wp_redirect(get_permalink($post->post_parent), 301); ?>
<?php endwhile; endif; ?>