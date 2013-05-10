<?php
/**
 * Searchform
 *
 * Custom template for search form
 *
 * @package WordPress
 * @subpackage Foundation, for WordPress
 * @since Foundation, for WordPress 4.0
 */
?>

<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<div class="row collapse">
				
				<div class="small-8 large-8 mobile-three columns">
					<input type="text" name="s" id="s" placeholder="<?php echo get_search_query(); ?>" />
				</div>
				<div class="small-4 large-4 mobile-one columns">
					<input type="submit" class="button prefix" id="searchsubmit" value="<?php esc_attr_e( 'Buscar', 'elenanorabioso' ); ?>" />
				</div>
				
			</div>
		</div>
	</div>
</form>