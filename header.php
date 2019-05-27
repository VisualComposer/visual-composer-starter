<?php
/**
 * Header
 *
 * @package WordPress
 * @subpackage Visual Composer Starter
 * @since Visual Composer Starter 1.0
 */

?>
	<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<?php visualcomposerstarter_hook_after_head(); ?>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php wp_head() ?>
	</head>
<body <?php body_class(); ?>>
<?php if ( visualcomposerstarter_is_the_header_displayed() ) : ?>
	<?php visualcomposerstarter_hook_before_header(); ?>
	<header id="header">
		<nav class="navbar">
			<div class="<?php echo esc_attr( visualcomposerstarter_get_header_container_class() ); ?>">
				<div class="navbar-wrapper clearfix">
					<div class="navbar-header">
						<div class="navbar-brand">
							<?php
							if ( has_custom_logo() ) :
								the_custom_logo();
							else : ?>
								<h1>
									<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
										<?php bloginfo( 'name' ); ?>
									</a>
								</h1>
							<?php endif; ?>

						</div>
						<?php do_action( 'visualcomposerstarter_after_navbar_brand' ); ?>
						<?php if ( has_nav_menu( 'primary' ) ) : ?>
							<button type="button" class="navbar-toggle">
								<span class="sr-only"><?php esc_html_e( 'Toggle navigation', 'visual-composer-starter' ) ?></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						<?php endif; ?>
					</div>
					<?php if ( function_exists( 'WC' ) && get_theme_mod( 'woocommerce_header_cart_icon', true ) && wc_get_cart_url() ) : ?>
						<div class="vct-cart-wrapper">
							<a href="<?php echo esc_url( wc_get_cart_url() ); ?>">
								<svg width="32px" height="31px" viewBox="0 0 32 31" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
									<!-- Generator: Sketch 46 (44423) - http://www.bohemiancoding.com/sketch -->
									<title>supermarket</title>
									<desc>Created with Sketch.</desc>
									<defs></defs>
									<g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										<g id="Shopping-Cart-Icon" fill-rule="nonzero" fill="#2B4B80">
											<g id="supermarket">
												<path d="M23.6211985,22.5318553 C21.2916544,22.5318553 19.3964926,24.4208106 19.3964926,26.7425787 C19.3964926,29.0643468 21.2917206,30.9533021 23.6211985,30.9533021 C25.9506765,30.9533021 27.8459044,29.0643468 27.8459044,26.7425787 C27.8459044,24.4208106 25.9506765,22.5318553 23.6211985,22.5318553 Z M23.6211985,28.4268681 C22.6892353,28.4268681 21.9313162,27.6714574 21.9313162,26.7425787 C21.9313162,25.8137 22.6892353,25.0582894 23.6211985,25.0582894 C24.5531618,25.0582894 25.3110809,25.8137 25.3110809,26.7425787 C25.3110809,27.6714574 24.5531618,28.4268681 23.6211985,28.4268681 Z" id="Shape"></path>
												<path d="M31.7304632,6.25771277 C31.4905074,5.95160426 31.1225,5.77305745 30.7325882,5.77305745 L7.82338235,5.77305745 L6.68269853,1.01620638 C6.54624265,0.447785106 6.03628676,0.0465 5.44989706,0.0465 L1.26741176,0.0465 C0.567397059,0.0464340426 0,0.611953191 0,1.30965106 C0,2.00734894 0.567397059,2.57286809 1.26741176,2.57286809 L4.44950735,2.57286809 L8.56859559,19.7510234 C8.70505147,20.3199064 9.21500735,20.7207298 9.80139706,20.7207298 L27.6485662,20.7207298 C28.2311838,20.7207298 28.7389559,20.3249191 28.8787868,19.7615106 L31.962875,7.33981064 C32.0561838,6.9626 31.9704191,6.56382128 31.7304632,6.25771277 Z M26.6569779,18.1943617 L10.8017868,18.1943617 L8.42916176,8.29949149 L29.1131838,8.29949149 L26.6569779,18.1943617 Z" id="Shape"></path>
												<path d="M12.8148088,22.5318553 C10.4852647,22.5318553 8.59010294,24.4208106 8.59010294,26.7425787 C8.59010294,29.0643468 10.4853309,30.9533021 12.8148088,30.9533021 C15.1442868,30.9533021 17.0395147,29.0643468 17.0395147,26.7425787 C17.0395147,24.4208106 15.1442868,22.5318553 12.8148088,22.5318553 Z M12.8148088,28.4268681 C11.8828456,28.4268681 11.1249265,27.6714574 11.1249265,26.7425787 C11.1249265,25.8137 11.8828456,25.0582894 12.8148088,25.0582894 C13.7467721,25.0582894 14.5046912,25.8137 14.5046912,26.7425787 C14.5046912,27.6714574 13.7467721,28.4268681 12.8148088,28.4268681 Z" id="Shape"></path>
											</g>
										</g>
									</g>
								</svg>
								<span class="vct-cart-items-count">
									<?php echo esc_html( WC()->cart->get_cart_contents_count() ); ?>
								</span>
							</a>
						</div>
					<?php endif; ?>
					<?php if ( has_nav_menu( 'primary' ) ) : ?>
						<div id="main-menu">
							<div class="button-close"><span class="vct-icon-close"></span></div>
							<?php
							wp_nav_menu( array(
								'theme_location' => 'primary',
								'menu_class'     => 'nav navbar-nav',
								'container'      => '',
							) );
							?>
							<?php if ( is_active_sidebar( 'menu' ) ) : ?>
								<div class="header-widgetised-area">
									<?php dynamic_sidebar( 'menu' ); ?>
								</div>
							<?php endif; ?>
							<?php do_action( 'visualcomposerstarter_after_header_widget_area' ); ?>
						</div><!--#main-menu-->
					<?php endif; ?>
				</div><!--.navbar-wrapper-->
			</div><!--.container-->
		</nav>
		<?php do_action( 'visualcomposerstarter_after_header_menu' ); ?>
		<?php if ( is_singular() && apply_filters( 'visualcomposerstarter_single_image', true ) ) : ?>
			<div class="header-image">
				<?php visualcomposerstarter_header_featured_content(); ?>
			</div>
		<?php endif; ?>
	</header>
	<?php visualcomposerstarter_hook_after_header(); ?>
<?php endif;

