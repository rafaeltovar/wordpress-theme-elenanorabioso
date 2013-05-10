<?php
/**
 * Header
 *
 * Setup the header for our theme
 *
 * @package WordPress
 * @subpackage Foundation, for WordPress
 * @since Foundation, for WordPress 4.0
 */
?>

<!DOCTYPE html>
<!--[if IE 8]> 				 <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->

<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php
  /*
   * Print the <title> tag based on what is being viewed.
   */
  global $page, $paged;

  wp_title( '|', true, 'right' );

  // Add the blog name.
  bloginfo( 'name' );

  // Add the blog description for the home/front page.
  $site_description = get_bloginfo( 'description', 'display' );
  if ( $site_description && ( is_home() || is_front_page() ) )
    echo " | $site_description";

  // Add a page number if necessary:
  if ( $paged >= 2 || $page >= 2 )
    echo ' | ' . sprintf( __( 'Pagina %s', 'elenanorabioso' ), max( $paged, $page ) );

  ?></title>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<!-- Set the viewport width to device width for mobile -->
<meta name="viewport" content="width=device-width" />
<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" />

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

	<header>
		<?php if ( dynamic_sidebar('Sidebar Top Header')) : endif; ?>
		<div class="nav-wrap">
			<nav class="top-bar row">
				<ul class="title-area">
					<li class="name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/logo_color.png" src="<?php bloginfo('name'); ?>" title="<?php bloginfo('name'); ?>" /></a></li>
				
					<li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
				</ul>
				<section class="top-bar-section">
				<ul class="right"> <!-- search button -->
					<li class="search-button">
						<a href="#">
							<span class="show-for-small">Buscar</span>
							<i style="color: #fff;" class="hide-for-small general foundicon-search"></i>
						</a>
					</li>
				</ul><!-- end search button -->
					<?php wp_nav_menu( array( 'theme_location' => 'header-menu', 'menu_class' => 'right', 'container' => '', 'fallback_cb' => 'foundation_page_menu', 'walker' => new foundation_navigation() ) ); ?>
				</section>
			</nav>
		</div>
		<div class="search-area">
			<?php get_search_form(); ?>
		</div>
		
		<div class="row">
			<?php if ( dynamic_sidebar('Sidebar Bottom Header One')) : endif; ?>
			<?php if ( dynamic_sidebar('Sidebar Bottom Header Two')) : endif; ?>
			<hr />
		</div>
	</header>

<!-- Begin Page -->
<div class="row">