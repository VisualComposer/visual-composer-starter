<div class="<?php echo vct_get_sidebar_class(); ?>">
	<div class="sidebar-widget-area">
<?php if ( is_active_sidebar( 'sidebar' ) ) : ?>
		<?php dynamic_sidebar( 'sidebar' ); ?>
<?php endif; ?>
	</div>
</div>
