<?php get_header(); ?>

<!-- Row for main content area -->
	<div class="row" style="margin: auto; max-width: 750px;">
		<div class="small-4 large-4 columns">
			<img src="<?php echo get_template_directory_uri(); ?>/img/404.jpg" alt="404" />
		</div>
		<div class="small-8 large-8 columns">
			<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
				<header>
					<h1 class="entry-title"><?php _e('Error 404', 'elenanorabioso'); ?></h1>
					<h3 class="entry-title"><?php _e('Direcci&oacute;n no encontrada :(', 'elenanorabioso'); ?></h3>
				</header>
				<p class="bottom"><?php _e('La p&aacute;gina que est&aacute;s buscando no existe, ha sido borrada o su nombre ha sido cambiado.', 'elenanorabioso'); ?></p>
				<p><?php printf(__('Vuelva a <a href="%s">la p&aacute;gina principal</a>', 'elenanorabioso'), home_url()); ?></p>
				
			</article>
		</div>
	</div>	
<?php // get_footer(); ?>