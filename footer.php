<?php
/**
 * Footer
 *
 * @package WordPress
 * @subpackage Visual Composer Starter
 * @since Visual Composer Starter 1.0
 */

if ( vct_is_the_footer_displayed() ) : ?>
	<?php vct_hook_before_footer(); ?>
	<footer id="footer">
		<?php
		if ( get_theme_mod( 'vct_footer_area_widget_area', false ) ) :
			$footer_columns = get_theme_mod( 'vct_footer_area_widgetized_columns', 1 );
			$footer_columns_width = 12 / $footer_columns;
		?>
				<div class="footer-widget-area">
					<div class="<?php echo esc_attr( vct_get_content_container_class() ); ?>">
						<div class="row">
							<div class="col-md-<?php echo esc_attr( $footer_columns_width ); ?>">
								<?php if ( is_active_sidebar( 'footer' ) ) : ?>
									<?php dynamic_sidebar( 'footer' ); ?>
								<?php endif; ?>
							</div>
							<?php for ( $i = 2; $i <= $footer_columns; $i++ ) : ?>
							<div class="col-md-<?php echo esc_attr( $footer_columns_width ); ?>">
								<?php if ( is_active_sidebar( 'footer-' . $i ) ) : ?>
									<?php dynamic_sidebar( 'footer-' . $i ); ?>
								<?php endif; ?>
							</div>
							<?php endfor; ?>
						</div>
					</div>
			</div>
		<?php endif; ?>
		<div class="footer-bottom">
			<div class="<?php echo esc_attr( vct_get_content_container_class() ); ?>">
				<?php if ( get_theme_mod( 'vct_footer_area_social_icons', false ) ) : ?>
					<div class="footer-right-block">
						<div class="footer-socials">
							<ul>
								<?php if ( strlen( get_theme_mod( 'vct_footer_area_social_link_facebook', '' ) ) ) : ?>
									<li><a target="_blank" href="<?php echo esc_url( get_theme_mod( 'vct_footer_area_social_link_facebook', '' ) ); ?>"><span class="vct-icon-facebook-with-circle"></span></a></li>
								<?php endif; ?>
								<?php if ( strlen( get_theme_mod( 'vct_footer_area_social_link_twitter', '' ) ) ) : ?>
									<li><a target="_blank" href="<?php echo esc_url( get_theme_mod( 'vct_footer_area_social_link_twitter', '' ) ); ?>"><span class="vct-icon-twitter-with-circle"></span></a></li>
								<?php endif; ?>
								<?php if ( strlen( get_theme_mod( 'vct_footer_area_social_link_linkedin', '' ) ) ) : ?>
									<li><a target="_blank" href="<?php echo esc_url( get_theme_mod( 'vct_footer_area_social_link_linkedin', '' ) ); ?>"><span class="vct-icon-linkedin-with-circle"></span></a></li>
								<?php endif; ?>
								<?php if ( strlen( get_theme_mod( 'vct_footer_area_social_link_instagram', '' ) ) ) : ?>
									<li><a target="_blank" href="<?php echo esc_url( get_theme_mod( 'vct_footer_area_social_link_instagram', '' ) ); ?>"><span class="vct-icon-instagram-with-circle"></span></a></li>
								<?php endif; ?>
								<?php if ( strlen( get_theme_mod( 'vct_footer_area_social_link_pinterest', '' ) ) ) : ?>
									<li><a target="_blank" href="<?php echo esc_url( get_theme_mod( 'vct_footer_area_social_link_pinterest', '' ) ); ?>"><span class="vct-icon-pinterest-with-circle"></span></a></li>
								<?php endif; ?>
								<?php if ( strlen( get_theme_mod( 'vct_footer_area_social_link_youtube', '' ) ) ) : ?>
									<li><a target="_blank" href="<?php echo esc_url( get_theme_mod( 'vct_footer_area_social_link_youtube', '' ) ); ?>"><span class="vct-icon-youtube-with-circle"></span></a></li>
								<?php endif; ?>
								<?php if ( strlen( get_theme_mod( 'vct_footer_area_social_link_vimeo', '' ) ) ) : ?>
									<li><a target="_blank" href="<?php echo esc_url( get_theme_mod( 'vct_footer_area_social_link_vimeo', '' ) ); ?>"><span class="vct-icon-vimeo-with-circle"></span></a></li>
								<?php endif; ?>
								<?php if ( strlen( get_theme_mod( 'vct_footer_area_social_link_flickr', '' ) ) ) : ?>
									<li><a target="_blank" href="<?php echo esc_url( get_theme_mod( 'vct_footer_area_social_link_flickr', '' ) ); ?>"><span class="vct-icon-flickr-with-circle"></span></a></li>
								<?php endif; ?>
								<?php if ( strlen( get_theme_mod( 'vct_footer_area_social_link_github', '' ) ) ) : ?>
									<li><a target="_blank" href="<?php echo esc_url( get_theme_mod( 'vct_footer_area_social_link_github', '' ) ); ?>"><span class="vct-icon-github-with-circle"></span></a></li>
								<?php endif; ?>
								<?php if ( strlen( get_theme_mod( 'vct_footer_area_social_link_email', '' ) ) ) : ?>
									<li><a href="mailto:<?php echo esc_url( get_theme_mod( 'vct_footer_area_social_link_email', '' ) ); ?>"><span class="vct-icon-mail-circle"></span></a></li>
								<?php endif; ?>

							</ul>
						</div>
					</div>
				<?php endif; ?>
				<div class="footer-left-block">
					<p class="copyright">
						<span>Copyright &copy; <?php echo esc_html( date( 'Y' ) ) ?> <?php bloginfo( 'name' ) ?>. All Rights Reserved.</span>
						<span>Proudly powered by <a href="http://visualcomposer.io/?utm_campaign=vc-theme&utm_source=vc-theme-front&utm_medium=vc-theme-footer">Visual Composer</a> and <a href="https://wordpress.org">WordPress</a></span>
					</p>
					<?php if ( has_nav_menu( 'secondary' ) ) : ?>
						<div class="footer-menu">
							<?php
							wp_nav_menu( array(
								'theme_location' => 'secondary',
							) );
							?>
						</div>
					<?php endif; ?>

				</div>
			</div>
		</div>
	</footer>
	<?php vct_hook_after_footer(); ?>
<?php endif; ?>
<?php wp_footer(); ?>
</body>
</html>
